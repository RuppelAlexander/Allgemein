<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 13.11.2025
 * Change Date   : 13.11.2025
 * Main Program  : ISC_Ressourcenverwaltung
 * Description   : ISC_RS_ProjectTaskHook.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class ISC_RS_ProjectTaskHook
{
    const REL_TASK_USERS = 'projecttask_users_1';      // ProjectTask ↔ Users
    const REL_PROJ_USERS = 'projects_users_resources'; // Project ↔ Users
    const REL_PROJ_TASKS = 'projects_project_tasks';   // Project ↔ ProjectTask

    /**
     * after_relationship_delete:
     * - Läuft beim Entfernen eines Users aus projecttask_users_1.
     * - Entfernt den User aus der Projekt-Ressourcenbeziehung, wenn er
     *   in keiner anderen ProjectTask des Projekts mehr Ressource ist.
     */
    public function afterRelRemoveTaskUser($bean, $event, $args)
    {
        if (empty($args['relationship']) || $args['relationship'] !== self::REL_TASK_USERS) {
            return;
        }

        $userId = $args['related_id'] ?? null;
        if (empty($userId) || empty($bean->id)) {
            return;
        }

        // Projekt zur ProjectTask ermitteln
        $project = $this->getProject($bean);
        if (!$project || empty($project->id)) {
            $ptId = !empty($bean->id) ? $bean->id : 'null';
            $GLOBALS['log']->fatal("RS(PT): no Project found for ProjectTask {$ptId}");
            return;
        }

        // Prüfen, ob User noch in anderen ProjectTasks dieses Projekts Ressource ist
        $tasksLink = $this->getProjectTasksLinkName($project);
        if (!$tasksLink || !$project->load_relationship($tasksLink)) {
            $GLOBALS['log']->fatal(
                "RS(PT): failed to load ProjectTasks link {$tasksLink} on Project {$project->id}"
            );
            return;
        }

        $taskIds = (array)$project->$tasksLink->get();
        $stillInOtherTasks = false;

        foreach ($taskIds as $taskId) {
            if ($taskId === $bean->id) {
                continue;
            }

            $pt = \BeanFactory::retrieveBean('ProjectTask', $taskId, ['disable_row_level_security' => true]);
            if (empty($pt) || empty($pt->id) || !empty($pt->deleted)) {
                continue;
            }

            if ($pt->load_relationship(self::REL_TASK_USERS)) {
                $uIds = (array)$pt->{self::REL_TASK_USERS}->get();
                if (in_array($userId, $uIds, true)) {
                    $stillInOtherTasks = true;
                    break;
                }
            }
        }

        if ($stillInOtherTasks) {
            return;
        }

        // User aus Projekt-Ressourcen entfernen, falls vorhanden
        $usersLink = $this->getProjectUsersLinkName($project);
        if (!$usersLink || !$project->load_relationship($usersLink)) {
            $GLOBALS['log']->fatal(
                "RS(PT): failed to load ProjectUsers link {$usersLink} on Project {$project->id}"
            );
            return;
        }

        $projUsers = (array)$project->$usersLink->get();
        $exists = in_array($userId, $projUsers, true);

        if ($exists) {
            $project->$usersLink->delete($project->id, $userId);
        }
    }

    /**
     * Projekt zu einer ProjectTask ermitteln.
     */
    protected function getProject($projectTaskBean)
    {
        if (!empty($projectTaskBean->project_id)) {
            $proj = \BeanFactory::retrieveBean(
                'Project',
                $projectTaskBean->project_id,
                ['disable_row_level_security' => true]
            );
            if ($proj instanceof \SugarBean && !empty($proj->id) && empty($proj->deleted)) {
                return $proj;
            }
        }

        $link = 'project_name_link';
        if ($projectTaskBean->load_relationship($link)) {
            $ids = (array)$projectTaskBean->{$link}->get();
            if (!empty($ids)) {
                $pid  = reset($ids);
                $proj = \BeanFactory::retrieveBean(
                    'Project',
                    $pid,
                    ['disable_row_level_security' => true]
                );
                if ($proj instanceof \SugarBean && !empty($proj->id) && empty($proj->deleted)) {
                    return $proj;
                }
            }
        }

        if ($projectTaskBean->load_relationship(self::REL_PROJ_TASKS)) {
            $ids = (array)$projectTaskBean->{self::REL_PROJ_TASKS}->get();
            if (!empty($ids)) {
                $pid  = reset($ids);
                $proj = \BeanFactory::retrieveBean(
                    'Project',
                    $pid,
                    ['disable_row_level_security' => true]
                );
                if ($proj instanceof \SugarBean && !empty($proj->id) && empty($proj->deleted)) {
                    return $proj;
                }
            }
        }

        return null;
    }

    /**
     * Link-Name auf Project für Project ↔ Users ermitteln.
     */
    protected function getProjectUsersLinkName($projectBean)
    {
        if (!isset($projectBean->field_defs) || !is_array($projectBean->field_defs)) {
            return null;
        }

        foreach ($projectBean->field_defs as $fieldName => $def) {
            if (!is_array($def)) {
                continue;
            }
            $type = $def['type'] ?? '';
            $rel  = $def['relationship'] ?? '';
            if ($type === 'link' && $rel === self::REL_PROJ_USERS) {
                return $fieldName;
            }
        }

        return self::REL_PROJ_USERS;
    }

    /**
     * Link-Name auf Project für Project ↔ ProjectTask ermitteln.
     */
    protected function getProjectTasksLinkName($projectBean)
    {
        if (!isset($projectBean->field_defs) || !is_array($projectBean->field_defs)) {
            return null;
        }

        foreach ($projectBean->field_defs as $fieldName => $def) {
            if (!is_array($def)) {
                continue;
            }
            $type = $def['type'] ?? '';
            $rel  = $def['relationship'] ?? '';
            if ($type === 'link' && $rel === self::REL_PROJ_TASKS) {
                return $fieldName;
            }
        }

        return self::REL_PROJ_TASKS;
    }
}

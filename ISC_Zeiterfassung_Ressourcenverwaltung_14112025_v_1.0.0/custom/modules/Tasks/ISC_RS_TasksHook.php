<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.11.2025
 * Change Date   : 11.11.2025
 * Main Program  : ISC_Ressourcenverwaltung
 * Description   : ISC_RS_TasksHook.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class ISC_RS_TasksHook
{
    // Relationship-Namen als Konstanten
    private const REL_TASK_USERS = 'projecttask_users_1';
    private const REL_PROJ_USERS = 'projects_users_resources';
    private const REL_PROJ_TASKS = 'projects_project_tasks';

    // 1) before_save: Alt/Neu merken + Klarlog
    public function beforeSaveDetectChange($bean, $event = null, $args = null)
    {
        if ($bean->module_name !== 'Tasks') { return; }

        $old = $bean->fetched_row['assigned_user_id'] ?? null;
        $new = $bean->assigned_user_id ?? null;

        $bean->isc_rs_old_assigned = $old;
        $bean->isc_rs_new_assigned = $new;
        
    }

    // 2) after_save: Immer „enforcen“, sobald assigned_user_id vorhanden
    public function afterSaveSync($bean, $event = null, $args = null)
    {
        if ($bean->module_name !== 'Tasks') {
            return;
        }

        global $current_user;
        $allowed = $this->isAllowed($current_user ?? null);
        if (!$allowed) {
            return;
        }

        $old = $bean->isc_rs_old_assigned ?? null;
        $new = $bean->isc_rs_new_assigned ?? null;

        if (empty($new)) {
           
            return;
        }

        $new = $bean->isc_rs_new_assigned ?? null;
        if (empty($new)) {
            return;
        }

        // Flag aus UI: Bei Nein im Dialog wird dieses Flag gesetzt
        if (!empty($bean->isc_rs_skip_resource)) {
            return;
        }

        // ProjectTask ermitteln
        list($pt, $ptSrc) = $this->getProjectTask($bean);
        if (!$pt) {
            $taskId = !empty($bean->id) ? $bean->id : 'null';
            $GLOBALS['log']->fatal("RS(T): no ProjectTask resolved for Task {$taskId}");
            return;
        }


        // 1) ProjectTask ↔ Users
        if ($pt->load_relationship(self::REL_TASK_USERS)) {
            $ptUsers  = (array) $pt->{self::REL_TASK_USERS}->get();
            $existsPT = in_array($new, $ptUsers, true);

            if (!$existsPT) {
                $pt->{self::REL_TASK_USERS}->add($new);
                
            }
        } else {
            $GLOBALS['log']->fatal(
                "RS(T): failed to load relationship " . self::REL_TASK_USERS . " for ProjectTask {$pt->id}"
            );
        }

        // 2) Project ermitteln
        $project = $this->getProject($pt);
        if (!$project) {
            $GLOBALS['log']->fatal("RS(T): no Project found for ProjectTask {$pt->id}");
            return;
        }
        

        // Link-Name für Project ↔ Users ermitteln
        $linkName = $this->getProjectUsersLinkName($project);
        if (!$linkName) {
            $GLOBALS['log']->fatal(
                "RS(T): no link field for relationship " . self::REL_PROJ_USERS . " on Project {$project->id}"
            );
            return;
        }

        if (!$project->load_relationship($linkName)) {
            $GLOBALS['log']->fatal(
                "RS(T): failed to load relationship link {$linkName} on Project {$project->id}"
            );
            return;
        }

        $rel       = $project->$linkName;
        $projUsers = (array) $rel->get();
        $existsP   = in_array($new, $projUsers, true);

        if (!$existsP) {
            $rel->add($new);
        }
    }




    private function getProjectUsersLinkName($projectBean)
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

        // Fallback: falls Link-Name == Relationship-Name ist
        return self::REL_PROJ_USERS;
    }


    // 3) ProjectTask robust ermitteln: parent ODER Task-Relation(en)
    private function getProjectTask($taskBean): array
    {
        // Fall A: klassischer Parent
        if ($taskBean->parent_type === 'ProjectTask' && !empty($taskBean->parent_id)) {
            $pt = \BeanFactory::retrieveBean('ProjectTask', $taskBean->parent_id, ['disable_row_level_security' => true]);
            if ($pt && !empty($pt->id)) {
                return [$pt, 'parent'];
            }
        }

        // Fall B: Task → ProjectTask Relation(en) laut System
        foreach (['projecttask_tasks_1', 'project_tasks_tasks'] as $rel) {
            if ($taskBean->load_relationship($rel)) {
                $ids = (array) $taskBean->{$rel}->get();
                if (!empty($ids)) {
                    $pt = \BeanFactory::retrieveBean('ProjectTask', $ids[0], ['disable_row_level_security' => true]);
                    if ($pt && !empty($pt->id)) {
                        return [$pt, $rel];
                    }
                }
            }
        }

        return [null, null];
    }

    // 4) Project zu einer ProjectTask ermitteln (projects_project_tasks)
    public function getProject($projectTaskBean)
    {
        // 1) Schnellweg über Feld project_id
        if (!empty($projectTaskBean->project_id)) {
            $proj = \BeanFactory::retrieveBean('Project', $projectTaskBean->project_id, ['disable_row_level_security' => true]);
            $ok = ($proj instanceof \SugarBean) && !empty($proj->id) && empty($proj->deleted);
            if ($ok) {
                return $proj;
            }
        }

        // 2) Link-Name (nicht Relationship-Name): project_name_link
        $link = 'project_name_link';
        if ($projectTaskBean->load_relationship($link)) {
            $ids = (array) $projectTaskBean->{$link}->get();
            if (!empty($ids)) {
                $pid  = reset($ids);
                $proj = \BeanFactory::retrieveBean('Project', $pid, ['disable_row_level_security' => true]);
                $ok   = ($proj instanceof \SugarBean) && !empty($proj->id) && empty($proj->deleted);
                if ($ok) {
                    return $proj;
                }
            }
        }

        // 3) Fallback über Relationship-Namen (falls Link nicht verfügbar)
        $rel = self::REL_PROJ_TASKS; // 'projects_project_tasks'
        if ($projectTaskBean->load_relationship($rel)) {
            $ids = (array) $projectTaskBean->{$rel}->get();
            if (!empty($ids)) {
                $pid  = reset($ids);
                $proj = \BeanFactory::retrieveBean('Project', $pid, ['disable_row_level_security' => true]);
                $ok   = ($proj instanceof \SugarBean) && !empty($proj->id) && empty($proj->deleted);
                if ($ok) {
                    return $proj;
                }
            }
        }

        return null;
    }




    
// 5) Rollencheck + Log
    protected function isAllowed($user)
    {
        if (empty($user) || empty($user->id)) {
            return false;
        }

        if (!empty($user->is_admin)) {
            return true;
        }

        if (!class_exists('ACLRole')) {
            require_once 'modules/ACLRoles/ACLRole.php';
        }

        $roleNames = (array)\ACLRole::getUserRoleNames($user->id);

        return in_array('Zeiterfassung Admin', $roleNames, true);
    }
}

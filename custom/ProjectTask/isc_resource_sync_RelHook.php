<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.06.2025
 * Change Date   : 11.06.2025
 * Main Program  : Intern_upgrade_test_dev
 * Description   : isc_resource_sync_RelHook.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ISC_ResourceSync_RelHooks
{
    /* ---------- BEFORE ADD ---------- */
    public function beforeRelAdd($bean, $event, $args)
    {
        if (!$this->isOurLink($bean, $args)) return;
        if (!$this->isTimekeeperAdmin($GLOBALS['current_user'])) {
            throw new SugarApiExceptionNotAuthorized('LBL_NO_ACCESS');
        }
        /* ➜ Dialog auslösen */
        throw new SugarApiExceptionRequestMethodFailure('RESOURCE_DIALOG_REQUIRED');
    }

    /* ---------- AFTER ADD ---------- */
    public function afterRelAdd($bean, $event, $args)
    {
        if (!$this->isOurLink($bean, $args)) return;
        $this->addProjectResource($bean, $args['related_id']);
    }

    /* ---------- AFTER DELETE ---------- */
    public function afterRelDelete($bean, $event, $args)
    {
        if (!$this->isOurLink($bean, $args)) return;
        $this->removeProjectResourceIfOrphan($bean, $args['related_id']);
    }

    /* ---------- Helper ---------- */
    private function isOurLink($bean, $args)
    {
        return $bean->module_name === 'ProjectTask' && $args['link'] === 'projecttask_users_1';
    }

    private function isTimekeeperAdmin($user)
    {
        if (!empty($user->is_admin)) return true;
        $user->load_relationship('acl_roles');
        foreach ($user->acl_roles->getBeans() as $r) {
            if ($r->name === 'Zeiterfassungs-Admin') return true;
        }
        return false;
    }

    private function addProjectResource($taskBean, $userId)
    {
        $taskBean->load_relationship('project_task_project');
        $projectBeans = $taskBean->project_task_project->getBeans();
        if (!$projectBeans) return;
        $project = reset($projectBeans);

        $project->load_relationship('projects_users_resources');
        $existingIds = $project->projects_users_resources->get();    // Array mit IDs
        if (!in_array($userId, $existingIds)) {
            $project->projects_users_resources->add($userId);
        }
    }

    private function removeProjectResourceIfOrphan($taskBean, $userId)
    {
        global $db;

        /* steckt User noch in anderer Task desselben Projekts? */
        $sql = "SELECT 1
                  FROM project_tasks pt
                  JOIN projecttask_users_1_c rel
                    ON rel.projecttask_users_1projecttask_ida = pt.id
                 WHERE pt.project_id = '{$db->quote($taskBean->project_id)}'
                   AND rel.projecttask_users_1users_idb = '{$db->quote($userId)}'
                   AND pt.deleted = 0
                   AND rel.deleted = 0
                 LIMIT 1";
        if ($db->fetchByAssoc($db->query($sql))) return;   // noch gebraucht

        $project = BeanFactory::getBean('Project', $taskBean->project_id);
        if ($project) {
            $project->load_relationship('projects_users_resources');
            $project->projects_users_resources->delete($userId);
        }
    }
}

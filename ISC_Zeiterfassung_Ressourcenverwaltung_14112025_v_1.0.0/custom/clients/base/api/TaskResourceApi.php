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
 * Description   : TaskResourceApi.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

// custom/clients/base/api/TaskResourceApi.php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use SugarApi;
use BeanFactory;
use SugarApiExceptionMissingParameter;
use SugarApiExceptionNotAuthorized;

class TaskResourceApi extends SugarApi
{
    /**
     * API-Registrierung.
     */
    public function registerApiRest()
    {
        return [
            'TasksResourceStatus' => array(
                'reqType'    => 'GET',
                'path'       => array('TasksResourceStatus'),
                'pathVars'   => array(''),
                'method'     => 'getResourceStatus',
                'jsonParams' => array(),
                'shortHelp'  => 'Check if a user is already a resource of a ProjectTask',
            ),
            'TasksResourceAccess' => array(
                'reqType'    => 'GET',
                'path'       => array('TasksResourceAccess'),
                'pathVars'   => array(''),
                'method'     => 'getAccessStatus',
                'jsonParams' => array(),
                'shortHelp'  => 'Check if current user is allowed to manage resources',
            ),
        ];
    }

    /**
     * Liefert nur allowed = true/false für den aktuellen Benutzer.
     */
    public function getAccessStatus($api, $args)
    {
        global $current_user;

        $allowed = $this->isAllowed($current_user ?? null);

        return array(
            'allowed' => (bool)$allowed,
        );
    }


    /**
     * Prüft, ob der Benutzer bereits in projecttask_users_1 der ProjectTask hängt.
     */
    public function getResourceStatus($api, $args)
    {
        global $current_user;

        if (empty($args['pt_id'])) {
            $GLOBALS['log']->fatal('RS(API): Missing parameter pt_id');
            throw new SugarApiExceptionMissingParameter('Missing parameter: pt_id');
        }
        if (empty($args['user_id'])) {
            $GLOBALS['log']->fatal('RS(API): Missing parameter user_id');
            throw new SugarApiExceptionMissingParameter('Missing parameter: user_id');
        }

        if (!$this->isAllowed($current_user)) {
            $userId = $current_user && !empty($current_user->id) ? $current_user->id : 'unknown';
            $GLOBALS['log']->fatal("RS(API): Not authorized for TasksResourceStatus | user_id={$userId}");
            throw new SugarApiExceptionNotAuthorized('Not authorized for TasksResourceStatus');
        }

        $ptId   = $args['pt_id'];
        $userId = $args['user_id'];

        $projectTask = BeanFactory::retrieveBean(
            'ProjectTask',
            $ptId,
            ['disable_row_level_security' => true]
        );

        if (empty($projectTask) || empty($projectTask->id) || !empty($projectTask->deleted)) {
            $GLOBALS['log']->fatal("RS(API): ProjectTask not found or deleted | pt_id={$ptId}");
            return ['exists' => false];
        }

        $relName = 'projecttask_users_1';

        if (!$projectTask->load_relationship($relName)) {
            $GLOBALS['log']->fatal("RS(API): Failed to load relationship {$relName} | pt_id={$projectTask->id}");
            return ['exists' => false];
        }

        $ids    = (array)$projectTask->$relName->get();
        $exists = in_array($userId, $ids, true);

        return ['exists' => (bool)$exists];
    }

    /**
     * Berechtigungsprüfung: Admin oder Rolle "Zeiterfassungs-Admin".
     */
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



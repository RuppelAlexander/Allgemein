<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : MoschkauM
 * Create Date   : 28.02.2025
 * Change Date   : 28.02.2025
 * Main Program  : Zeiterfassung Usability-Anpassungen
 * Description   : Layout List View
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 28.02.2025  MM       insert isc_abbreviation
 * ----------------------------------------------------------------------------
 */
$viewdefs['Tasks'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 =>
              // ISC GmbH, MM, 2025-02-28 : begin insert isc_abbreviation
              array (
                'name' => 'name',
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_LIST_SUBJECT',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'abbreviation_tasks_c',
                    'type' => 'isc_abbreviation',
                  ),
                  1 => 
                  array (
                    'name' => 'name',
                    'link' => true,
                  ),
                ),
                'default' => true,
                'enabled' => true,
              ),
              // ISC GmbH, MM, 2025-02-28 : end  insert isc_abbreviation
              1 => 
              array (
                'name' => 'date_due',
                'label' => 'LBL_LIST_DUE_DATE',
                'type' => 'datetimecombo-colorcoded',
                'completed_status_value' => 'Completed',
                'link' => false,
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'time_due',
                'default' => true,
                'enabled' => true,
                'label' => 'LBL_LIST_DUE_TIME',
                'sortable' => false,
                'link' => false,
              ),
              3 => 
              array (
                'name' => 'status',
                'label' => 'LBL_LIST_STATUS',
                'link' => false,
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'date_end_c',
                'default' => true,
                'enabled' => true,
                'type' => 'datetime',
                'label' => 'LBL_DATE_END',
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
                'id' => 'ASSIGNED_USER_ID',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'accounts_tasks_1_name',
                'label' => 'LBL_ACCOUNTS_TASKS_1_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'ACCOUNTS_TASKS_1ACCOUNTS_IDA',
                'link' => true,
                'sortable' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
              ),
              8 => 
              array (
                'name' => 'date_start',
                'label' => 'LBL_LIST_START_DATE',
                'link' => false,
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'comment_c',
                'default' => false,
                'enabled' => true,
                'type' => 'text',
                'studio' => 'visible',
                'label' => 'LBL_COMMENT',
                'sortable' => false,
              ),
              10 => 
              array (
                'name' => 'priority',
                'default' => false,
                'enabled' => true,
                'type' => 'enum',
                'label' => 'LBL_PRIORITY',
                'sortable' => false,
              ),
              11 => 
              array (
                'name' => 'description',
                'default' => false,
                'enabled' => true,
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
              ),
              12 => 
              array (
                'name' => 'initiator_c',
                'label' => 'LBL_INITIATOR',
                'enabled' => true,
                'id' => 'USER_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'developer_c',
                'label' => 'LBL_DEVELOPER',
                'enabled' => true,
                'id' => 'USER_ID1_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'project_c',
                'label' => 'LBL_PROJECT',
                'enabled' => true,
                'id' => 'project_id_c',
                'link' => true,
                'sortable' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'projecttask_tasks_1_name',
                'label' => 'LBL_PROJECTTASK_TASKS_1_FROM_PROJECTTASK_TITLE',
                'enabled' => true,
                'id' => 'PROJECTTASK_TASKS_1PROJECTTASK_IDA',
                'link' => true,
                'sortable' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => false,
                'readonly' => true,
              ),
              17 => 
              array (
                'name' => 'parent_type',
                'default' => false,
                'enabled' => true,
                'type' => 'parent_type',
                'label' => 'LBL_PARENT_NAME',
              ),
              18 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_LIST_RELATED_TO',
                'dynamic_module' => 'PARENT_TYPE',
                'id' => 'PARENT_ID',
                'link' => true,
                'enabled' => true,
                'default' => false,
                'sortable' => false,
                'ACLTag' => 'PARENT',
                'related_fields' => 
                array (
                  0 => 'parent_id',
                  1 => 'parent_type',
                ),
              ),
              19 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);

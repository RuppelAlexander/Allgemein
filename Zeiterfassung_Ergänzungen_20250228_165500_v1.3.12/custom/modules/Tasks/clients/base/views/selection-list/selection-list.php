<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 17.11.2022
 * Change Date   : 04.01.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : selection-list View
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$viewdefs['Tasks']['base']['view']['selection-list'] = array(
	'panels' => array(
		array(
			'label'  => 'LBL_PANEL_1',
			'fields' => array(
				array(
					'name'    => 'name',
					'link'    => true,
					'label'   => 'LBL_LIST_SUBJECT',
					'enabled' => true,
					'default' => true,
				),
				array(
					'name'     => 'comment_c',
					'default'  => true,
					'enabled'  => true,
					'type'     => 'text',
					'studio'   => 'visible',
					'label'    => 'LBL_COMMENT',
					'sortable' => false,
				),
				array(
					'name'                   => 'date_due',
					'label'                  => 'LBL_LIST_DUE_DATE',
					'type'                   => 'datetimecombo-colorcoded',
					'completed_status_value' => 'Completed',
					'link'                   => false,
					'enabled'                => true,
					'default'                => true,
				),
				array(
					'name'     => 'time_due',
					'default'  => false,
					'enabled'  => true,
					'label'    => 'LBL_LIST_DUE_TIME',
					'sortable' => false,
					'link'     => false,
				),
				array(
					'name'    => 'status',
					'label'   => 'LBL_LIST_STATUS',
					'link'    => false,
					'enabled' => true,
					'default' => true,
				),
				array(
					'name'    => 'date_end_c',
					'default' => true,
					'enabled' => true,
					'type'    => 'datetime',
					'label'   => 'LBL_DATE_END',
				),
				array(
					'name'    => 'date_modified',
					'enabled' => true,
					'default' => true,
					'type'    => 'datetime',
					'label'   => 'LBL_DATE_MODIFIED',
				),
				array(
					'name'    => 'assigned_user_name',
					'label'   => 'LBL_LIST_ASSIGNED_TO_NAME',
					'id'      => 'ASSIGNED_USER_ID',
					'enabled' => true,
					'default' => false,
				),
				array(
					'name'    => 'date_start',
					'label'   => 'LBL_LIST_START_DATE',
					'link'    => false,
					'enabled' => true,
					'default' => false,
				),
				array(
					'name'     => 'priority',
					'default'  => false,
					'enabled'  => true,
					'type'     => 'enum',
					'label'    => 'LBL_PRIORITY',
					'sortable' => false,
				),
				array(
					'name'     => 'description',
					'default'  => false,
					'enabled'  => true,
					'type'     => 'text',
					'label'    => 'LBL_DESCRIPTION',
					'sortable' => false,
				),

				array(
					'name'     => 'initiator_c',
					'label'    => 'LBL_INITIATOR',
					'enabled'  => true,
					'id'       => 'USER_ID_C',
					'link'     => true,
					'sortable' => false,
					'default'  => false,
				),
				array(
					'name'     => 'developer_c',
					'label'    => 'LBL_DEVELOPER',
					'enabled'  => true,
					'id'       => 'USER_ID1_C',
					'link'     => true,
					'sortable' => false,
					'default'  => false,
				),
				array(
					'name'     => 'accounts_tasks_1_name',
					'label'    => 'LBL_ACCOUNTS_TASKS_1_FROM_ACCOUNTS_TITLE',
					'enabled'  => true,
					'id'       => 'ACCOUNTS_TASKS_1ACCOUNTS_IDA',
					'link'     => true,
					'sortable' => false,
					'default'  => false,
				),
				array(
					'name'     => 'project_c',
					'label'    => 'LBL_PROJECT',
					'enabled'  => true,
					'id'       => 'PROJECT_ID_C',
					'link'     => true,
					'sortable' => false,
					'default'  => false,
				),
				array(
					'name'     => 'projecttask_tasks_1_name',
					'label'    => 'LBL_PROJECTTASK_TASKS_1_FROM_PROJECTTASK_TITLE',
					'enabled'  => true,
					'id'       => 'PROJECTTASK_TASKS_1PROJECTTASK_IDA',
					'link'     => true,
					'sortable' => false,
					'default'  => false,
				),
				array(
					'name'    => 'parent_type',
					'default' => false,
					'enabled' => true,
					'type'    => 'parent_type',
					'label'   => 'LBL_PARENT_NAME',
				),
				array(
					'name'           => 'parent_name',
					'label'          => 'LBL_LIST_RELATED_TO',
					'dynamic_module' => 'PARENT_TYPE',
					'id'             => 'PARENT_ID',
					'link'           => true,
					'enabled'        => true,
					'default'        => false,
					'sortable'       => false,
					'ACLTag'         => 'PARENT',
					'related_fields' =>
						array(
							0 => 'parent_id',
							1 => 'parent_type',
						),
				),
				array(
					'name'     => 'date_entered',
					'label'    => 'LBL_DATE_ENTERED',
					'enabled'  => true,
					'default'  => false,
					'readonly' => true,
				),
				array(
					'name'    => 'team_name',
					'label'   => 'LBL_LIST_TEAM',
					'enabled' => true,
					'default' => false,
				),
			),
		),
	),
);

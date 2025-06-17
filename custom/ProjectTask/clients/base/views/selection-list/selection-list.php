<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 04.01.2023
 * Change Date   : 04.01.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : selection-list View
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$viewdefs['ProjectTask']['base']['view']['selection-list'] = array(
	'panels' => array(
		array(
			'label'  => 'LBL_PANEL_1',
			'fields' => array(
				array(
					'label'    => 'LBL_LIST_NAME',
					'enabled'  => true,
					'default'  => true,
					'readonly' => true,
					'name'     => 'name',
					'link'     => true,
					'width'    => '40',
				),
				array(
					'name'     => 'ticket_c',
					'label'    => 'LBL_TICKET',
					'enabled'  => true,
					'id'       => 'ACASE_ID_C',
					'link'     => true,
					'sortable' => false,
					'width'    => '10',
					'default'  => true,
				),
				array(
					'label'   => 'LBL_PROJECT_NAME',
					'enabled' => true,
					'default' => true,
					'name'    => 'project_name',
					'id'      => 'project_id',
					'link'    => true,
					'width'   => '25',
				),
				array(
					'label'   => 'LBL_DATE_START',
					'enabled' => true,
					'default' => true,
					'name'    => 'date_start',
					'width'   => '10',
				),
				array(
					'label'   => 'LBL_DATE_FINISH',
					'enabled' => true,
					'default' => true,
					'name'    => 'date_finish',
					'width'   => '10',
				),
				array(
					'label'   => 'LBL_LIST_PRIORITY',
					'enabled' => true,
					'default' => true,
					'name'    => 'priority',
					'width'   => '10',
				),
				array(
					'name'    => 'status',
					'label'   => 'LBL_STATUS',
					'enabled' => true,
					'width'   => '10',
					'default' => true,
				),
				array(
					'name'              => 'assigned_user_name',
					'target_record_key' => 'assigned_user_id',
					'target_module'     => 'Employees',
					'label'             => 'LBL_ASSIGNED_TO_NAME',
					'enabled'           => true,
					'default'           => true,
					'width'             => '10',
				),
				array(
					'name'    => 'faktura_c',
					'label'   => 'LBL_FAKTURA',
					'enabled' => true,
					'width'   => '10',
					'default' => true,
				),

				array(
					'name'     => 'team_name',
					'label'    => 'LBL_TEAMS',
					'enabled'  => true,
					'id'       => 'TEAM_ID',
					'link'     => true,
					'sortable' => false,
					'width'    => '2',
					'default'  => false,
				),
			),
		),
	)
);

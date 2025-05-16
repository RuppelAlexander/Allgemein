<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 17.11.2022
 * Change Date   : 17.11.2022
 * Main Program  : isc_ZE_task_rel
 * Description   : Subpanel
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$viewdefs['ISC_Zeiterfassung']['base']['view']['subpanel-for-tasks'] = array(
	'panels'  => array(
		array(
			'name'   => 'panel_header',
			'label'  => 'LBL_PANEL_1',
			'fields' => array(
				array(
					'name'           => 'description',
					'label'          => 'LBL_DESCRIPTION',
					'enabled'        => true,
					'sortable'       => false,
					'default'        => true,
					'type'           => 'name',
					'link'           => true,
					'related_fields' => array(
						'name',
					),
				),
				array(
					'name'    => 'date_from',
					'label'   => 'LBL_DATE_FROM',
					'enabled' => true,
					'default' => true,
				),
				array(
					'name'    => 'date_to',
					'label'   => 'LBL_DATE_TO',
					'enabled' => true,
					'default' => true,
				),
				array(
					'name'     => 'project_isc_zeiterfassung_1_name',
					'label'    => 'LBL_PROJECT_ISC_ZEITERFASSUNG_1_FROM_PROJECT_TITLE',
					'enabled'  => true,
					'id'       => 'PROJECT_ISC_ZEITERFASSUNG_1PROJECT_IDA',
					'link'     => true,
					'sortable' => false,
					'default'  => true,
				),
				array(
					'name'     => 'projecttask_isc_zeiterfassung_1_name',
					'label'    => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_PROJECTTASK_TITLE',
					'enabled'  => true,
					'id'       => 'PROJECTTASK_ISC_ZEITERFASSUNG_1PROJECTTASK_IDA',
					'link'     => true,
					'sortable' => false,
					'default'  => true,
				),
				array(
					'name'    => 'working_hours',
					'label'   => 'LBL_WORKING_HOURS',
					'enabled' => true,
					'default' => true,
					'width'   => 'small',
				),
				array(
					'name'    => 'billing',
					'label'   => 'LBL_BILLING',
					'enabled' => true,
					'default' => true,
				),
				array(
					'name'           => 'assigned_user_name',
					'label'          => 'LBL_ASSIGNED_TO',
					'enabled'        => true,
					'related_fields' => array(
						'assigned_user_id',
					),
					'id'             => 'ASSIGNED_USER_ID',
					'link'           => true,
					'default'        => true,
				),

			),
		),
	),
	'orderBy' => array(
		'field'     => 'date_modified',
		'direction' => 'desc',
	),
	'type'    => 'subpanel-list',
);

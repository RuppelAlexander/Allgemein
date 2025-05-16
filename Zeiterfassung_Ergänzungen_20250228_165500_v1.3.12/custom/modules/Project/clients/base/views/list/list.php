<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['Project']['base']['view']['list'] = array(
	'panels' => array(
		array(
			'label'  => 'LBL_PANEL_1',
			'fields' => array(
				array(
					'label'   => 'LBL_LIST_NAME',
					'enabled' => true,
					'default' => true,
					'name'    => 'name',
					'link'    => true,
				),
				array(
					'label'   => 'LBL_STATUS',
					'name'    => 'status',
					'enabled' => true,
					'default' => true
				),
				array(
					'label'   => 'LBL_PRIORITY',
					'name'    => 'priority',
					'enabled' => true,
					'default' => true
				),
				array(
					'label'   => 'LBL_DATE_START',
					'enabled' => true,
					'default' => true,
					'name'    => 'estimated_start_date',
				),
				array(
					'label'   => 'LBL_DATE_END',
					'enabled' => true,
					'default' => true,
					'name'    => 'estimated_end_date',
				),
				array(
					'label'   => 'LBL_KOORDINATOR',
					'name'    => 'koordinator_c',
					'enabled' => true,
					'default' => true
				),
				array(
					'label'   => 'LBL_PROJEKTLEITUNG',
					'name'    => 'projektleitung_c',
					'enabled' => true,
					'default' => true
				),
				array(
					'target_record_key' => 'assigned_user_id',
					'target_module'     => 'Users',
					'label'             => 'LBL_LIST_ASSIGNED_USER_ID',
					'enabled'           => true,
					'default'           => true,
					'name'              => 'assigned_user_name',
					'sortable'          => false,
				),
				array (
					'name' => 'team_name',
					'label' => 'LBL_TEAM',
					'default' => false,
					'enabled' => true,
				),
				array(
					'name' => 'date_modified',
					'enabled' => true,
					'default' => false,
				),
				array (
					'name' => 'modified_by_name',
					'label' => 'LBL_MODIFIED',
					'enabled' => false,
					'readonly' => true,
					'id' => 'MODIFIED_USER_ID',
					'link' => true,
					'default' => false,
				),
			),
		),
	),
);

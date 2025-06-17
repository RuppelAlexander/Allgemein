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
$viewdefs['ProjectTask']['base']['view']['search-list'] = array(
	'panels' => array(
		array(
			'name'   => 'primary',
			'fields' => array(
				array(
					'name'      => 'picture',
					'type'      => 'avatar',
					'size'      => 'medium',
					'readonly'  => true,
					'css_class' => 'pull-left'
				),
				array(
					'name'  => 'name',
					'type'  => 'name',
					'link'  => true,
					'label' => 'LBL_NAME'
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
					'label'   => 'LBL_LIST_PERCENT_COMPLETE',
					'enabled' => true,
					'default' => true,
					'name'    => 'percent_complete',
					'width'   => '10',
				),
				array(
					'name'    => 'status',
					'label'   => 'LBL_STATUS',
					'enabled' => true,
					'width'   => '10',
					'default' => true,
				),
			),
		),
		array(
			'name'   => 'secondary',
			'fields' => array(
				'status',
			),
		),
	),
);

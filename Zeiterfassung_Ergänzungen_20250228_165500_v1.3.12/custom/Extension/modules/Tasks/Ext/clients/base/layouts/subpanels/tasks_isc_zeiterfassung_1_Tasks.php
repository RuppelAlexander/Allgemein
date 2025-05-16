<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : dontg
 * Create Date   : 23.11.2022
 * Change Date   : 23.11.2022
 * Main Program  : tt_taskbtn
 * Description   : Subpanel Button Logik for Tasks
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$viewdefs['Tasks']['base']['layout']['subpanels']['components'][] = array(
	'layout'                 => 'subpanel',
	'label'                  => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE',
	'override_paneltop_view' => 'panel-top-for-task',
	'override_subpanel_list_view' => 'subpanel-for-tasks',
	'context'                =>
		array(
			'link' => 'tasks_isc_zeiterfassung_1',
		),
);

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
 * Description   : Extra Felder
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

$dictionary["Task"]["fields"]["projecttask_tasks_1"] = array(
	'name'         => 'projecttask_tasks_1',
	'type'         => 'link',
	'relationship' => 'projecttask_tasks_1',
	'source'       => 'non-db',
	'module'       => 'ProjectTask',
	'bean_name'    => 'ProjectTask',
	'side'         => 'right',
	'vname'        => 'LBL_PROJECTTASK_TASKS_1_FROM_TASKS_TITLE',
	'id_name'      => 'projecttask_tasks_1projecttask_ida',
	'link-type'    => 'one',
);
$dictionary["Task"]["fields"]["projecttask_tasks_1_name"] = array(
	'name'             => 'projecttask_tasks_1_name',
	'type'             => 'relate',
	'source'           => 'non-db',
	'vname'            => 'LBL_PROJECTTASK_TASKS_1_FROM_PROJECTTASK_TITLE',
	'save'             => true,
	'id_name'          => 'projecttask_tasks_1projecttask_ida',
	'link'             => 'projecttask_tasks_1',
	'table'            => 'project_task',
	'module'           => 'ProjectTask',
	'rname'            => 'name',
	'required'         => true,
	'required_formula' => '',
	'auto_populate'    => true,
	'populate_list'    => array(
		'project_id'   => 'project_id_c',
		'project_name' => 'project_c',
	),
);
$dictionary["Task"]["fields"]["projecttask_tasks_1projecttask_ida"] = array(
	'name'            => 'projecttask_tasks_1projecttask_ida',
	'type'            => 'id',
	'source'          => 'non-db',
	'vname'           => 'LBL_PROJECTTASK_TASKS_1_FROM_TASKS_TITLE_ID',
	'id_name'         => 'projecttask_tasks_1projecttask_ida',
	'link'            => 'projecttask_tasks_1',
	'table'           => 'project_task',
	'module'          => 'ProjectTask',
	'rname'           => 'id',
	'reportable'      => false,
	'side'            => 'right',
	'massupdate'      => false,
	'duplicate_merge' => 'disabled',
	'hideacl'         => true,
);

?>

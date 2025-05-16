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
$dictionary["Task"]["fields"]["accounts_tasks_1"] = array(
	'name'         => 'accounts_tasks_1',
	'type'         => 'link',
	'relationship' => 'accounts_tasks_1',
	'source'       => 'non-db',
	'module'       => 'Accounts',
	'bean_name'    => 'Account',
	'side'         => 'right',
	'vname'        => 'LBL_ACCOUNTS_TASKS_1_FROM_TASKS_TITLE',
	'id_name'      => 'accounts_tasks_1accounts_ida',
	'link-type'    => 'one',
);
$dictionary["Task"]["fields"]["accounts_tasks_1_name"] = array(
	'name'    => 'accounts_tasks_1_name',
	'type'    => 'relate',
	'source'  => 'non-db',
	'vname'   => 'LBL_ACCOUNTS_TASKS_1_FROM_ACCOUNTS_TITLE',
	'save'    => true,
	'id_name' => 'accounts_tasks_1accounts_ida',
	'link'    => 'accounts_tasks_1',
	'table'   => 'accounts',
	'module'  => 'Accounts',
	'rname'   => 'name',
	'required' => true,
	'required_formula'=>'',
	'readonly' => true,
    'readonly_formula'=>'',
);
$dictionary["Task"]["fields"]["accounts_tasks_1accounts_ida"] = array(
	'name'            => 'accounts_tasks_1accounts_ida',
	'type'            => 'id',
	'source'          => 'non-db',
	'vname'           => 'LBL_ACCOUNTS_TASKS_1_FROM_TASKS_TITLE_ID',
	'id_name'         => 'accounts_tasks_1accounts_ida',
	'link'            => 'accounts_tasks_1',
	'table'           => 'accounts',
	'module'          => 'Accounts',
	'rname'           => 'id',
	'reportable'      => false,
	'side'            => 'right',
	'massupdate'      => false,
	'duplicate_merge' => 'disabled',
	'hideacl'         => true,
);

 ?>
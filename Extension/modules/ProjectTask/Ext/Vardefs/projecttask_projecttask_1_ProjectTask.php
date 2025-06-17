<?php
// created: 2018-01-29 09:55:45
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1"] = array (
  'name' => 'projecttask_projecttask_1',
  'type' => 'link',
  'relationship' => 'projecttask_projecttask_1',
  'source' => 'non-db',
  'module' => 'ProjectTask',
  'bean_name' => 'ProjectTask',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_L_TITLE',
  'id_name' => 'projecttask_projecttask_1projecttask_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1_right"] = array (
  'name' => 'projecttask_projecttask_1_right',
  'type' => 'link',
  'relationship' => 'projecttask_projecttask_1',
  'source' => 'non-db',
  'module' => 'ProjectTask',
  'bean_name' => 'ProjectTask',
  'side' => 'right',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_R_TITLE',
  'id_name' => 'projecttask_projecttask_1projecttask_ida',
  'link-type' => 'one',
);
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1_name"] = array (
  'name' => 'projecttask_projecttask_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_L_TITLE',
  'save' => true,
  'id_name' => 'projecttask_projecttask_1projecttask_ida',
  'link' => 'projecttask_projecttask_1_right',
  'table' => 'project_task',
  'module' => 'ProjectTask',
  'rname' => 'name',
);
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1projecttask_ida"] = array (
  'name' => 'projecttask_projecttask_1projecttask_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_R_TITLE_ID',
  'id_name' => 'projecttask_projecttask_1projecttask_ida',
  'link' => 'projecttask_projecttask_1_right',
  'table' => 'project_task',
  'module' => 'ProjectTask',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);

<?php
// created: 2022-11-17 15:03:46
$dictionary["ISC_Zeiterfassung"]["fields"]["tasks_isc_zeiterfassung_1"] = array (
  'name' => 'tasks_isc_zeiterfassung_1',
  'type' => 'link',
  'relationship' => 'tasks_isc_zeiterfassung_1',
  'source' => 'non-db',
  'module' => 'Tasks',
  'bean_name' => 'Task',
  'side' => 'right',
  'vname' => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE',
  'id_name' => 'tasks_isc_zeiterfassung_1tasks_ida',
  'link-type' => 'one',
);
$dictionary["ISC_Zeiterfassung"]["fields"]["tasks_isc_zeiterfassung_1_name"] = array (
  'name' => 'tasks_isc_zeiterfassung_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_TASKS_TITLE',
  'save' => true,
  'id_name' => 'tasks_isc_zeiterfassung_1tasks_ida',
  'link' => 'tasks_isc_zeiterfassung_1',
  'table' => 'tasks',
  'module' => 'Tasks',
  'rname' => 'name',
);
$dictionary["ISC_Zeiterfassung"]["fields"]["tasks_isc_zeiterfassung_1tasks_ida"] = array (
  'name' => 'tasks_isc_zeiterfassung_1tasks_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE_ID',
  'id_name' => 'tasks_isc_zeiterfassung_1tasks_ida',
  'link' => 'tasks_isc_zeiterfassung_1',
  'table' => 'tasks',
  'module' => 'Tasks',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);


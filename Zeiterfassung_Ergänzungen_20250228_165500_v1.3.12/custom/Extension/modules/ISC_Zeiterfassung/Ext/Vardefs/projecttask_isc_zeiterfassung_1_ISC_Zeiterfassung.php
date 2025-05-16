<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 21.12.2017
 * Change Date   : 14.12.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Zeiterfassung Ergänzungen
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 09.08.2018  TF      Korrektur der Labelverweise
 * ----------------------------------------------------------------------------
 */

// created: 2017-12-21 10:19:43
$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1"] = array (
  'name' => 'projecttask_isc_zeiterfassung_1',
  'type' => 'link',
  'relationship' => 'projecttask_isc_zeiterfassung_1',
  'source' => 'non-db',
  'module' => 'ProjectTask',
  'bean_name' => 'ProjectTask',
  'side' => 'right',
  //ISC TF, 2018-08-09: Korrektur der Labels
  'vname' => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_PROJECTTASK_TITLE',
  'id_name' => 'projecttask_isc_zeiterfassung_1projecttask_ida',
  'link-type' => 'one',
);
$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"] = array (
  'name' => 'projecttask_isc_zeiterfassung_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_PROJECTTASK_TITLE',
  'save' => true,
  'id_name' => 'projecttask_isc_zeiterfassung_1projecttask_ida',
  'link' => 'projecttask_isc_zeiterfassung_1',
  'table' => 'project_task',
  'module' => 'ProjectTask',
  'rname' => 'name',
);
$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1projecttask_ida"] = array (
  'name' => 'projecttask_isc_zeiterfassung_1projecttask_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE_ID',
  'id_name' => 'projecttask_isc_zeiterfassung_1projecttask_ida',
  'link' => 'projecttask_isc_zeiterfassung_1',
  'table' => 'project_task',
  'module' => 'ProjectTask',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);

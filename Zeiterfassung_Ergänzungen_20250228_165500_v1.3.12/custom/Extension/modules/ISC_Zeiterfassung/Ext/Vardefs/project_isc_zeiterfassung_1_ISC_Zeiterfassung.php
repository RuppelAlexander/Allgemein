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
$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1"] = array (
  'name' => 'project_isc_zeiterfassung_1',
  'type' => 'link',
  'relationship' => 'project_isc_zeiterfassung_1',
  'source' => 'non-db',
  'module' => 'Project',
  'bean_name' => 'Project',
  'side' => 'right',
  //ISC TF, 2018-08-09: Korrektur der Labels
  'vname' => 'LBL_PROJECT_ISC_ZEITERFASSUNG_1_FROM_PROJECT_TITLE',
  'id_name' => 'project_isc_zeiterfassung_1project_ida',
  'link-type' => 'one',
);
$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"] = array (
  'name' => 'project_isc_zeiterfassung_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECT_ISC_ZEITERFASSUNG_1_FROM_PROJECT_TITLE',
  'save' => true,
  'id_name' => 'project_isc_zeiterfassung_1project_ida',
  'link' => 'project_isc_zeiterfassung_1',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'name',
);
$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1project_ida"] = array (
  'name' => 'project_isc_zeiterfassung_1project_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECT_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE_ID',
  'id_name' => 'project_isc_zeiterfassung_1project_ida',
  'link' => 'project_isc_zeiterfassung_1',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);

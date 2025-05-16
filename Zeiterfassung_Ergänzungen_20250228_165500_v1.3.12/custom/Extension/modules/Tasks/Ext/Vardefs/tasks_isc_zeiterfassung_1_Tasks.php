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
$dictionary["Task"]["fields"]["tasks_isc_zeiterfassung_1"] = array (
  'name' => 'tasks_isc_zeiterfassung_1',
  'type' => 'link',
  'relationship' => 'tasks_isc_zeiterfassung_1',
  'source' => 'non-db',
  'module' => 'ISC_Zeiterfassung',
  'bean_name' => 'ISC_Zeiterfassung',
  'vname' => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_TASKS_TITLE',
  'id_name' => 'tasks_isc_zeiterfassung_1tasks_ida',
  'link-type' => 'many',
  'side' => 'left',
);

 ?>
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
$dictionary["tasks_isc_zeiterfassung_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'tasks_isc_zeiterfassung_1' => 
    array (
      'lhs_module' => 'Tasks',
      'lhs_table' => 'tasks',
      'lhs_key' => 'id',
      'rhs_module' => 'ISC_Zeiterfassung',
      'rhs_table' => 'isc_zeiterfassung',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'tasks_isc_zeiterfassung_1_c',
      'join_key_lhs' => 'tasks_isc_zeiterfassung_1tasks_ida',
      'join_key_rhs' => 'tasks_isc_zeiterfassung_1isc_zeiterfassung_idb',
    ),
  ),
  'table' => 'tasks_isc_zeiterfassung_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'tasks_isc_zeiterfassung_1tasks_ida' => 
    array (
      'name' => 'tasks_isc_zeiterfassung_1tasks_ida',
      'type' => 'id',
    ),
    'tasks_isc_zeiterfassung_1isc_zeiterfassung_idb' => 
    array (
      'name' => 'tasks_isc_zeiterfassung_1isc_zeiterfassung_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_tasks_isc_zeiterfassung_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_tasks_isc_zeiterfassung_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tasks_isc_zeiterfassung_1tasks_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_tasks_isc_zeiterfassung_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'tasks_isc_zeiterfassung_1isc_zeiterfassung_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'tasks_isc_zeiterfassung_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'tasks_isc_zeiterfassung_1isc_zeiterfassung_idb',
      ),
    ),
  ),
);
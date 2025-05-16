<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 03.12.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Fixed wrong indexes
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
// created: 2018-10-23 12:29:33
$dictionary['projecttask_users_1'] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'projecttask_users_1' => 
    array (
      'lhs_module' => 'ProjectTask',
      'lhs_table' => 'project_task',
      'lhs_key' => 'id',
      'rhs_module' => 'Users',
      'rhs_table' => 'users',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'projecttask_users_1_c',
      'join_key_lhs' => 'projecttask_users_1projecttask_ida',
      'join_key_rhs' => 'projecttask_users_1users_idb',
    ),
  ),
  'table' => 'projecttask_users_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
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
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    'projecttask_users_1projecttask_ida' => 
    array (
      'name' => 'projecttask_users_1projecttask_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'projecttask_users_1users_idb' => 
    array (
      'name' => 'projecttask_users_1users_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'projecttask_users_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'projecttask_users_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'projecttask_users_1projecttask_ida',
        1 => 'projecttask_users_1users_idb',
      ),
    ),
  ),
);
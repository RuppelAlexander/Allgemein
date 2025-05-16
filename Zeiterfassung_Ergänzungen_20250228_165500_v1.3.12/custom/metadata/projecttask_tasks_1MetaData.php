<?php
// created: 2022-11-17 14:52:44
$dictionary["projecttask_tasks_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'projecttask_tasks_1' => 
    array (
      'lhs_module' => 'ProjectTask',
      'lhs_table' => 'project_task',
      'lhs_key' => 'id',
      'rhs_module' => 'Tasks',
      'rhs_table' => 'tasks',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'projecttask_tasks_1_c',
      'join_key_lhs' => 'projecttask_tasks_1projecttask_ida',
      'join_key_rhs' => 'projecttask_tasks_1tasks_idb',
    ),
  ),
  'table' => 'projecttask_tasks_1_c',
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
    'projecttask_tasks_1projecttask_ida' => 
    array (
      'name' => 'projecttask_tasks_1projecttask_ida',
      'type' => 'id',
    ),
    'projecttask_tasks_1tasks_idb' => 
    array (
      'name' => 'projecttask_tasks_1tasks_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_projecttask_tasks_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_projecttask_tasks_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'projecttask_tasks_1projecttask_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_projecttask_tasks_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'projecttask_tasks_1tasks_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'projecttask_tasks_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'projecttask_tasks_1tasks_idb',
      ),
    ),
  ),
);
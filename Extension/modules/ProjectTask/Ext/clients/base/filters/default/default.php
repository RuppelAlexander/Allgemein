<?php
// created: 2017-10-16 11:48:17
$viewdefs['ProjectTask']['base']['filter']['default'] = array (
  'default_filter' => 'all_records',
  'fields' => 
  array (
    'name' => 
    array (
    ),
    'status' => 
    array (
    ),
    'project_name' => 
    array (
      'dbFields' => 
      array (
      ),
      'vname' => 'LBL_PROJECT_NAME',
    ),
    'assigned_user_name' => 
    array (
    ),
    '$owner' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
    ),
    '$favorite' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_FAVORITES_FILTER',
    ),
  ),
);
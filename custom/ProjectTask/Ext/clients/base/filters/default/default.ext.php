<?php
// WARNING: The contents of this file are auto-generated.


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

//ISC KOK
// created: 2017-08-31 11:45:06
$viewdefs['ProjectTask']['base']['filter']['default']['fields']['isc_project_id'] = array(
    'type' => 'varchar',
    //'vname' => 'Ausgewähltes Projekt',
);


//ISC KOK
// created: 2017-08-31 11:45:06
$viewdefs['ProjectTask']['base']['filter']['default']['fields']['$isc_user'] = array (
'predefined_filter' => true,
    'vname' => 'LBL_MY_PROJECTTASKS',
);

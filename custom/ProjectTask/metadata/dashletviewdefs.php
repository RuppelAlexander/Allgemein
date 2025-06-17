<?php
$dashletData['ProjectTaskDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'priority' => 
  array (
    'default' => '',
  ),
  'date_start' => 
  array (
    'default' => '',
  ),
  'date_finish' => 
  array (
    'default' => '',
  ),
  'team_id' => 
  array (
    'default' => '',
    'label' => 'LBL_TEAMS',
  ),
  'assigned_user_id' => 
  array (
    'type' => 'assigned_user_name',
    'label' => 'LBL_ASSIGNED_TO',
    'default' => 'Jörg Madloch',
  ),
);
$dashletData['ProjectTaskDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '45%',
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'priority' => 
  array (
    'width' => '15%',
    'label' => 'LBL_PRIORITY',
    'default' => true,
    'name' => 'priority',
  ),
  'date_start' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_START',
    'default' => true,
    'name' => 'date_start',
  ),
  'date_finish' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_FINISH',
    'default' => true,
    'name' => 'date_finish',
  ),
  'percent_complete' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PERCENT_COMPLETE',
    'default' => true,
    'name' => 'percent_complete',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'abgerechnet_c' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_ABGERECHNET',
    'width' => '10%',
  ),
  'time_start' => 
  array (
    'width' => '15%',
    'label' => 'LBL_TIME_START',
    'name' => 'time_start',
    'default' => false,
  ),
  'time_finish' => 
  array (
    'width' => '15%',
    'label' => 'LBL_TIME_FINISH',
    'name' => 'time_finish',
    'default' => false,
  ),
  'project_name' => 
  array (
    'width' => '30%',
    'label' => 'LBL_PROJECT_NAME',
    'related_fields' => 
    array (
      0 => 'project_id',
    ),
    'name' => 'project_name',
    'default' => false,
  ),
  'milestone_flag' => 
  array (
    'width' => '10%',
    'label' => 'LBL_MILESTONE_FLAG',
    'name' => 'milestone_flag',
    'default' => false,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'name' => 'date_entered',
    'default' => false,
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
  'team_name' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_TEAM',
    'sortable' => false,
    'name' => 'team_name',
    'default' => false,
  ),
);

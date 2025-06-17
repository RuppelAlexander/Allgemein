<?php
// created: 2021-02-02 17:36:27
$listViewDefs['ProjectTask'] = array (
  'name' => 
  array (
    'width' => '40',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'sortable' => true,
  ),
  'ticket_c' => 
  array (
    'type' => 'relate',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TICKET',
    'id' => 'ACASE_ID_C',
    'link' => true,
    'width' => '10',
  ),
  'project_name' => 
  array (
    'width' => '25',
    'label' => 'LBL_PROJECT_NAME',
    'id' => 'PROJECT_ID',
    'link' => true,
    'default' => true,
    'sortable' => true,
    'module' => 'Project',
    'ACLTag' => 'PROJECT',
    'related_fields' => 
    array (
      0 => 'project_id',
    ),
  ),
  'date_start' => 
  array (
    'width' => '10',
    'label' => 'LBL_DATE_START',
    'default' => true,
    'sortable' => true,
  ),
  'date_finish' => 
  array (
    'width' => '10',
    'label' => 'LBL_DATE_FINISH',
    'default' => true,
    'sortable' => true,
  ),
  'priority' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_PRIORITY',
    'default' => true,
    'sortable' => true,
  ),
  'percent_complete' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_PERCENT_COMPLETE',
    'default' => true,
    'sortable' => true,
  ),
  'status' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => '10',
  ),
  'assigned_user_name' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_ASSIGNED_USER_ID',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'faktura_c' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_FAKTURA',
    'width' => '10',
  ),
  'abgerechnet_c' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_ABGERECHNET',
    'width' => '10',
  ),
  'estimated_effort' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ESTIMATED_EFFORT',
    'width' => '10',
    'default' => true,
  ),
  'actual_effort' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ACTUAL_EFFORT',
    'width' => '10',
    'default' => true,
  ),
  'team_name' => 
  array (
    'width' => '2',
    'label' => 'LBL_LIST_TEAM',
    'default' => false,
  ),
);
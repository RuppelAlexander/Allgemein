<?php
// created: 2018-10-23 11:48:55
$viewdefs['ProjectTask']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
          'readonly' => true,
          'name' => 'name',
          'link' => true,
          'width' => '40',
        ),
        1 => 
        array (
          'name' => 'ticket_c',
          'label' => 'LBL_TICKET',
          'enabled' => true,
          'id' => 'ACASE_ID_C',
          'link' => true,
          'sortable' => false,
          'width' => '10',
          'default' => true,
        ),
        2 => 
        array (
          'label' => 'LBL_PROJECT_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'project_name',
          'id' => 'project_id',
          'link' => true,
          'width' => '25',
        ),
        3 => 
        array (
          'label' => 'LBL_DATE_START',
          'enabled' => true,
          'default' => true,
          'name' => 'date_start',
          'width' => '10',
        ),
        4 => 
        array (
          'label' => 'LBL_DATE_FINISH',
          'enabled' => true,
          'default' => true,
          'name' => 'date_finish',
          'width' => '10',
        ),
        5 => 
        array (
          'label' => 'LBL_LIST_PRIORITY',
          'enabled' => true,
          'default' => true,
          'name' => 'priority',
          'width' => '10',
        ),
        6 => 
        array (
          'label' => 'LBL_LIST_PERCENT_COMPLETE',
          'enabled' => true,
          'default' => true,
          'name' => 'percent_complete',
          'width' => '10',
        ),
        7 => 
        array (
          'name' => 'status',
          'label' => 'LBL_STATUS',
          'enabled' => true,
          'width' => '10',
          'default' => true,
        ),
        8 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_ASSIGNED_TO_NAME',
          'enabled' => true,
          'default' => true,
          'width' => '10',
        ),
        9 => 
        array (
          'name' => 'faktura_c',
          'label' => 'LBL_FAKTURA',
          'enabled' => true,
          'width' => '10',
          'default' => true,
        ),
        10 => 
        array (
          'name' => 'abgerechnet_c',
          'label' => 'LBL_ABGERECHNET',
          'enabled' => true,
          'width' => '10',
          'default' => true,
        ),
        11 => 
        array (
          'name' => 'estimated_effort',
          'label' => 'LBL_ESTIMATED_EFFORT',
          'enabled' => true,
          'default' => true,
        ),
        12 => 
        array (
          'name' => 'actual_effort',
          'label' => 'LBL_ACTUAL_EFFORT',
          'enabled' => true,
          'default' => true,
        ),
        13 => 
        array (
          'name' => 'team_name',
          'label' => 'LBL_TEAMS',
          'enabled' => true,
          'id' => 'TEAM_ID',
          'link' => true,
          'sortable' => false,
          'width' => '2',
          'default' => false,
        ),
      ),
    ),
  ),
);
<?php
// created: 2015-12-01 11:41:48
$viewdefs['ProjectTask']['base']['view']['subpanel-for-project'] = array (
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
          'default' => true,
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'name' => 'name',
          'link' => true,
          'type' => 'name',
        ),
        1 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_PERCENT_COMPLETE',
          'enabled' => true,
          'name' => 'percent_complete',
          'type' => 'int',
        ),
        2 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_ASSIGNED_USER_ID',
          'enabled' => true,
          'name' => 'assigned_user_name',
          'type' => 'relate',
        ),
        3 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_DATE_DUE',
          'enabled' => true,
          'name' => 'date_finish',
          'type' => 'date',
        ),
        4 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_STATUS',
          'enabled' => true,
          'name' => 'status',
          'type' => 'enum',
        ),
        5 => 
        array (
          'type' => 'bool',
          'default' => true,
          'label' => 'LBL_ABGERECHNET',
          'enabled' => true,
          'name' => 'abgerechnet_c',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);
<?php
// created: 2018-01-30 09:18:31
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '20%',
    'default' => true,
  ),
  'projecttask_projecttask_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_L_TITLE',
    'id' => 'PROJECTTASK_PROJECTTASK_1PROJECTTASK_IDA',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'ProjectTask',
    'target_record_key' => 'projecttask_projecttask_1projecttask_ida',
  ),
  'percent_complete' => 
  array (
    'vname' => 'LBL_LIST_PERCENT_COMPLETE',
    'width' => '20%',
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'vname' => 'LBL_LIST_ASSIGNED_USER_ID',
    'module' => 'Users',
    'width' => '20%',
    'default' => true,
  ),
  'date_finish' => 
  array (
    'vname' => 'LBL_LIST_DATE_DUE',
    'width' => '20%',
    'default' => true,
  ),
  'estimated_effort' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_ESTIMATED_EFFORT',
    'width' => '10%',
    'default' => true,
  ),
  'status' => 
  array (
    'vname' => 'LBL_LIST_STATUS',
    'width' => '20%',
    'default' => true,
  ),
  'faktura_c' => 
  array (
    'type' => 'bool',
    'default' => true,
    'vname' => 'LBL_FAKTURA',
    'width' => '10%',
  ),
  'abgerechnet_c' => 
  array (
    'type' => 'bool',
    'default' => true,
    'vname' => 'LBL_ABGERECHNET',
    'width' => '10%',
  ),
);
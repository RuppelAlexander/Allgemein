<?php
 // created: 2022-11-17 15:03:46
$layout_defs["Tasks"]["subpanel_setup"]['tasks_isc_zeiterfassung_1'] = array (
  'order' => 100,
  'module' => 'ISC_Zeiterfassung',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE',
  'get_subpanel_data' => 'tasks_isc_zeiterfassung_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);

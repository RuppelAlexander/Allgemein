<?php
 // created: 2017-12-21 10:19:43
$layout_defs["ProjectTask"]["subpanel_setup"]['projecttask_isc_zeiterfassung_1'] = array (
  'order' => 100,
  'module' => 'ISC_Zeiterfassung',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_ISC_ZEITERFASSUNG_TITLE',
  'get_subpanel_data' => 'projecttask_isc_zeiterfassung_1',
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

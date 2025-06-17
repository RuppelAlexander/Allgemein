<?php
 // created: 2015-11-06 09:59:16
$layout_defs["ProjectTask"]["subpanel_setup"]['projecttask_ks_zeiteinheit_1'] = array (
  'order' => 100,
  'module' => 'KS_Zeiteinheit',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_PROJECTTASK_KS_ZEITEINHEIT_1_FROM_KS_ZEITEINHEIT_TITLE',
  'get_subpanel_data' => 'projecttask_ks_zeiteinheit_1',
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

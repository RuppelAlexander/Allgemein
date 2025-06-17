<?php
// WARNING: The contents of this file are auto-generated.
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_acase_id_c.php

 // created: 2013-03-22 14:50:19

 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_ks_zeiteinheit_1_ProjectTask.php

// created: 2015-11-06 09:59:16
$dictionary["ProjectTask"]["fields"]["projecttask_ks_zeiteinheit_1"] = array (
  'name' => 'projecttask_ks_zeiteinheit_1',
  'type' => 'link',
  'relationship' => 'projecttask_ks_zeiteinheit_1',
  'source' => 'non-db',
  'side' => 'right',
  'vname' => 'LBL_PROJECTTASK_KS_ZEITEINHEIT_1_FROM_KS_ZEITEINHEIT_TITLE',
);

?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_billing_c.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['billing_c']['enforced'] = '';
$dictionary['ProjectTask']['fields']['billing_c']['dependency'] = '';
$dictionary['ProjectTask']['fields']['billing_c']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_date_inquiry_c.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['date_inquiry_c']['enforced'] = '';
$dictionary['ProjectTask']['fields']['date_inquiry_c']['dependency'] = '';
$dictionary['ProjectTask']['fields']['date_inquiry_c']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_duration.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['duration']['merge_filter'] = 'disabled';
$dictionary['ProjectTask']['fields']['duration']['calculated'] = false;
$dictionary['ProjectTask']['fields']['duration']['enable_range_search'] = false;
$dictionary['ProjectTask']['fields']['duration']['min'] = false;
$dictionary['ProjectTask']['fields']['duration']['max'] = false;
$dictionary['ProjectTask']['fields']['duration']['disable_num_format'] = '';
$dictionary['ProjectTask']['fields']['duration']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_priority.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['priority']['default'] = 'Medium';
$dictionary['ProjectTask']['fields']['priority']['merge_filter'] = 'disabled';
$dictionary['ProjectTask']['fields']['priority']['calculated'] = false;
$dictionary['ProjectTask']['fields']['priority']['dependency'] = false;
$dictionary['ProjectTask']['fields']['priority']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_kind_c.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['kind_c']['enforced'] = '';
$dictionary['ProjectTask']['fields']['kind_c']['dependency'] = '';
$dictionary['ProjectTask']['fields']['kind_c']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_name.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['name']['len'] = '100';
$dictionary['ProjectTask']['fields']['name']['merge_filter'] = 'disabled';
$dictionary['ProjectTask']['fields']['name']['unified_search'] = false;
$dictionary['ProjectTask']['fields']['name']['full_text_search']['enabled'] = true;
$dictionary['ProjectTask']['fields']['name']['full_text_search']['searchable'] = true;
$dictionary['ProjectTask']['fields']['name']['full_text_search']['boost'] = 0.81000000000000005;
$dictionary['ProjectTask']['fields']['name']['calculated'] = false;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_order_date_c.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['order_date_c']['enforced'] = '';
$dictionary['ProjectTask']['fields']['order_date_c']['dependency'] = '';
$dictionary['ProjectTask']['fields']['order_date_c']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_converted_c.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['converted_c']['enforced'] = '';
$dictionary['ProjectTask']['fields']['converted_c']['dependency'] = '';


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_actual_duration.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['actual_duration']['merge_filter'] = 'disabled';
$dictionary['ProjectTask']['fields']['actual_duration']['calculated'] = false;
$dictionary['ProjectTask']['fields']['actual_duration']['enable_range_search'] = false;
$dictionary['ProjectTask']['fields']['actual_duration']['min'] = false;
$dictionary['ProjectTask']['fields']['actual_duration']['max'] = false;
$dictionary['ProjectTask']['fields']['actual_duration']['disable_num_format'] = '';
$dictionary['ProjectTask']['fields']['actual_duration']['full_text_search']['boost'] = 1;


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_ticket_c.php

 // created: 2016-05-18 11:34:35
$dictionary['ProjectTask']['fields']['ticket_c']['dependency'] = '';


?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_projecttask_1_ProjectTask.php

// created: 2018-01-29 09:55:45
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1"] = array (
  'name' => 'projecttask_projecttask_1',
  'type' => 'link',
  'relationship' => 'projecttask_projecttask_1',
  'source' => 'non-db',
  'module' => 'ProjectTask',
  'bean_name' => 'ProjectTask',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_L_TITLE',
  'id_name' => 'projecttask_projecttask_1projecttask_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1_right"] = array (
  'name' => 'projecttask_projecttask_1_right',
  'type' => 'link',
  'relationship' => 'projecttask_projecttask_1',
  'source' => 'non-db',
  'module' => 'ProjectTask',
  'bean_name' => 'ProjectTask',
  'side' => 'right',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_R_TITLE',
  'id_name' => 'projecttask_projecttask_1projecttask_ida',
  'link-type' => 'one',
);
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1_name"] = array (
  'name' => 'projecttask_projecttask_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_L_TITLE',
  'save' => true,
  'id_name' => 'projecttask_projecttask_1projecttask_ida',
  'link' => 'projecttask_projecttask_1_right',
  'table' => 'project_task',
  'module' => 'ProjectTask',
  'rname' => 'name',
);
$dictionary["ProjectTask"]["fields"]["projecttask_projecttask_1projecttask_ida"] = array (
  'name' => 'projecttask_projecttask_1projecttask_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECTTASK_PROJECTTASK_1_FROM_PROJECTTASK_R_TITLE_ID',
  'id_name' => 'projecttask_projecttask_1projecttask_ida',
  'link' => 'projecttask_projecttask_1_right',
  'table' => 'project_task',
  'module' => 'ProjectTask',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);

?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_isc_zeiterfassung_1_ProjectTask.php

// created: 2017-12-21 10:19:43
$dictionary["ProjectTask"]["fields"]["projecttask_isc_zeiterfassung_1"] = array (
  'name' => 'projecttask_isc_zeiterfassung_1',
  'type' => 'link',
  'relationship' => 'projecttask_isc_zeiterfassung_1',
  'source' => 'non-db',
  'module' => 'ISC_Zeiterfassung',
  'bean_name' => 'ISC_Zeiterfassung',
  'vname' => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_PROJECTTASK_TITLE',
  'id_name' => 'projecttask_isc_zeiterfassung_1projecttask_ida',
  'link-type' => 'many',
  'side' => 'left',
);

?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_users_1_ProjectTask.php

// created: 2017-08-21 12:44:57
$dictionary["ProjectTask"]["fields"]["projecttask_users_1"] = array (
  'name' => 'projecttask_users_1',
  'type' => 'link',
  'relationship' => 'projecttask_users_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_PROJECTTASK_USERS_1_FROM_USERS_TITLE',
  'id_name' => 'projecttask_users_1users_idb',
);

?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/isc_project_id.php


$dictionary['ProjectTask']['fields']['isc_project_id'] = array(
    'name' => 'isc_project_id',
    'source'=>'non-db',
    'massupdate' => false,
    'type' => 'relate',
    'studio' => false,
);
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_status.php

 // created: 2017-11-29 14:54:00
 global $sugar_config;
 $Filter = $sugar_config['ISCProjektTaskStatus'];
$dictionary['ProjectTask']['fields']['status']['default']=$Filter;
$dictionary['ProjectTask']['fields']['status']['options']='isc_projecttaskstatus';
 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_faktura_c.php

 // created: 2018-06-19 15:51:21
$dictionary['ProjectTask']['fields']['faktura_c']['labelValue']='Fakturierfähig';
$dictionary['ProjectTask']['fields']['faktura_c']['enforced']='';
$dictionary['ProjectTask']['fields']['faktura_c']['dependency']='';

 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_abgerechnet_c.php

 // created: 2018-06-19 15:51:40
$dictionary['ProjectTask']['fields']['abgerechnet_c']['labelValue']='Fakturiert';
$dictionary['ProjectTask']['fields']['abgerechnet_c']['enforced']='';
$dictionary['ProjectTask']['fields']['abgerechnet_c']['dependency']='';

 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/full_text_search_admin.php

 // created: 2021-04-15 17:24:11
$dictionary['ProjectTask']['full_text_search']=true;

?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_tasks_1_ProjectTask.php

// created: 2022-11-17 14:52:44
$dictionary["ProjectTask"]["fields"]["projecttask_tasks_1"] = array (
  'name' => 'projecttask_tasks_1',
  'type' => 'link',
  'relationship' => 'projecttask_tasks_1',
  'source' => 'non-db',
  'module' => 'Tasks',
  'bean_name' => 'Task',
  'vname' => 'LBL_PROJECTTASK_TASKS_1_FROM_PROJECTTASK_TITLE',
  'id_name' => 'projecttask_tasks_1projecttask_ida',
  'link-type' => 'many',
  'side' => 'left',
);

?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_kostentest_c.php

 // created: 2023-11-17 11:51:07
$dictionary['ProjectTask']['fields']['kostentest_c']['labelValue']='kostentest';
$dictionary['ProjectTask']['fields']['kostentest_c']['enforced']='false';
$dictionary['ProjectTask']['fields']['kostentest_c']['dependency']='';
$dictionary['ProjectTask']['fields']['kostentest_c']['required_formula']='';
$dictionary['ProjectTask']['fields']['kostentest_c']['readonly_formula']='';

 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_budget_c.php

 // created: 2024-02-14 17:17:36
$dictionary['ProjectTask']['fields']['budget_c']['labelValue']='Gesamtbudget bis zur Fertigstellung (Std):';
$dictionary['ProjectTask']['fields']['budget_c']['enforced']='false';
$dictionary['ProjectTask']['fields']['budget_c']['dependency']='';
$dictionary['ProjectTask']['fields']['budget_c']['required_formula']='';
$dictionary['ProjectTask']['fields']['budget_c']['readonly_formula']='';

 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_buchungshinweis_c.php

 // created: 2024-02-14 17:17:36
$dictionary['ProjectTask']['fields']['buchungshinweis_c']['labelValue']='Buchungshinweis';
$dictionary['ProjectTask']['fields']['buchungshinweis_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['ProjectTask']['fields']['buchungshinweis_c']['enforced']='';
$dictionary['ProjectTask']['fields']['buchungshinweis_c']['dependency']='';

 
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_kosten_c.php

 // created: 2024-02-14 17:17:36
$dictionary['ProjectTask']['fields']['kosten_c']['duplicate_merge_dom_value']=0;
$dictionary['ProjectTask']['fields']['kosten_c']['labelValue']='Kosten';
$dictionary['ProjectTask']['fields']['kosten_c']['calculated']='1';
$dictionary['ProjectTask']['fields']['kosten_c']['formula']='ifElse(
not(equal($estimated_effort,"")),
rollupSum($projecttask_isc_zeiterfassung_1,"working_hours"),
$kosten_c
)';
$dictionary['ProjectTask']['fields']['kosten_c']['enforced']='1';
$dictionary['ProjectTask']['fields']['kosten_c']['dependency']='';
$dictionary['ProjectTask']['fields']['kosten_c']['required_formula']='';
$dictionary['ProjectTask']['fields']['kosten_c']['readonly_formula']='';

 
?>

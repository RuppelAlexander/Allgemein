<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 05.01.2023
 * Change Date   : 05.01.2023
 * Main Program  : sugarcrm_intern_upgradetest_dev
 * Description   : TaskdependReadonlys.php
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"]['readonly'] = true;
//$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen(related($tasks_isc_zeiterfassung_1,"name")),0)';
$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen($tasks_isc_zeiterfassung_1_name),0)';
$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"]['readonly'] = true;
//$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen(related($tasks_isc_zeiterfassung_1,"name")),0)';
$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"]['readonly_formula'] =  'greaterThan(strlen($tasks_isc_zeiterfassung_1_name),0)';

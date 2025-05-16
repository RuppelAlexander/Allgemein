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
 * 04.03.2025  MM      Added admin query
 * ----------------------------------------------------------------------------
 */


global $current_user;
// ISC GmbH, MM, 2025-03-04 : Added admin query
if (!$current_user->isAdmin()) {
    $dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"]['readonly'] = true;
//$dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen(related($tasks_isc_zeiterfassung_1,"name")),0)';
    $dictionary["ISC_Zeiterfassung"]["fields"]["projecttask_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen($tasks_isc_zeiterfassung_1_name),0)';
    $dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"]['readonly'] = true;
//$dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen(related($tasks_isc_zeiterfassung_1,"name")),0)';
    $dictionary["ISC_Zeiterfassung"]["fields"]["project_isc_zeiterfassung_1_name"]['readonly_formula'] = 'greaterThan(strlen($tasks_isc_zeiterfassung_1_name),0)';
}


<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : MoschkauM
 * Create Date   : 04.03.2025
 * Change Date   : 04.03.2025
 * Main Program  : Zeiterfassung Usability-Anpassungen
 * Description   : Adjustments for time tracking
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$manifest = array (
 'acceptable_sugar_versions' => array('regex_matches' => array("14\.*","13\.*", "12\.*", "11\.*",)),
    'acceptable_sugar_flavors' => array("ULT", "ENT", "PRO",),
    'readme' => '',
    'key' => 'isc_abbrevationextension',
    'author' => 'Manuel Moschkau',
    'description' => 'Account and Task Timetracking Abbreviation Field and Display Logic',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'ISC Abbreviation for Account, Task and Timetracking',
    'published_date' => '2025-03-04 14:19:00',
    'type' => 'module',
    'version' => '1.0.1',
    'remove_tables' => 'prompt',
);
$installdefs = array (
    'id' => 'ISC_TIMETRACKING_Tasks_ABBREVIATION_Erweiterung',
    'copy' =>
        array (
            array (
                'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/TaskdependReadonlys.php',
                'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/TaskdependReadonlys.php',
            ),
            array (
                'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/en_us.abtask.php',
                'to' => 'custom/Extension/modules/Tasks/Ext/Language/en_us.abtask.php',
            ),
            array (
                'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/de_DE.abtask.php',
                'to' => 'custom/Extension/modules/Tasks/Ext/Language/de_DE.abtask.php',
            ),
            array (
                'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/LogicHooks/ISC_statusHook.php',
                'to' => 'custom/Extension/modules/Tasks/Ext/LogicHooks/ISC_statusHook.php',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/fieldset/detail.hbs',
                'to' => 'custom/modules/Accounts/clients/base/fields/fieldset/detail.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/fieldset/list.hbs',
                'to' => 'custom/modules/Accounts/clients/base/fields/fieldset/list.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/isc_abbreviation/detail.hbs',
                'to' => 'custom/modules/Accounts/clients/base/fields/isc_abbreviation/detail.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/isc_abbreviation/disabled.hbs',
                'to' => 'custom/modules/Accounts/clients/base/fields/isc_abbreviation/disabled.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/isc_abbreviation/edit.hbs',
                'to' => 'custom/modules/Accounts/clients/base/fields/isc_abbreviation/edit.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/isc_abbreviation/isc_abbreviation.js',
                'to' => 'custom/modules/Accounts/clients/base/fields/isc_abbreviation/isc_abbreviation.js',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/fields/isc_abbreviation/list.hbs',
                'to' => 'custom/modules/Accounts/clients/base/fields/isc_abbreviation/list.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Accounts/clients/base/views/record/record.php',
                'to' => 'custom/modules/Accounts/clients/base/views/record/record.php',
            ),
            array (
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/detail.hbs',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/detail.hbs',
            ),
            array (
                'from' => '<basepath>/custom/modules/Tasks/clients/base/views/list/list.php',
                'to' => 'custom/modules/Tasks/clients/base/views/list/list.php',
            ),
            array (
                'from' => '<basepath>/custom/modules/Tasks/clients/base/views/selection-list/selection-list.php',
                'to' => 'custom/modules/Tasks/clients/base/views/selection-list/selection-list.php',
            ),
            array (
                'from' => '<basepath>/custom/modules/Tasks/ISC_statusHook.php',
                'to' => 'custom/modules/Tasks/ISC_statusHook.php',
            ),
        ),
    'post_execute' => array ('<basepath>/post_install.php',
    )
);


<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : Alexander Ruppel
 * Create Date   : 13.11.2025
 * Change Date   : 13.11.2025
 * Main Program  : ISC_Ressourcenverwaltung
 * Description   : manifest.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

$manifest = array(
    'key' => 'ISC_Ressourcenverwaltung',
    'name' => 'ISC Ressourcenverwaltung (Tasks/ProjectTasks)',
    'description' => 'Automatische Synchronisation von Ressourcen zwischen Aufgaben, Projektaufgaben und Projekten inkl. Dialogsteuerung im Tasks-Modul.',
    'author' => 'Alexander Ruppel',
    'version' => '1.0.0',
    'type' => 'module',
    'remove_tables' => 'prompt',
    'is_uninstallable' => true,
    'acceptable_sugar_flavors' => array('PRO', 'ENT', 'ULT'),
    'acceptable_sugar_versions' => array(
        'regex_matches' => array(
            '^11\\..*',
            '^12\\..*',
        ),
    ),
);

$installdefs = array(
    'id' => 'ISC_Ressourcenverwaltung',
    'copy' => array(
        // ---------------------------------------------------------------------
        // Tasks – Logic Hooks
        // ---------------------------------------------------------------------
        array(
            'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/LogicHooks/isc_rs_tasks.php',
            'to'   => 'custom/Extension/modules/Tasks/Ext/LogicHooks/isc_rs_tasks.php',
        ),
        array(
            'from' => '<basepath>/custom/modules/Tasks/ISC_RS_TasksHook.php',
            'to'   => 'custom/modules/Tasks/ISC_RS_TasksHook.php',
        ),

        // ---------------------------------------------------------------------
        // Tasks – Vardefs (non-db Flag für Dialogsteuerung)
        // ---------------------------------------------------------------------
        array(
            'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/isc_rs_skip_resource.php',
            'to'   => 'custom/Extension/modules/Tasks/Ext/Vardefs/isc_rs_skip_resource.php',
        ),

        // ---------------------------------------------------------------------
        // Tasks – Sidecar Views (Record/Create mit Dialog + API-Check)
        // ---------------------------------------------------------------------
        array(
            'from' => '<basepath>/custom/modules/Tasks/clients/base/views/record/record.js',
            'to'   => 'custom/modules/Tasks/clients/base/views/record/record.js',
        ),
        array(
            'from' => '<basepath>/custom/modules/Tasks/clients/base/views/create/create.js',
            'to'   => 'custom/modules/Tasks/clients/base/views/create/create.js',
        ),

        // ---------------------------------------------------------------------
        // API – Status-Endpunkt für Ressourcenprüfung
        // ---------------------------------------------------------------------
        array(
            'from' => '<basepath>/custom/clients/base/api/TaskResourceApi.php',
            'to'   => 'custom/clients/base/api/TaskResourceApi.php',
        ),

        // ---------------------------------------------------------------------
        // ProjectTask – Logic Hooks (Entfernen von Ressourcen)
        // ---------------------------------------------------------------------
        array(
            'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/LogicHooks/isc_rs_projecttask.php',
            'to'   => 'custom/Extension/modules/ProjectTask/Ext/LogicHooks/isc_rs_projecttask.php',
        ),
        array(
            'from' => '<basepath>/custom/modules/ProjectTask/ISC_RS_ProjectTaskHook.php',
            'to'   => 'custom/modules/ProjectTask/ISC_RS_ProjectTaskHook.php',
        ),
    ),


);

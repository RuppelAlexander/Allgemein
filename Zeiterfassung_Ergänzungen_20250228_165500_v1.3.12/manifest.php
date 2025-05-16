<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 28.08.2025
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Zeiterfassung Ergänzungen
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 14.12.2018  TF      Version 1.2.0:
 *                     Anpassung der Filter für Projekte, QuickSearch
 *                     analog der Pop-Up-Suche sowie Aktivierung Create-Filter
 * 17.12.2018  TF      Version 1.2.1:
 *                     Korrektur des Projekt-Filters, für QuickSearch
 * 04.02.2018  TF      Version 1.2.3:
 *                     Listenansichtsortierung festgelegt
 * 05.02.2018  TF      Version 1.2.4:
 *                     Fehlende Sprachdateien ergänzt und Header korrigiert
 * 08.02.2018  TF      Version 1.2.5:
 *                     Zeithandhabung für neue Einträge verfeinert und Fixes
 * 05.06.2018  RK      Version 1.2.6:
 *                     Korrekturen: Quicksearch, Refresh bei Löschung, Filter
 * 10.07.2020  RK      Version 1.2.9:
 *                     Anpassung des Abbrechen Buttons, Rollen Admins werden nun
 *                     wie richtige Admins behandelt, Budgetwarnung hinzugefuegt
 * 29.01.2024  AR      Version 1.3.5:
 *                     Die Aktualisierung beinhaltet einen LogicHook,
 *                     eine Formel für das Studio
 *                     und eingebaute Abhängigkeiten im Manifest.
 * 14.02.2024  AR      Version 1.3.6:
 *                     Anpassung des CostCalculationHooks,
 *                     des Manifests und Einbindung des Schedulers
 * 07.05.2024  AR      Version 1.3.8:
 *                      Anmerkungen von GD in meinem code nochmal angepasst und
 *                      mit GD besprochen(Scheduler --> my_custom_jobs.php und
 *                      Logic hook--> CostCalculationHook.php )
 * 12.06.2024  DontG   fix CostCalculation 
 * 14.01.2025  DontG   fix relationships Manifest
 * 30.01.2025  DontG   fix Berechnung (budget_c )
 * 28.02.2025  AR      Version 1.3.12:
 *                     Added event listener for dynamic field updates
 * 
 * ----------------------------------------------------------------------------
 */


$manifest = array(
    'acceptable_sugar_versions' => array('regex_matches' => array("14\.*","13\.*","12\.*", "11\.*",)),
    'acceptable_sugar_flavors'  => array("ULT", "ENT", "PRO",),
    'readme' => '',
    'key' => 'ISC',
    'author' => 'Robin Kok',
    'description' => 'Änderungspaket Zeiterfassung + isc_ZE_task_rel_20250131_091500_v1.0.13',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Zeiterfassung Ergänzungen',
    'published_date' => '2025-02-28 12:56:00',
    'type' => 'module',
    'version' => '1.3.12',
    'remove_tables' => 'prompt',
    'uninstall_before_upgrade'  => 'false',
    'dependencies'              => array(
        array(
            'id_name' => 'iscsuexp1',
            'version' => '1.0'
        ),
    ),
);


$installdefs = array(
    'id' => 'Zeiterfassung_Ergänzungen',

    'custom_fields' =>
        array (
            'ProjectTaskbuchungshinweis_c' =>
                array (
                    'id' => 'ProjectTaskbuchungshinweis_c',
                    'name' => 'buchungshinweis_c',
                    'label' => 'LBL_BUCHUNGSHINWEIS',
                    'comments' => NULL,
                    'help' => NULL,
                    'module' => 'ProjectTask',
                    'type' => 'varchar',
                    'max_size' => '255',
                    'require_option' => '0',
                    'default_value' => NULL,
                    'date_modified' => '2019-01-16 10:28:37',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => NULL,
                    'ext2' => NULL,
                    'ext3' => NULL,
                    'ext4' => NULL,
                ),
            'Projectbudget_c' =>
                array (
                    'id' => 'Projectbudget_c',
                    'name' => 'budget_c',
                    'label' => 'LBL_BUDGET',
                    'comments' => NULL,
                    'help' => NULL,
                    'module' => 'Project',
                    'type' => 'decimal',
                    'max_size' => '18',
                    'require_option' => '0',
                    'default_value' => NULL,
                    'date_modified' => '2020-07-06 13:37:30',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => '2',
                    'ext2' => NULL,
                    'ext3' => NULL,
                    'ext4' => NULL,
                ),
            'Projectkosten_c' =>
                array (
                    'id' => 'Projectkosten_c',
                    'name' => 'kosten_c',
                    'label' => 'LBL_KOSTEN',
                    'comments' => NULL,
                    'help' => NULL,
                    'module' => 'Project',
                    'type' => 'decimal',
                    'max_size' => '18',
                    'require_option' => '0',
                    'default_value' => NULL,
                    'date_modified' => '2020-07-06 13:34:52',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'false',
                    'ext1' => '2',
                    'ext2' => NULL,
                    'ext3' => NULL,
                    'ext4' => NULL,
                ),
            'ProjectTaskbudget_c' =>
                array (
                    'id' => 'ProjectTaskbudget_c',
                    'name' => 'budget_c',
                    'label' => 'LBL_BUDGET',
                    'comments' => NULL,
                    'help' => NULL,
                    'module' => 'ProjectTask',
                    'type' => 'decimal',
                    'max_size' => '18',
                    'require_option' => '0',
                    'default_value' => NULL,
                    'date_modified' => '2020-07-06 13:37:30',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '0',
                    'duplicate_merge' => '1',
                    'reportable' => '1',
                    'importable' => 'true',
                    'ext1' => '2',
                    'ext2' => NULL,
                    'ext3' => NULL,
                    'ext4' => NULL,
                ),
            'ProjectTaskkosten_c' =>
                array (
                    'id' => 'ProjectTaskkosten_c',
                    'name' => 'kosten_c',
                    'label' => 'LBL_KOSTEN',
                    'comments' => NULL,
                    'help' => NULL,
                    'module' => 'ProjectTask',
                    'type' => 'decimal',
                    'max_size' => '18',
                    'require_option' => '0',
                    'default_value' => NULL,
                    'date_modified' => '2020-07-06 13:34:52',
                    'deleted' => '0',
                    'audited' => '0',
                    'mass_update' => '0',
                    'duplicate_merge' => '0',
                    'reportable' => '1',
                    'importable' => 'false',
                    'ext1' => '2',
                    'ext2' => NULL,
                    'ext3' => NULL,
                    'ext4' => NULL,
                ),
            '6a4e5150-673b-11ed-bd6b-000c29da1046' => array(
                'id'              => '6a4e5150-673b-11ed-bd6b-000c29da1046',
                'name'            => 'project_c',
                'label'           => 'LBL_PROJECT',
                'comments'        => null,
                'help'            => null,
                'module'          => 'Tasks',
                'type'            => 'relate',
                'max_size'        => '255',
                'require_option'  => '0',
                'default_value'   => null,
                'date_modified'   => '2022-11-18 13:22:24',
                'deleted'         => '0',
                'audited'         => '0',
                'mass_update'     => '0',
                'duplicate_merge' => '1',
                'reportable'      => '1',
                'importable'      => 'true',
                'ext1'            => null,
                'ext2'            => 'Project',
                'ext3'            => 'project_id_c',
                'ext4'            => null,
                'autoinc_next'    => null,
            ),
            '6a3fb168-673b-11ed-a281-000c29da1046' => array(
                'id'              => '6a3fb168-673b-11ed-a281-000c29da1046',
                'name'            => 'project_id_c',
                'label'           => 'LBL_PROJECT_PROJECT_ID',
                'comments'        => null,
                'help'            => null,
                'module'          => 'Tasks',
                'type'            => 'id',
                'max_size'        => '36',
                'require_option'  => '0',
                'default_value'   => null,
                'date_modified'   => '2022-11-18 13:22:24',
                'deleted'         => '0',
                'audited'         => '0',
                'mass_update'     => '0',
                'duplicate_merge' => '1',
                'reportable'      => '0',
                'importable'      => 'true',
                'ext1'            => null,
                'ext2'            => null,
                'ext3'            => null,
                'ext4'            => null,
                'autoinc_next'    => null,
            ),

            
        ),
//relationship Files
    'relationships' =>
        array(
            array(
                'meta_data' => '<basepath>/custom/metadata/projecttask_users_1MetaData.php',
            ),
            array(
                'meta_data' => '<basepath>/custom/metadata/accounts_tasks_1MetaData.php',
            ),
            array(
                'meta_data' => '<basepath>/custom/metadata/projecttask_tasks_1MetaData.php',
            ),
            array(
                'meta_data' => '<basepath>/custom/metadata/tasks_isc_zeiterfassung_1MetaData.php',
            ),
        ),
 'copy' =>
        array(
//Extension Files
            array(
                'from' => '<basepath>/custom/Extension/modules/Project/Ext/clients/base/filters/default/default.php',
                'to' => 'custom/Extension/modules/Project/Ext/clients/base/filters/default/default.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/Project/Ext/clients/base/filters/Resources/Resources.php',
                'to' => 'custom/Extension/modules/Project/Ext/clients/base/filters/Resources/Resources.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/relationships/relationships/projecttask_users_1MetaData.php',
                'to' => 'custom/Extension/modules/relationships/relationships/projecttask_users_1MetaData.php',
            ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/clients/base/layouts/subpanels/accounts_tasks_1_Accounts.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/clients/base/layouts/subpanels/accounts_tasks_1_Accounts.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/clients/mobile/layouts/subpanels/accounts_tasks_1_Accounts.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/clients/mobile/layouts/subpanels/accounts_tasks_1_Accounts.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/clients/base/filters/filterUserTasksTemplate/filterUserTasksTemplate.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/clients/base/filters/filterUserTasksTemplate/filterUserTasksTemplate.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/clients/base/layouts/subpanels/tasks_isc_zeiterfassung_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/clients/base/layouts/subpanels/tasks_isc_zeiterfassung_1_Tasks.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/clients/mobile/layouts/subpanels/tasks_isc_zeiterfassung_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/clients/mobile/layouts/subpanels/tasks_isc_zeiterfassung_1_Tasks.php',
         ),
//Module Files
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/api/ISCZeiterfassung_CustomFilterApi.php',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/api/ISCZeiterfassung_CustomFilterApi.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/datetimecombo/datetimecombo.js',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/datetimecombo/datetimecombo.js',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/editablelistbutton/editablelistbutton.js',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/editablelistbutton/editablelistbutton.js',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/relate/relate.js',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/relate/relate.js',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/filters/basic/basic.php',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/filters/basic/basic.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/filters/default/default.php',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/filters/default/default.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/list/list.php',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/list/list.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/list-headerpane/list-headerpane.js',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/list-headerpane/list-headerpane.js',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/record/record.php',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/record/record.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/recordlist/recordlist.js',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/recordlist/recordlist.js',
            ),
            array(
                'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/recordlist/row.hbs',
                'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/recordlist/row.hbs',
            ),
            array(
                'from' => '<basepath>/custom/modules/Project/clients/base/api/ISCProject_CustomFilterApi.php',
                'to' => 'custom/modules/Project/clients/base/api/ISCProject_CustomFilterApi.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ProjectTask/CostCalculationHook.php',
                'to' => 'custom/modules/ProjectTask/CostCalculationHook.php',
            ),
            array(
                'from' => '<basepath>/custom/modules/ProjectTask/clients/base/api/ISCProjectTask_CustomFilterApi.php',
                'to' => 'custom/modules/ProjectTask/clients/base/api/ISCProjectTask_CustomFilterApi.php',
            ),

         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/detail.hbs',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/detail.hbs',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/edit.hbs',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/edit.hbs',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/reltask.js',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/fields/reltask/reltask.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/create/create.js',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/create/create.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/list/list.php',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/list/list.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/panel-top-for-task/panel-top-for-task.js',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/panel-top-for-task/panel-top-for-task.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/panel-top-for-task/panel-top-for-task.php',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/panel-top-for-task/panel-top-for-task.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/record/record.js',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/record/record.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/record/record.php',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/record/record.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/ISC_Zeiterfassung/clients/base/views/subpanel-for-tasks/subpanel-for-tasks.php',
             'to' => 'custom/modules/ISC_Zeiterfassung/clients/base/views/subpanel-for-tasks/subpanel-for-tasks.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Project/clients/base/views/list/list.php',
             'to' => 'custom/modules/Project/clients/base/views/list/list.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Project/clients/base/views/selection-list/selection-list.php',
             'to' => 'custom/modules/Project/clients/base/views/selection-list/selection-list.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/ProjectTask/clients/base/views/selection-list/selection-list.php',
             'to' => 'custom/modules/ProjectTask/clients/base/views/selection-list/selection-list.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/DeveloperCBeforeSaveHook.php',
             'to' => 'custom/modules/Tasks/DeveloperCBeforeSaveHook.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/fields/relate/relate.js',
             'to' => 'custom/modules/Tasks/clients/base/fields/relate/relate.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/filters/default/default.php',
             'to' => 'custom/modules/Tasks/clients/base/filters/default/default.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/views/create/create.js',
             'to' => 'custom/modules/Tasks/clients/base/views/create/create.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/views/list/list.php',
             'to' => 'custom/modules/Tasks/clients/base/views/list/list.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/views/quickcreate/quickcreate.js',
             'to' => 'custom/modules/Tasks/clients/base/views/quickcreate/quickcreate.js',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/views/record/record.php',
             'to' => 'custom/modules/Tasks/clients/base/views/record/record.php',
         ),
         array(
             'from' => '<basepath>/custom/modules/Tasks/clients/base/views/selection-list/selection-list.php',
             'to' => 'custom/modules/Tasks/clients/base/views/selection-list/selection-list.php',
         ),
//Language Files (application)
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.ISC_custom_error_withinOneWeek.php',
                'to' => 'custom/Extension/application/Ext/Language/de_DE.ISC_custom_error_withinOneWeek.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.ISC_error_description.php',
                'to' => 'custom/Extension/application/Ext/Language/de_DE.ISC_error_description.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.ISC_error_emptyDate.php',
                'to' => 'custom/Extension/application/Ext/Language/de_DE.ISC_error_emptyDate.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.ZeitLang20180131.php',
                'to' => 'custom/Extension/application/Ext/Language/de_DE.ZeitLang20180131.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.ISC_custom_error_withinOneWeek.php',
                'to' => 'custom/Extension/application/Ext/Language/en_us.ISC_custom_error_withinOneWeek.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.isc_error_budget_zeit.php',
                'to' => 'custom/Extension/application/Ext/Language/en_us.isc_error_budget_zeit.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.ISC_error_description.php',
                'to' => 'custom/Extension/application/Ext/Language/en_us.ISC_error_description.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.ISC_error_emptyDate.php',
                'to' => 'custom/Extension/application/Ext/Language/en_us.ISC_error_emptyDate.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.isc_error_ueberschneidung.php',
                'to' => 'custom/Extension/application/Ext/Language/en_us.isc_error_ueberschneidung.php',
            ),
         array(
             'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.parent_type_display_tasks.php',
             'to' => 'custom/Extension/application/Ext/Language/de_DE.parent_type_display_tasks.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/application/Ext/Language/de_DE.ZeitLang20221123.php',
             'to' => 'custom/Extension/application/Ext/Language/de_DE.ZeitLang20221123.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.parent_type_display_tasks.php',
             'to' => 'custom/Extension/application/Ext/Language/en_us.parent_type_display_tasks.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.ZeitLang20221123.php',
             'to' => 'custom/Extension/application/Ext/Language/en_us.ZeitLang20221123.php',
         ),
//Language Files (other)
            array(
                'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Language/de_DE.isc_cancel.php',
                'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Language/de_DE.isc_cancel.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/Project/Ext/Language/en_us.budget.lang.php',
                'to' => 'custom/Extension/modules/Project/Ext/Language/en_us.budget.lang.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Language/de_DE.Projektaufgabe.lang.php',
                'to' => 'custom/Extension/modules/ProjectTask/Ext/Language/de_DE.Projektaufgabe.lang.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Language/en_us.budget.lang.php',
                'to' => 'custom/Extension/modules/ProjectTask/Ext/Language/en_us.budget.lang.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/Schedulers/Ext/Language/de_DE.Zeiterfassung_Ergaenzungen.php',
                'to' => 'custom/Extension/modules/Schedulers/Ext/Language/de_DE.Zeiterfassung_Ergaenzungen.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/Schedulers/Ext/Language/en_us.Zeiterfassung_Ergaenzungen.php',
                'to' => 'custom/Extension/modules/Schedulers/Ext/Language/en_us.Zeiterfassung_Ergaenzungen.php',
            ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/Language/de_DE.customaccounts_tasks_1.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/Language/de_DE.customaccounts_tasks_1.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/Language/en_us.customaccounts_tasks_1.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/Language/en_us.customaccounts_tasks_1.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Language/de_DE.customtasks_isc_zeiterfassung_1.php',
             'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Language/de_DE.customtasks_isc_zeiterfassung_1.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Language/en_us.customtasks_isc_zeiterfassung_1.php',
             'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Language/en_us.customtasks_isc_zeiterfassung_1.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Language/de_DE.customprojecttask_tasks_1.php',
             'to' => 'custom/Extension/modules/ProjectTask/Ext/Language/de_DE.customprojecttask_tasks_1.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Language/en_us.customprojecttask_tasks_1.php',
             'to' => 'custom/Extension/modules/ProjectTask/Ext/Language/en_us.customprojecttask_tasks_1.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/de_DE.tt_pj_erfassung_ext.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Language/de_DE.tt_pj_erfassung_ext.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Language/en_us.tt_pj_erfassung_ext.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Language/en_us.tt_pj_erfassung_ext.php',
         ),
//Vardef Files
            array(
                'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/ISC_Zeiterfassung_favorites.php',
                'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/ISC_Zeiterfassung_favorites.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/projecttask_isc_zeiterfassung_1_ISC_Zeiterfassung.php',
                'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/projecttask_isc_zeiterfassung_1_ISC_Zeiterfassung.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/project_isc_zeiterfassung_1_ISC_Zeiterfassung.php',
                'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/project_isc_zeiterfassung_1_ISC_Zeiterfassung.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/Project/Ext/Vardefs/sugarfield_kosten_c.php',
                'to' => 'custom/Extension/modules/Project/Ext/Vardefs/sugarfield_kosten_c.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_buchungshinweis_c.php',
                'to' => 'custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_buchungshinweis_c.php',
            ),
            array(
                'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_kosten_c.php',
                'to' => 'custom/Extension/modules/ProjectTask/Ext/Vardefs/sugarfield_kosten_c.php',
            ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/Vardefs/accounts_tasks_1_Accounts.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/Vardefs/accounts_tasks_1_Accounts.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/TaskdependReadonlys.php',
             'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/TaskdependReadonlys.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/tasks_isc_zeiterfassung_1_ISC_Zeiterfassung.php',
             'to' => 'custom/Extension/modules/ISC_Zeiterfassung/Ext/Vardefs/tasks_isc_zeiterfassung_1_ISC_Zeiterfassung.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_tasks_1_ProjectTask.php',
             'to' => 'custom/Extension/modules/ProjectTask/Ext/Vardefs/projecttask_tasks_1_ProjectTask.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/accounts_tasks_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/accounts_tasks_1_Tasks.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/isc_ZE_task_rel.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/isc_ZE_task_rel.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/projecttask_tasks_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/projecttask_tasks_1_Tasks.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_date_end_c.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_date_end_c.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_project_c.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_project_c.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Vardefs/tasks_isc_zeiterfassung_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/tasks_isc_zeiterfassung_1_Tasks.php',
         ),
// Layoutdefs files
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/Layoutdefs/accounts_tasks_1_Accounts.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/Layoutdefs/accounts_tasks_1_Accounts.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/Layoutdefs/projecttask_tasks_1_ProjectTask.php',
             'to' => 'custom/Extension/modules/ProjectTask/Ext/Layoutdefs/projecttask_tasks_1_ProjectTask.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/Layoutdefs/tasks_isc_zeiterfassung_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/Layoutdefs/tasks_isc_zeiterfassung_1_Tasks.php',
         ),
//Scheduler Files
            array(
                'from' => '<basepath>/custom/Extension/modules/Schedulers/Ext/ScheduledTasks/isc_pjtCostCalculation_job.php',
                'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/isc_pjtCostCalculation_job.php',
            ),
// WirelessLayoutdefs files
         array(
             'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/WirelessLayoutdefs/accounts_tasks_1_Accounts.php',
             'to' => 'custom/Extension/modules/Accounts/Ext/WirelessLayoutdefs/accounts_tasks_1_Accounts.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/WirelessLayoutdefs/projecttask_tasks_1_ProjectTask.php',
             'to' => 'custom/Extension/modules/ProjectTask/Ext/WirelessLayoutdefs/projecttask_tasks_1_ProjectTask.php',
         ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/WirelessLayoutdefs/tasks_isc_zeiterfassung_1_Tasks.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/WirelessLayoutdefs/tasks_isc_zeiterfassung_1_Tasks.php',
         ),
//Hookdefs Files
            array(
                'from' => '<basepath>/custom/Extension/modules/ProjectTask/Ext/LogicHooks/CostCalculationHooks.php',
                'to' => 'custom/Extension/modules/ProjectTask/Ext/LogicHooks/CostCalculationHooks.php',
            ),
         array(
             'from' => '<basepath>/custom/Extension/modules/Tasks/Ext/LogicHooks/DeveloperCBeforeSaveHook.php',
             'to' => 'custom/Extension/modules/Tasks/Ext/LogicHooks/DeveloperCBeforeSaveHook.php',
         ),
        ),
);

<?php
$manifest = array(
    'key' => 'ISCL01',
    'name' => 'ISC_LenswareKundennummerAfterSave',
    'description' => 'Logic Hook zur Behandlung der Lensware Kundennummer nach dem Speichern eines Datensatzes',
    'version' => '1.0.0',
    'acceptable_sugar_versions' => array(
        'regex_matches' => array("10\.*", "11\.*", "12\.*", "13\.*")
    ),
    'acceptable_sugar_flavors' => array(
        'PRO',
        'ENT',
        'ULT'
    ),
    'author' => 'Alexander Ruppel',
    'is_uninstallable' => true,
    'published_date' => '2023-09-07',
    'type' => 'module',
    'remove_tables' => 'prompt',
);

$installdefs = array(
    'id' => 'ISC_LenswareKundennummerAfterSave',
    'copy' => array(
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/JSGroupings/AddLensware-kundennummerRounte.php',
            'to' => 'custom/Extension/application/Ext/JSGroupings/AddLensware-kundennummerRounte.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Accounts/Ext/LogicHooks/lenswareAfterSave.php',
            'to' => 'custom/Extension/modules/Accounts/Ext/LogicHooks/lenswareAfterSave.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Administration/lensware_kundennummer.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Administration/lensware_kundennummer.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/de_DE.LenswareKundenNummer.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/de_DE.LenswareKundenNummer.php',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/layouts/lensware-kundennummer-drawer/lensware-kundennummer-drawer.php',
            'to' => 'custom/clients/base/layouts/lensware-kundennummer-drawer/lensware-kundennummer-drawer.php',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/views/lensware-kundennummer-drawer/lensware-kundennummer-drawer.js',
            'to' => 'custom/clients/base/views/lensware-kundennummer-drawer/lensware-kundennummer-drawer.js',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/views/lensware-kundennummer-drawer/lensware-kundennummer-drawer.hbs',
            'to' => 'custom/clients/base/views/lensware-kundennummer-drawer/lensware-kundennummer-drawer.hbs',
        ),
        array(
            'from' => '<basepath>/custom/javascript/lensware-kundennummer-drawer-open.js',
            'to' => 'custom/javascript/lensware-kundennummer-drawer-open.js',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/api/ISC_lenswareApi.php',
            'to' => 'custom/clients/base/api/ISC_lenswareApi.php',
        ),
        array(
            'from' => '<basepath>/custom/modules/Accounts/lenswareAfterSaveClass.php',
            'to' => 'custom/modules/Accounts/lenswareAfterSaveClass.php',
        ),
    ),
);

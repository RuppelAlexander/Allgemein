<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

try {
    require_once 'modules/Administration/QuickRepairAndRebuild.php';

    $modules = ['Tasks','Notes']; // alle betroffenen Module
    $actions = ['rebuildExtensions','clearVardefs','clearJsFiles','repairDatabase'];

    $rac = new RepairAndClear();
    // autoExecute = true, showOutput = false
    $rac->repairAndClearAll($actions, $modules, true, false);

    if (class_exists('MetaDataManager')) {
        MetaDataManager::refreshCache(); // UI bekommt neue Vardefs/Labels
    }

    $GLOBALS['log']->fatal('[ISC-DEEPL] post_install: extensions rebuilt + DB repaired');
} catch (\Throwable $e) {
    $GLOBALS['log']->fatal('[ISC-DEEPL] post_install ERROR: '.$e->getMessage());
}

<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 06.09.2023
 * Change Date   : 06.09.2023
 * Main Program  : lensware-kundennummer-drawer-metadata.php
 * Description   : lenswareAfterSave.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

//custom/Extension/modules/Accounts/Ext/LogicHooks/lenswareAfterSave.php
$hook_array['after_save'][] = Array(
    1, // Sortierungsindex
    'Lensware Kundennummer After Save', // Beschreibung des Logic Hooks
    'custom/modules/Accounts/lenswareAfterSaveClass.php', // Pfad zur Logic Hook-Datei
    'lenswareAfterSaveClass', // Name der Klasse
    'lenswareAfterSaveMethod' // Name der Methode
);
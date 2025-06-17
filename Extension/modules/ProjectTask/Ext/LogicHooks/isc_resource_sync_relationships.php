<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.06.2025
 * Change Date   : 11.06.2025
 * Main Program  : Intern_upgrade_test_dev
 * Description   : isc_resource_sync_relationships.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


$hook_version = 1;
$hook_array = [];

/*  Benutzer wählt einen Ressource-User ⇒ Dialog erzwingen (Fehlercode) */
$hook_array['before_relationship_add'][] = [
    660,
    'ISC RS: Dialog erzwingen',
    'custom/modules/ProjectTask/isc_resource_sync_RelHooks.php',
    'ISC_ResourceSync_RelHooks',
    'beforeRelAdd'
];

/*  Nach Bestätigung ⇒ User als Projekt-Ressource anlegen */
$hook_array['after_relationship_add'][] = [
    661,
    'ISC RS: User → Projekt synchronisieren',
    'custom/modules/ProjectTask/isc_resource_sync_RelHooks.php',
    'ISC_ResourceSync_RelHooks',
    'afterRelAdd'
];

/*  Beim Entfernen ⇒ evtl. aus Projekt lösen */
$hook_array['after_relationship_delete'][] = [
    662,
    'ISC RS: verwaiste Projekt-Ressource entfernen',
    'custom/modules/ProjectTask/isc_resource_sync_RelHooks.php',
    'ISC_ResourceSync_RelHooks',
    'afterRelDelete'
];

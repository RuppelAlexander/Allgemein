<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 13.11.2025
 * Change Date   : 13.11.2025
 * Main Program  : ISC_Ressourcenverwaltung
 * Description   : isc_rs_projecttask.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

$hook_array['after_relationship_delete'][] = [
    12,
    'Ressourcen-Sync beim Entfernen eines Users aus ProjectTask',
    'custom/modules/ProjectTask/ISC_RS_ProjectTaskHook.php',
    'ISC_RS_ProjectTaskHook',
    'afterRelRemoveTaskUser',
];
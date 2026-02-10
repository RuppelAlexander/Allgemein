<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.11.2025
 * Change Date   : 11.11.2025
 * Main Program  : ISC_Ressourcenverwaltung
 * Description   : isc_rs_tasks.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

$hook_array['before_save'][] = [
    10,
    'RS(T): detect assigned_user_id change',
    'custom/modules/Tasks/ISC_RS_TasksHook.php',
    'ISC_RS_TasksHook',
    'beforeSaveDetectChange',
];


$hook_array['after_save'][] = [
    10,
    'RS(T): sync resources on assign',
    'custom/modules/Tasks/ISC_RS_TasksHook.php',
    'ISC_RS_TasksHook',
    'afterSaveSync',
];

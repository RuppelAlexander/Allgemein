<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : MoschkauM
 * Create Date   : 28.02.2025
 * Change Date   : 28.02.2025
 * Main Program  : Zeiterfassung Usability-Anpassungen
 * Description   : Hook zum setzen des Statues
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$hook_array['before_save'][] = array(
    1,
    'Set Task Status',
    null,
    \Sugarcrm\Sugarcrm\custom\modules\Tasks\ISC_statusHook::class,
    'setStatus'
);

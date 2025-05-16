<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 15.12.2023
 * Change Date   : 11.06.2024
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Before save Hook
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 11.06.2024  DontG  fix Line end LF
 * ----------------------------------------------------------------------------
 */
$hook_array['before_save'][] = Array(
    300,
    'Nachberechnung der Kosten',
    'custom/modules/ProjectTask/CostCalculationHook.php',
    'CostCalculationHook',
    'QueueJob'
);

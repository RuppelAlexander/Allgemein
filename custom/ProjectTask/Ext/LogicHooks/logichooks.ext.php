<?php
// WARNING: The contents of this file are auto-generated.
?>
<?php
// Merged from custom/Extension/modules/ProjectTask/Ext/LogicHooks/CostCalculationHooks.php

/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 15.12.2023
 * Change Date   : 15.12.2023
 * Main Program  : sugar_intern_update_dev
 * Description   : logic_hooks.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

//custom/Extension/modules/ProjectTask/Ext/LogicHooks/CostCalculationHooks.php

$hook_array['before_save'][] = Array(
    300,
    'Nachberechnung der Kosten',
    'custom/modules/ProjectTask/CostCalculationHook.php',
    'CostCalculationHook',
    'QueueJob'
);
?>

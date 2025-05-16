<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 22.11.2022
 * Change Date   : 22.11.2022
 * Main Program  : sugarcrm_intern_upgradetest_dev
 * Description   : DeveloperCBeforeSaveHook.php
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$hook_array['before_save'][] = array(
	1,
	'Set Developer id if Empty',
	'custom/modules/Tasks/DeveloperCBeforeSaveHook.php',
	'DeveloperCBeforeSaveHook',
	'beforeSave_SetDeveloperC'
);

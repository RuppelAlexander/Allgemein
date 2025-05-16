<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : MoschkauM
 * Create Date   : 26.03.2024
 * Change Date   : 26.03.2024
 * Main Program  : Tasks Company abbreviation
 * Description   : post install script
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
if (! defined('sugarEntry') || ! sugarEntry) die('Not A Valid Entry Point');
// /scripts/post_install.php
function post_install() {
	//quick repair
	$autoexecute = false; //execute the SQL
	$show_output = true; //output to the screen
	require_once("modules/Administration/QuickRepairAndRebuild.php");
	$quickrepair = new RepairAndClear();
	$quickrepair->repairAndClearAll(array('clearAll'),array(translate('LBL_ALL_MODULES')), $autoexecute,$show_output);
}
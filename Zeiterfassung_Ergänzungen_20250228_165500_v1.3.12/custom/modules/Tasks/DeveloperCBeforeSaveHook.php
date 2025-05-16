<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 22.11.2022
 * Change Date   : 04.01.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : Set Developer if empty
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

class DeveloperCBeforeSaveHook
{
	/**
	 * Set Developer  if Empty
	 * @param SugarBean $bean
	 * @param string    $event
	 * @param array     $arguments
	 * @return void
	 */
	function beforeSave_SetDeveloperC($bean, $event, $arguments)
	{
		// If Developer Empty set Developers id to assigned User id
		$Developers_id = $bean->user_id1_c;
		if (empty($Developers_id) && !empty($bean->assigned_user_id)) {
			$bean->user_id1_c = $bean->assigned_user_id;
		}

	}
}

<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 11.06.2024
 * Change Date   : 11.06.2024
 * Main Program  : isc_ZE_task_rel
 * Description   : Set Flex related field options , Readonly account
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ------------------------------------------------------------------------------
 * ------------------------------------------------------------------------------
 */
$dictionary["Task"]["fields"]['parent_type']['options']='parent_type_display_tasks';
$dictionary["Task"]["fields"]['parent_name']['options']='parent_type_display_tasks';
$dictionary["Task"]["fields"]["accounts_tasks_1_name"]['readonly_formula']='';
$dictionary["Task"]["fields"]["accounts_tasks_1_name"]['readonly']=true;

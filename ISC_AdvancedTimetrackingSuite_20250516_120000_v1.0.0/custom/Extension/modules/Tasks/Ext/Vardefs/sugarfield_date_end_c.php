<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 17.11.2022
 * Change Date   : 04.01.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : Extra Felder
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$dictionary['Task']['fields']['date_end_c']['labelValue']='Aufgabe abgeschlossen';
$dictionary['Task']['fields']['date_end_c']['enforced']='false';
$dictionary['Task']['fields']['date_end_c']['dependency']='';
$dictionary['Task']['fields']['date_end_c']['required_formula']='equal($status,"Completed")';
$dictionary['Task']['fields']['date_end_c']['readonly_formula']='';
?>
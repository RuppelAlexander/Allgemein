<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 07.05.2024
 * Change Date   : 30.01.2025
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Field settings
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 11.06.2024  DontG  Update formula (greaterThan not equal)
 * 30.01.2025  DontG  Fix Wrong Field estimated_effort use budget_c
 * ----------------------------------------------------------------------------
 */
$dictionary['ProjectTask']['fields']['kosten_c']['duplicate_merge_dom_value']=0;
$dictionary['ProjectTask']['fields']['kosten_c']['labelValue']='Kosten';
$dictionary['ProjectTask']['fields']['kosten_c']['calculated']='1';
$dictionary['ProjectTask']['fields']['kosten_c']['formula']='ifElse(
greaterThan($budget_c,0),
rollupSum($projecttask_isc_zeiterfassung_1,"working_hours"),
$kosten_c
)';
$dictionary['ProjectTask']['fields']['kosten_c']['enforced']='1';
$dictionary['ProjectTask']['fields']['kosten_c']['dependency']='';
$dictionary['ProjectTask']['fields']['kosten_c']['required_formula']='';
$dictionary['ProjectTask']['fields']['kosten_c']['readonly_formula']='';

?>

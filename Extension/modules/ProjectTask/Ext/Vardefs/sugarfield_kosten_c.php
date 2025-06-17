<?php
 // created: 2024-02-14 17:17:36
$dictionary['ProjectTask']['fields']['kosten_c']['duplicate_merge_dom_value']=0;
$dictionary['ProjectTask']['fields']['kosten_c']['labelValue']='Kosten';
$dictionary['ProjectTask']['fields']['kosten_c']['calculated']='1';
$dictionary['ProjectTask']['fields']['kosten_c']['formula']='ifElse(
not(equal($estimated_effort,"")),
rollupSum($projecttask_isc_zeiterfassung_1,"working_hours"),
$kosten_c
)';
$dictionary['ProjectTask']['fields']['kosten_c']['enforced']='1';
$dictionary['ProjectTask']['fields']['kosten_c']['dependency']='';
$dictionary['ProjectTask']['fields']['kosten_c']['required_formula']='';
$dictionary['ProjectTask']['fields']['kosten_c']['readonly_formula']='';

 ?>
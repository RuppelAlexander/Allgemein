<?php
 // created: 2017-11-29 14:54:00
 global $sugar_config;
 $Filter = $sugar_config['ISCProjektTaskStatus'];
$dictionary['ProjectTask']['fields']['status']['default']=$Filter;
$dictionary['ProjectTask']['fields']['status']['options']='isc_projecttaskstatus';
 ?>

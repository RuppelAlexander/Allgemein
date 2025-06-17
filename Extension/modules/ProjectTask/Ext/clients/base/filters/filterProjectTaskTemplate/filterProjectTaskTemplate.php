<?php
//ISC KOK Filter auf Status, ausgewähltes Projekt sowie aktuellem Nutzer
global $sugar_config;
$Filter = $sugar_config['ISCProjektTaskStatus'];
$viewdefs['ProjectTask']['base']['filter']['filterProjectTaskTemplate'] = array(
    'create' => true,
    'filters' => array(
        array(
            'id' => 'filterProjectTaskTemplate',
            'name' => 'LBL_FILTER_PROJECTTASK_TEMPLATE',
            'filter_definition' => array(
                array(
                    'status' => array(
                        '$in' => array($Filter),
                    ),
                    'project_id' => array(
                        '$in' => array(),
                    ),
                    '$isc_user' => '',
                )
            ),
            'editable' => true,
            'is_template' => true,
        )
    )
);

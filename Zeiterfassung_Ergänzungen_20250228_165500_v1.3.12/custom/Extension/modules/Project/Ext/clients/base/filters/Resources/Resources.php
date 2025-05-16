<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 06.02.2018
 * Change Date   : 17.12.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Filter für Projekte anhand aktiver Projektaufgaben für User
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 14.12.2018  TF      Aktivierung des Create-Filters & Korrektur der Bedingung
 * 17.12.2018  TF      is_template muss gesetzt werden (für QuickSearch)
 * ----------------------------------------------------------------------------
 */

// WARNING: The contents of this file are auto-generated.
//ISC Kok This filter selects all entries which have the current_user set as resource
//and which start_date is <= today and which end date is =>today.
global $sugar_config;
$Filter = $sugar_config['ISCProjektStatus'];
$module_name = 'Project';
$viewdefs[$module_name]['base']['filter']['Resources'] = array(
    'create' => true,
    'filters' => array(
        array(
            'id' => 'Resources',
            'name' => 'LBL_RESOURCES_FILTER',
            'filter_definition' => array(
                array(
                    'status' => array(
                        '$equals' => $Filter,
                    ),
                    'id' => array(
                        '$isc_current_user' => '1',
                    ),
                )
            ),
            'editable' => false,
            'is_template' => true,
        )
    )
);

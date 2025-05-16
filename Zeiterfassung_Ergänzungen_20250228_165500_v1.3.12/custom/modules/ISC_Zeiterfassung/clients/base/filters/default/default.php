<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 02.07.2019
 * Change Date   : 02.07.2019
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Removed "my favorites" filter
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 12.06.2024  DontG  fix line endings LF
 * ----------------------------------------------------------------------------
 */
$viewdefs['ISC_Zeiterfassung']['base']['filter']['default'] = array (
  'default_filter' => 'Heute',
  'fields' =>
  array (
    'date_from' =>
    array (
    ),
    'date_to' =>
    array (
    ),
    'project_isc_zeiterfassung_1_name' =>
    array (
    ),
    'projecttask_isc_zeiterfassung_1_name' =>
    array (
    ),
    'description' =>
    array (
    ),
    /*'$favorite' =>
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_FAVORITES_FILTER',
    ),*/
    'assigned_user_name' =>
    array (
    ),
    'billing' =>
    array (
    ),
  ),
);

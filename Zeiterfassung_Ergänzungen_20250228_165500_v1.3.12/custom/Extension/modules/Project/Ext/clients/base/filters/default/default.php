<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 06.02.2018
 * Change Date   : 14.12.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Filter für Projekte
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 14.12.2018  TF      Felder für Create-Filter hinzugefügt
 * ----------------------------------------------------------------------------
 */
 
$viewdefs['Project']['base']['filter']['default'] = array (
  'default_filter' => 'Resources',
  'fields' =>
  array (
    'name' => array(),
    'status' => array (),
  ),
);
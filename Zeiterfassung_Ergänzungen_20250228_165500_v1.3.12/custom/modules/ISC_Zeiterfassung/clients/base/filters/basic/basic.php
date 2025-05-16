<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 03.12.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Adds basic filter
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * 01.02.2019  RK      Removed "My Favorites" filter
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$viewdefs['ISC_Zeiterfassung']['base']['filter']['basic'] = array(
    'create'               => true,
    'quicksearch_field'    => array('description'),
    'quicksearch_priority' => 1,
    'quicksearch_split_terms' => false,
    'filters'              => array(
        array(
            'id'                => 'all_records',
            'name'              => 'LBL_LISTVIEW_FILTER_ALL',
            'filter_definition' => array(),
            'editable'          => false
        ),
        array(
            'id'                => 'assigned_to_me',
            'name'              => 'LBL_ASSIGNED_TO_ME',
            'filter_definition' => array(
                '$owner' => '',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'recently_viewed',
            'name'              => 'LBL_RECENTLY_VIEWED',
            'filter_definition' => array(
                '$tracker' => '-7 DAY',
            ),
            'editable'          => false
        ),
        array(
            'id'                => 'recently_created',
            'name'              => 'LBL_NEW_RECORDS',
            'filter_definition' => array(
                'date_entered' => array(
                    '$dateRange' => 'last_7_days',
                ),
            ),
            'editable'          => false
        ),
    ),
);

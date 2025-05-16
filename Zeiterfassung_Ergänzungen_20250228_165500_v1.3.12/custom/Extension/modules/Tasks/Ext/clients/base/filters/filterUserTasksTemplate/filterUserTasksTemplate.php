<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 17.11.2022
 * Change Date   : 04.02.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : Filter
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 04.02.2023  DontG Status einschränkung
 * ----------------------------------------------------------------------------
 */
$viewdefs['Tasks']['base']['filter']['filterUserTasksTemplate'] = array(
    'create' => true,
    'filters' => array(
        array(
            'id' => 'filterUserTasksTemplate',
            'name' => 'LBL_FILTER_USERTASK_TEMPLATE',
            'filter_definition' => array(
                array(
                    'assigned_user_id' => array(
                        '$in' => array(),
                    ),
					'status' => array(
						'$not_in' => array('Deferred','Completed'),
					),
                )
            ),
            'editable' => true,
            'is_template' => true,
        )
    )
);

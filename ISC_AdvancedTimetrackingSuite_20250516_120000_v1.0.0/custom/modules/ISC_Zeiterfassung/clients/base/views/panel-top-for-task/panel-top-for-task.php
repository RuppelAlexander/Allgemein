<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 23.11.2022
 * Change Date   : 23.11.2022
 * Main Program  : isc_ZE_task_rel
 * Description   : Subpanel Top for tt_task relation
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$viewdefs['ISC_Zeiterfassung']['base']['view']['panel-top-for-task'] = array(
    'type'     => 'panel-top-for-task',
    'template' => 'panel-top',
    'buttons'  => array(
        array(
            'type'      => 'actiondropdown',
            'name'      => 'panel_dropdown',
            'css_class' => 'pull-right',
            'buttons'   => array(
                array(
                    'type'       => 'sticky-rowaction',
                    'icon'       => 'fa-plus',
                    'name'       => 'create_button',
                    'label'      => ' ',
                    'acl_action' => 'create',
                    'tooltip'    => 'LBL_CREATE_BUTTON_LABEL',
                ),
                array(
                    'type'      => 'link-action',
                    'name'      => 'select_button',
                    'label'     => 'LBL_ASSOC_RELATED_RECORD',
                    'css_class' => 'disabled'
                ),
            ),
        ),
    ),
);

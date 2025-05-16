<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 02.07.2019
 * Change Date   : 02.07.2019
 * Main Program  : Zeiterfassung_Ergänzungen,isc_ZE_task_rel
 * Description   : Layout looks like list view now
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 07.06.2023  DontG  Change Layout
 * ----------------------------------------------------------------------------
 */
$module_name = 'ISC_Zeiterfassung';
$viewdefs[$module_name] = array(
    'base' => array(
        'view' => array(
            'record' => array(
                'buttons'      => array(
                    0 => array(
                        'type'      => 'button',
                        'name'      => 'cancel_button',
                        'label'     => 'LBL_CANCEL_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn'    => 'edit',
                        'events'    => array(
                            'click' => 'button:cancel_button:click',
                        ),
                    ),
                    1 => array(
                        'type'       => 'rowaction',
                        'event'      => 'button:save_button:click',
                        'name'       => 'save_button',
                        'label'      => 'LBL_SAVE_BUTTON_LABEL',
                        'css_class'  => 'btn btn-primary',
                        'showOn'     => 'edit',
                        'acl_action' => 'edit',
                    ),
                    2 => array(
                        'type'    => 'actiondropdown',
                        'name'    => 'main_dropdown',
                        'primary' => true,
                        'showOn'  => 'view',
                        'buttons' => array(
                            0 => array(
                                'type'       => 'rowaction',
                                'event'      => 'button:edit_button:click',
                                'name'       => 'edit_button',
                                'label'      => 'LBL_EDIT_BUTTON_LABEL',
                                'acl_action' => 'edit',
                            ),
                            1 => array(
                                'type'       => 'shareaction',
                                'name'       => 'share',
                                'label'      => 'LBL_RECORD_SHARE_BUTTON',
                                'acl_action' => 'view',
                            ),
                            2 => array(
                                'type'       => 'pdfaction',
                                'name'       => 'download-pdf',
                                'label'      => 'LBL_PDF_VIEW',
                                'action'     => 'download',
                                'acl_action' => 'view',
                            ),
                            3 => array(
                                'type'       => 'pdfaction',
                                'name'       => 'email-pdf',
                                'label'      => 'LBL_PDF_EMAIL',
                                'action'     => 'email',
                                'acl_action' => 'view',
                            ),
                            4 => array(
                                'type' => 'divider',
                            ),
                            5 => array(
                                'type'       => 'rowaction',
                                'event'      => 'button:find_duplicates_button:click',
                                'name'       => 'find_duplicates_button',
                                'label'      => 'LBL_DUP_MERGE',
                                'acl_action' => 'edit',
                            ),
                            6 => array(
                                'type'       => 'rowaction',
                                'event'      => 'button:duplicate_button:click',
                                'name'       => 'duplicate_button',
                                'label'      => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'ISC_Zeiterfassung',
                                'acl_action' => 'create',
                            ),
                            7 => array(
                                'type'       => 'rowaction',
                                'event'      => 'button:audit_button:click',
                                'name'       => 'audit_button',
                                'label'      => 'LNK_VIEW_CHANGE_LOG',
                                'acl_action' => 'view',
                            ),
                            8 => array(
                                'type' => 'divider',
                            ),
                            9 => array(
                                'type'       => 'rowaction',
                                'event'      => 'button:delete_button:click',
                                'name'       => 'delete_button',
                                'label'      => 'LBL_DELETE_BUTTON_LABEL',
                                'acl_action' => 'delete',
                            ),
                        ),
                    ),
                    3 => array(
                        'name' => 'sidebar_toggle',
                        'type' => 'sidebartoggle',
                    ),
                ),
                'panels'       => array(
                    0 => array(
                        'name'   => 'panel_header',
                        'label'  => 'LBL_RECORD_HEADER',
                        'header' => true,
                        'fields' =>
                            array(
                                0 =>
                                    array(
                                        'name'          => 'picture',
                                        'type'          => 'avatar',
                                        'width'         => 42,
                                        'height'        => 42,
                                        'dismiss_label' => true,
                                        'readonly'      => true,
                                    ),
                                1 => array(
                                    'name' => 'name',
                                    'span' => 12,
                                    'link' => false,
                                ),
                                2 => array(
                                    'name'          => 'favorite',
                                    'label'         => 'LBL_FAVORITE',
                                    'type'          => 'favorite',
                                    'readonly'      => true,
                                    'dismiss_label' => true,
                                ),
                                3 => array(
                                    'name'          => 'follow',
                                    'label'         => 'LBL_FOLLOW',
                                    'type'          => 'follow',
                                    'readonly'      => true,
                                    'dismiss_label' => true,
                                ),
                            ),
                    ),
                    1 => array(
                        'name'         => 'panel_body',
                        'label'        => 'LBL_RECORD_BODY',
                        'columns'      => 2,
                        'labelsOnTop'  => true,
                        'placeholders' => true,
                        'newTab'       => false,
                        'panelDefault' => 'expanded',
                        'fields'       => array(
                            0 => array(
                                'name'    => 'description',
                                'label'   => 'LBL_DESCRIPTION',
                                'enabled' => true,
                                'link'    => false,
                                'default' => true,
                                'span'    => 12,
                            ),
                            1 => array(
                                'name'      => 'date_from',
                                'label'     => 'LBL_DATE_FROM',
                                'enabled'   => true,
                                'default'   => true,
                                'css_class' => 'overflow-visible',
                                'span'      => 6,
                            ),
                            2 => array(
                                'name'      => 'date_to',
                                'label'     => 'LBL_DATE_TO',
                                'enabled'   => true,
                                'default'   => true,
                                'css_class' => 'overflow-visible',
                                'width'     => 'small',
                                'span'      => 6,
                            ),
                            3 => array(
                                'name'    => 'working_hours',
                                'label'   => 'LBL_WORKING_HOURS',
                                'enabled' => true,
                                'default' => true,
                                'width'   => 'small',
                                'span'    => 6,
                            ),
                            4 => array(
                                'name'    => 'billing',
                                'label'   => 'LBL_BILLING',
                                'enabled' => true,
                                'default' => true,
                                'width'   => 'small',
                                'span'    => 6,
                            ),
                            5 => array(
                                'name' => 'tasks_isc_zeiterfassung_1_name',
                            ),
                            6 => array(
                                'name'    => 'assigned_user_name',
                                'label'   => 'LBL_ASSIGNED_TO_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link'    => true,
                                'width'   => 'small',
                            ),
                            7 => array(
                                'name'  => 'project_isc_zeiterfassung_1_name',
                                'label' => 'LBL_PROJECT_ISC_ZEITERFASSUNG_1_FROM_PROJECT_TITLE',
                            ),
                            8 => array(
                                'name'  => 'projecttask_isc_zeiterfassung_1_name',
                                'label' => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_PROJECTTASK_TITLE',
                            ),
                        ),
                    ),
                    2 => array(
                        'name'         => 'panel_hidden',
                        'label'        => 'LBL_SHOW_MORE',
                        'hide'         => true,
                        'columns'      => 2,
                        'labelsOnTop'  => true,
                        'placeholders' => true,
                        'newTab'       => false,
                        'panelDefault' => 'collapsed',
                        'fields'       => array(
                            0 => array(
                                'name'    => 'team_name',
                                'label'   => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                            ),
                            1 => array(
                                'name'    => 'date_modified',
                                'enabled' => true,
                                'default' => false,
                            ),
                            2 => array(
                                'name'    => 'date_entered',
                                'enabled' => true,
                                'default' => false,
                            ),
                            3 => array(
                                'name'     => 'created_by_name',
                                'label'    => 'LBL_CREATED',
                                'enabled'  => true,
                                'readonly' => true,
                                'id'       => 'CREATED_BY',
                                'link'     => true,
                                'default'  => false,
                            ),
                            4 => array(
                                'name'     => 'modified_by_name',
                                'label'    => 'LBL_MODIFIED',
                                'enabled'  => true,
                                'readonly' => true,
                                'id'       => 'MODIFIED_USER_ID',
                                'link'     => true,
                                'default'  => false,
                            ),
                            5 => array(),
                        ),
                    ),
                ),
                'templateMeta' => array(
                    'useTabs' => false,
                ),
            ),
        ),
    ),
);

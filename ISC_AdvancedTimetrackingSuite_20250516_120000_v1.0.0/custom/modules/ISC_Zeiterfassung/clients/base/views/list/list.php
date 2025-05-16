<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 07.06.2023
 * Main Program  : Extension,Zeiterfassung_Ergänzungen,isc_ZE_task_rel
 * Description   : Changed field widths
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 04.02.2019  TF      Sortierung geändert von änderungsdatum auf Startdatum
 * 02.07.2019  RK      Removed "name" field
 * 07.06.2023  DontG   add Field tasks_isc_zeiterfassung_1_name (reltask)
 * ----------------------------------------------------------------------------
 */
$module_name = 'ISC_Zeiterfassung';
$viewdefs[$module_name] = array(
    'base' => array(
        'view' => array(
            'list' => array(
                'panels'  => array(
                    array(
                        'label'  => 'LBL_PANEL_1',
                        'fields' => array(
                            array(
                                'name'    => 'description',
                                'label'   => 'LBL_DESCRIPTION',
                                'enabled' => true,
                                'link'    => false,
                                'default' => true,
                                'width'   => 'large',
                            ),
                            array(
                                'name'      => 'date_from',
                                'label'     => 'LBL_DATE_FROM',
                                'enabled'   => true,
                                'default'   => true,
                                'css_class' => 'overflow-visible',
                            ),
                            array(
                                'name'      => 'date_to',
                                'label'     => 'LBL_DATE_TO',
                                'enabled'   => true,
                                'default'   => true,
                                'css_class' => 'overflow-visible',
                                'width'     => 'xsmall',
                            ),
                            array(
                                'name'     => 'tasks_isc_zeiterfassung_1_name',
                                'type'     => 'reltask',
                                'label'    => 'LBL_TASKS_ISC_ZEITERFASSUNG_1_FROM_TASKS_TITLE',
                                'enabled'  => true,
                                'id'       => 'TASKS_ISC_ZEITERFASSUNG_1TASKS_IDA',
                                'link'     => true,
                                'sortable' => false,
                                'default'  => true,
                                'width'    => 'small',
                            ),
                            array(
                                'name'     => 'project_isc_zeiterfassung_1_name',
                                'label'    => 'LBL_PROJECT_ISC_ZEITERFASSUNG_1_FROM_PROJECT_TITLE',
                                'enabled'  => true,
                                'id'       => 'PROJECT_ISC_ZEITERFASSUNG_1PROJECT_IDA',
                                'link'     => true,
                                'sortable' => false,
                                'default'  => true,
                            ),
                            array(
                                'name'     => 'projecttask_isc_zeiterfassung_1_name',
                                'label'    => 'LBL_PROJECTTASK_ISC_ZEITERFASSUNG_1_FROM_PROJECTTASK_TITLE',
                                'enabled'  => true,
                                'id'       => 'PROJECTTASK_ISC_ZEITERFASSUNG_1PROJECTTASK_IDA',
                                'link'     => true,
                                'sortable' => false,
                                'default'  => true,
                            ),
                            array(
                                'name'    => 'working_hours',
                                'label'   => 'LBL_WORKING_HOURS',
                                'enabled' => true,
                                'default' => true,
                                'width'   => 'small',
                            ),
                            array(
                                'name'    => 'billing',
                                'label'   => 'LBL_BILLING',
                                'enabled' => true,
                                'default' => true,
                                'width'   => 'small',
                            ),
                            array(
                                'name'    => 'assigned_user_name',
                                'label'   => 'LBL_ASSIGNED_TO_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link'    => true,
                                'width'   => 'small',
                            ),
                            array(
                                'name'    => 'team_name',
                                'label'   => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                            ),
                            array(
                                'name'    => 'date_modified',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name'    => 'date_entered',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name'     => 'created_by_name',
                                'label'    => 'LBL_CREATED',
                                'enabled'  => true,
                                'readonly' => true,
                                'id'       => 'CREATED_BY',
                                'link'     => true,
                                'default'  => false,
                            ),
                            array(
                                'name'     => 'modified_by_name',
                                'label'    => 'LBL_MODIFIED',
                                'enabled'  => true,
                                'readonly' => true,
                                'id'       => 'MODIFIED_USER_ID',
                                'link'     => true,
                                'default'  => false,
                            ),
                            array(
                                'name'    => 'working_minutes',
                                'label'   => 'LBL_WORKING_MINUTES',
                                'enabled' => true,
                                'default' => false,
                                'width'   => 'small',
                            ),
                        ),
                    ),
                ),
                'orderBy' => array(
                    'field'     => 'date_from',
                    'direction' => 'desc',
                ),
            ),
        ),
    ),
);

<?php
// created: 2018-10-23 11:46:32
$viewdefs['ProjectTask']['DetailView'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '2',
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'includes' => 
    array (
      0 => 
      array (
        'file' => 'modules/ProjectTask/ProjectTask.js',
      ),
      1 => 
      array (
        'file' => 'custom/modules/ProjectTask/projectTask.js',
      ),
    ),
    'form' => 
    array (
      'buttons' => 
      array (
        0 => 'EDIT',
        1 => 
        array (
          'customCode' => '{if $bean->aclAccess("edit")}<input type="submit" name="EditTaskInGrid" value=" {$MOD.LBL_EDIT_TASK_IN_GRID_TITLE} " title="{$MOD.LBL_EDIT_TASK_IN_GRID_TITLE}"  class="button" onclick="this.form.record.value=\'{$fields.project_id.value}\';prep_edit_task_in_grid(this.form);" />{/if}',
          'sugar_html' => 
          array (
            'type' => 'submit',
            'value' => ' {$MOD.LBL_EDIT_TASK_IN_GRID_TITLE} ',
            'htmlOptions' => 
            array (
              'title' => '{$MOD.LBL_EDIT_TASK_IN_GRID_TITLE}',
              'class' => 'button',
              'name' => 'EditTaskInGrid',
              'onclick' => 'this.form.record.value=\'{$fields.project_id.value}\';prep_edit_task_in_grid(this.form);',
            ),
            'template' => '{if $bean->aclAccess("edit")}[CONTENT]{/if}',
          ),
        ),
        5 => 
        array (
          'customCode' => '<input title="Zu Ticket konvertieren" class="button" onclick="convertTask(\'{$fields.id.value}\');" type="submit" name="Zu Ticket konvertieren" value="zu Ticket konvertieren">',
        ),
      ),
      'hideAudit' => true,
    ),
    'useTabs' => false,
    'tabDefs' => 
    array (
      'DEFAULT' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => true,
  ),
  'panels' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        0 => 'name',
        1 => 
        array (
          'name' => 'project_task_id',
          'label' => 'LBL_TASK_ID',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'converted_c',
          'label' => 'LBL_CONVERTED',
        ),
        1 => 
        array (
          'name' => 'ticket_c',
          'studio' => 'visible',
          'label' => 'LBL_TICKET',
        ),
      ),
      2 => 
      array (
        0 => 'status',
        1 => 'priority',
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'date_inquiry_c',
          'label' => 'LBL_DATE_INQUIRY',
        ),
        1 => 
        array (
          'name' => 'budget_c',
          'label' => 'LBL_BUDGET',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'billing_c',
          'label' => 'LBL_BILLING',
        ),
        1 => 
        array (
          'name' => 'faktura_c',
          'label' => 'LBL_FAKTURA',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'order_date_c',
          'label' => 'LBL_ORDER_DATE',
        ),
        1 => 
        array (
          'name' => 'abgerechnet_c',
          'label' => 'LBL_ABGERECHNET',
        ),
      ),
      6 => 
      array (
        0 => 'date_start',
        1 => 'date_finish',
      ),
      7 => 
      array (
        0 => 'percent_complete',
        1 => 
        array (
          'name' => 'milestone_flag',
          'label' => 'LBL_MILESTONE_FLAG',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'project_name',
          'customCode' => '<a href="index.php?module=Project&action=DetailView&record={$fields.project_id.value}">{$fields.project_name.value}&nbsp;</a>',
          'label' => 'LBL_PARENT_ID',
        ),
        1 => 
        array (
          'name' => 'actual_duration',
          'customCode' => '{$fields.actual_duration.value}&nbsp;{$fields.duration_unit.value}',
          'label' => 'LBL_ACTUAL_DURATION',
        ),
      ),
      9 => 
      array (
        0 => 'task_number',
        1 => 'order_number',
      ),
      10 => 
      array (
        0 => 
        array (
          'name' => 'actual_effort',
          'label' => 'LBL_ACTUAL_EFFORT',
        ),
        1 => 'estimated_effort',
      ),
      11 => 
      array (
        0 => 
        array (
          'name' => 'description',
        ),
      ),
      12 => 
      array (
        0 => 
        array (
          'name' => 'resource_id',
          'customCode' => '{$resource}',
          'label' => 'LBL_RESOURCE',
        ),
        1 => 
        array (
          'name' => 'team_name',
        ),
      ),
      13 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_USER_ID',
        ),
      ),
      14 => 
      array (
        0 => 
        array (
          'name' => 'projecttask_projecttask_1_name',
        ),
      ),
    ),
  ),
);
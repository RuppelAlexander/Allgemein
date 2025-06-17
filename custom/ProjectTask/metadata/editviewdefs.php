<?php
$viewdefs['ProjectTask'] = 
array (
  'EditView' => 
  array (
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
          'file' => 'custom/modules/ProjectTask/projectTaskEdit.js',
        ),
      ),
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'customCode' => '{if $FROM_GRID}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'Save\'; this.form.return_module.value=\'Project\'; this.form.return_action.value=\'EditGridView\'; this.form.return_id.value=\'{$project_id}\'; return check_form(\'EditView\');"	type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}"/>{else}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'Save\';isc_handleProjektVk(); return check_form(\'EditView\');" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}&nbsp;',
          ),
          1 => 
          array (
            'customCode' => '{if $FROM_GRID}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.grid.closeTaskDetails()"; type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{else}{if !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($fields.id.value))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'DetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($smarty.request.return_id))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'DetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'index\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{/if}{/if}&nbsp;',
          ),
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_editview_panel1' => 
      array (
      ),
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'project_task_id',
            'type' => 'readonly',
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
          0 => 
          array (
            'name' => 'status',
            'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
          ),
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
          0 => 
          array (
            'name' => 'date_start',
          ),
          1 => 
          array (
            'name' => 'date_finish',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'percent_complete',
            'customCode' => '<span id="percent_complete_text">{$fields.percent_complete.value}</span><input type="hidden" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" value="{$fields.percent_complete.value}" /></tr>',
          ),
          1 => 'milestone_flag',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'project_name',
            'label' => 'LBL_PROJECT_NAME',
          ),
          1 => 
          array (
            'name' => 'duration',
            'type' => 'readonly',
            'customCode' => '{$fields.duration.value}&nbsp;{$fields.duration_unit.value}',
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
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'team_name',
            'type' => 'readonly',
            'label' => 'LBL_TEAM',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_USER_NAME',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'projecttask_projecttask_1_name',
          ),
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'buchungshinweis_c',
            'label' => 'LBL_BUCHUNGSHINWEIS',
          ),
        ),
      ),
    ),
  ),
);

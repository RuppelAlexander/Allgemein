<?php

$viewdefs ['ProjectTask'] = array(
    'QuickCreate' =>
    array(
        'templateMeta' =>
        array(
            'maxColumns' => '2',
            'widths' =>
            array(
                0 =>
                array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 =>
                array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'includes' =>
            array(
                0 =>
                array(
                    'file' => 'modules/ProjectTask/ProjectTask.js',
                ),
            ),
            'form' =>
            array(
                'buttons' =>
                array(
                    0 =>
                    array(
                        'customCode' => '{if $FROM_GRID}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'Save\'; this.form.return_module.value=\'Project\'; this.form.return_action.value=\'EditGridView\'; this.form.return_id.value=\'{$project_id}\'; return check_form(\'EditView\');"	type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}"/>{else}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'Save\'; return check_form(\'EditView\');" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}&nbsp;',
                    ),
                    1 =>
                    array(
                        'customCode' => '{if $FROM_GRID}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="SUGAR.grid.closeTaskDetails()"; type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{else}{if !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($fields.id.value))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'DetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{elseif !empty($smarty.request.return_action) && ($smarty.request.return_action == "DetailView" && !empty($smarty.request.return_id))}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'DetailView\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{else}<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'index\'; this.form.module.value=\'{$smarty.request.return_module}\'; this.form.record.value=\'{$smarty.request.return_id}\';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">{/if}{/if}&nbsp;',
                    ),
                ),
            ),
        ),
        'panels' =>
        array(
            'default' =>
            array(
                0 =>
                array(
                    0 =>
                    array(
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ),
                ),
                1 =>
                array(
                    0 =>
                    array(
                        'name' => 'date_start',
                        //'type' => 'readonly',
                        'validation' => array('type' => 'isbefore', 'compareto' => 'date_finish', 'blank' => true),
                    ),
                    1 =>
                    array(
                        'name' => 'date_finish',
                        //'type' => 'readonly',
                        'validation' => array('type' => 'isafter', 'compareto' => 'date_start', 'blank' => true),
                    ),
                ),
      
                2 =>
                array(
                    0 =>
                    array(
                        'name' => 'status',
                        'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
                    ),
                    1 => 'priority',
                ),
                3 =>
                array(
                    0 => 'task_number',
                    1 => 'order_number',
                ),
                4 =>
                array(
                    0 => 'estimated_effort',
                    1 => 'utilization',
                ),
                5 =>
                array(
                    0 =>
                    array(
                        'name' => 'description',
                    ),
                    1 =>
                    array(
                        'name' => 'team_name',
                        'type' => 'readonly',
                        'label' => 'LBL_TEAM',
                    ),
                ),
            ),
        ),
    ),
);
?>

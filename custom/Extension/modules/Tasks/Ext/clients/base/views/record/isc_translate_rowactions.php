<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (Alle Rechte vorbehalten.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : Ruppel A.
 * Create Date   : 07 Jul 2025
 * Change Date   : 15 Jul 2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : Fügt sechs Übersetzungs-RowActions ins Aufgaben-Modul ein
 * ----------------------------------------------------------------------------
 */

/*
  * custom/Extension/modules/Tasks/Ext/clients/base/views/record/isc_translate_rowactions.php
 */

$buttons = isset($viewdefs['Tasks']['base']['view']['record']['buttons'])
    ? $viewdefs['Tasks']['base']['view']['record']['buttons']
    : [];

if (!empty($buttons)) {
    foreach ($buttons as $key => $button) {
        if ($button['type'] === 'actiondropdown' && $button['name'] === 'main_dropdown') {

            /* ───────────── Divider ───────────── */
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type' => 'divider',
            ];
            

            /* ───────────── EN ↔ DE ───────────── */
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'  => 'isc_translate_en2de-rowaction',
                'name'  => 'isc_translate_en2de_rowaction_button',
                'label' => 'LBL_ISC_TRANSLATE_EN2DE',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_translate_en2de-rowaction:click',
            ];
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'  => 'isc_translate_de2en-rowaction',
                'name'  => 'isc_translate_de2en_rowaction_button',
                'label' => 'LBL_ISC_TRANSLATE_DE2EN',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_translate_de2en-rowaction:click',
            ];

            /* ───────────── DE ↔ FR ───────────── */
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'  => 'isc_translate_de2fr-rowaction',
                'name'  => 'isc_translate_de2fr_rowaction_button',
                'label' => 'LBL_ISC_TRANSLATE_DE2FR',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_translate_de2fr-rowaction:click',
            ];
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'  => 'isc_translate_fr2de-rowaction',
                'name'  => 'isc_translate_fr2de_rowaction_button',
                'label' => 'LBL_ISC_TRANSLATE_FR2DE',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_translate_fr2de-rowaction:click',
            ];

            /* ───────────── DE ↔ ES ───────────── */
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'  => 'isc_translate_de2sp-rowaction',
                'name'  => 'isc_translate_de2sp_rowaction_button',
                'label' => 'LBL_ISC_TRANSLATE_DE2ES',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_translate_de2sp-rowaction:click',
            ];
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'  => 'isc_translate_sp2de-rowaction',
                'name'  => 'isc_translate_sp2de_rowaction_button',
                'label' => 'LBL_ISC_TRANSLATE_ES2DE',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_translate_sp2de-rowaction:click',
            ];
            /* ───────────── Divider ───────────── */
            $viewdefs['Tasks']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type' => 'divider',
            ];


            break;
        }
    }
}

<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (Alle Rechte vorbehalten.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : Ruppel A.
 * Create Date   : 13 Aug 2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : RowAction "PDF → DE (DeepL)" im Notes-Action-Dropdown
 * ----------------------------------------------------------------------------
 */

$buttons = isset($viewdefs['Notes']['base']['view']['record']['buttons'])
    ? $viewdefs['Notes']['base']['view']['record']['buttons']
    : [];

if (!empty($buttons)) {
    foreach ($buttons as $key => $button) {
        if ($button['type'] === 'actiondropdown' && $button['name'] === 'main_dropdown') {

            /* ───────────── Divider ───────────── */
            $viewdefs['Notes']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type' => 'divider',
            ];

            // Typ-Name = Ordnername unter /fields/
            $viewdefs['Notes']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type'       => 'isc_pdf2de-rowaction',
                'name'       => 'isc_pdf2de_rowaction_button',
                'label'      => 'LBL_ISC_PDF2DE_BTN',
                'acl_action' => 'view',
                'showOn'     => 'view',
                'event'      => 'button:isc_pdf2de-rowaction:click',
            ];

            /* ───────────── Divider ───────────── */
            $viewdefs['Notes']['base']['view']['record']['buttons'][$key]['buttons'][] = [
                'type' => 'divider',
            ];

            break;
        }
    }
}

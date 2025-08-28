<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 15.08.2025
 * Change Date   : 15.08.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : sugarfield_uebersetzungs_anhang_c.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


// Sichtbares Relate-Feld (non-db)
$dictionary['Note']['fields']['uebersetzungs_anhang_c'] = [
    'name' => 'uebersetzungs_anhang_c',
    'vname' => 'LBL_UEBERSETZUNGS_ANHANG',
    'type' => 'relate',
    'source' => 'non-db',
    'module' => 'Documents',
    'rname' => 'document_name', 
    'id_name' => 'uebersetzungs_anhang_id_c',
    'save' => true,
    'link' => false,
    'studio' => 'visible',
    'massupdate' => true,
    'audited' => false,
    'required' => false,
    'reportable' => true,
];

// GUID-Spalte (DB)
$dictionary['Note']['fields']['uebersetzungs_anhang_id_c'] = [
    'name' => 'uebersetzungs_anhang_id_c',
    'vname' => 'LBL_UEBERSETZUNGS_ANHANG_ID',
    'type' => 'id',
    'reportable' => false,
    'massupdate' => false,
    'audited' => false,
    'studio' => false,
    'duplicate_merge' => 'disabled',
];


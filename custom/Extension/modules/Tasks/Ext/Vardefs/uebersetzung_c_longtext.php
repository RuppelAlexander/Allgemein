<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 21.07.2025
 * Change Date   : 21.07.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : uebersetzung_c_longtext.php
 * ----------------------------------------------------------------------------
 */

// Nur ausführen, wenn das Task-Dictionary und das Feld bereits existieren:
if (isset($dictionary['Task']['fields']['uebersetzung_c'])
    && is_array($dictionary['Task']['fields']['uebersetzung_c'])
) {
    $dictionary['Task']['fields']['uebersetzung_c'] = array_merge(
        $dictionary['Task']['fields']['uebersetzung_c'],
        [
            'type'   => 'text',
            'dbType' => 'longtext',
            // maximaler MySQL LONGTEXT–Wert
            'len'    => 4294967295,
        ]
    );
}

<?php
$dictionary['Task']['fields']['uebersetzung_c'] = [
    'name' => 'uebersetzung_c',
    'vname' => 'LBL_UEBERSETZUNG',
    'type' => 'text',
    'dbType' => 'longtext',
    'rows' => 8,
    'cols' => 80,
    'audited' => false,
    'massupdate' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'merge_filter' => 'disabled',
    'unified_search' => false,
    'full_text_search' => [
        'enabled' => true,
        'searchable' => true,
        'boost' => 1.0,
    ],
    'studio' => 'visible',
    'required' => false,
    'readonly' => false,
];

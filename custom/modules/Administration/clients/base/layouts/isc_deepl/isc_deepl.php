<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.07.2025
 * Change Date   : 11.07.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : isc_deepl.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
//custom/modules/Administration/clients/base/layouts/isc_deepl/isc_deepl.php


$viewdefs['Administration']['base']['layout']['isc_deepl'] = [
    'components' => [
        [
            'layout' => [
                'type' => 'base',
                'css_class' => 'row-fluid',
                'components' => [
                    [
                        'layout' => [
                            'type' => 'simple',
                            'name' => 'main-pane',
                            'css_class' => 'main-pane span12',
                            'components' => [
                                ['view' => 'isc_deepl', 'primary' => true],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

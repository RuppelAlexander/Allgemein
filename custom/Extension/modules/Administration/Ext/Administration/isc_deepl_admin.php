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
 * Description   : isc_deepl_adminpanel.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
//custom/Extension/modules/Administration/Ext/Administration/isc_deepl_admin.php
$admin_option_defs = array();

$admin_option_defs['Administration']['ISC_DEEPL_CFG'] = array(
    'detailview',
    'LBL_ISC_DEEPL_TITLE',
    'LBL_ISC_DEEPL_DESC',
    'javascript:void(parent.SUGAR.App.router.navigate("#Administration/layout/isc_deepl",{trigger:true}));',
);

$admin_group_header[] = array(
    'LBL_ISC_DEEPL_SECTION', '', false, $admin_option_defs, 'LBL_ISC_DEEPL_SECTION_DESC'
);




<?php


$admin_option_defs = array();
$admin_option_defs['Administration']['lensware_kundennummer_button'] = array(
    'Administration',
    'LBL_LENSWARE_KUNDENNUMMER_TITLE',
    'LBL_LENSWARE_KUNDENNUMMER_DESCRIPTION',
    'javascript:parent.SUGAR.App.router.navigate("#Administration/lensware_kundennummer", {trigger: true});'
);
$admin_group_header[] = array(
    'LBL_LENSWARE_KUNDENNUMMER_SECTION_HEADER',
    '',
    false,
    $admin_option_defs,
    'LBL_LENSWARE_KUNDENNUMMER_SECTION_DESCRIPTION'
);

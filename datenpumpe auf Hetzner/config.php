<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 23.05.2023
 * Change Date   : 23.05.2023
 * Main Program  : datenpumpe
 * Description   : config.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */




require_once 'modules/Configurator/Configurator.php';

$x = 0;
$configuratorObj = new Configurator();
$configuratorObj->loadConfig();

if (empty($configuratorObj->config['leica_url'] ?? '')) {
    $configuratorObj->config['leica_url'] = 'https://leicasandbox.sugaropencloud.eu/';
    $x++;
}
if (empty($configuratorObj->config['leica_username'] ?? '')) {
    $configuratorObj->config['leica_username'] = 'admin';
    $x++;
}
if (empty($configuratorObj->config['leica_password'] ?? '')) {
    $configuratorObj->config['leica_password'] = 'rnP9AKZZ^eQgjp6';
    $x++;
}

if (empty($configuratorObj->config['leica_key_path'] ?? '')) {
    $configuratorObj->config['leica_key_path'] = 'Key/isc_leica_sftp_eddsa_priv';
    $x++;
}
if (empty($configuratorObj->config['sftpHost'] ?? '')) {
    $configuratorObj->config['sftpHost'] = 'ftp0.leica-camera.com';
    $x++;
}
if (empty($configuratorObj->config['sftpPort'] ?? '')) {
    $configuratorObj->config['sftpPort'] = 2222;
    $x++;
}
if (empty($configuratorObj->config['sftpUsername'] ?? '')) {
    $configuratorObj->config['sftpUsername'] = 'lecsugar';
    $x++;
}
if (empty($configuratorObj->config['sftpPassword'] ?? '')) {
    $configuratorObj->config['sftpPassword'] = '76834EMXK9642BVof6AN';
    $x++;
}
if (empty($configuratorObj->config['privateKeyPath'] ?? '')) {
    $configuratorObj->config['privateKeyPath'] = 'Key/isc_leica_sftp_eddsa_priv';
    $x++;
}
if (empty($configuratorObj->config['keyPassword'] ?? '')) {
    $configuratorObj->config['keyPassword'] = '76834EMXK9642BVof6AN';
    $x++;
}

if ($x > 0) {
    echo "Leica Configuration Updated!" . PHP_EOL;
    $configuratorObj->saveConfig();
}

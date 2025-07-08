<?php
$config_override = [];
$config_override['document_merge']['service_urls']['default'] = 'https://document-merge-eu-central-1-prod.service.sugarcrm.com';
$config_override['moduleInstaller']['packageScan'] = true;
$config_override['developerMode'] = false;
$config_override['verify_client_ip'] = false;
$config_override['logger']['level'] = 'deprecated';
$config_override['logger']['file']['maxSize'] = '10MB';

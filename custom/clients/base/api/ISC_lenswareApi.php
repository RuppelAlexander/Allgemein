<?php

/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 05.09.2023
 * Change Date   : 05.09.2023
 * Main Program  : lensware-kundennummer-drawer-metadata.php
 * Description   : ISC_lenswareApi.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
class ISC_lenswareApi extends SugarApi
{

    public function registerApiRest()
    {
        return [
            'isc_lenswaresettings_save' => [
                'reqType' => 'POST',
                'path' => ['isc_lenswaresettings', 'save'],
                'pathVars' => ['', ''],
                'method' => 'Save_lensSettings',
                'shortHelp' => 'This Save Settings',
                'longHelp' => '',

            ],
            'isc_lenswaresettings_load' => [
                'reqType' => 'POST',
                'path' => ['isc_lenswaresettings', 'load'],
                'pathVars' => ['', ''],
                'method' => 'load_lensSettings',
                'shortHelp' => 'This Save Settings',
                'longHelp' => 'custom/clients/base/api/help/isc_lensware_Read_help.html',

            ],
            'isc_lenswaresettings_check' => [
                'reqType' => 'POST',
                'path' => ['isc_lenswaresettings', 'check'],
                'pathVars' => ['', ''],
                'method' => 'check_lenswareKundennummer',
                'shortHelp' => 'This checks if a Kundennummer exists',
                'longHelp' => '',
            ],
        ];
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return void
     */


    public function Save_lensSettings(ServiceBase $api, array $args)
    {
        $value = $args['lensware_kundennummer_value'] ?? "";

        $administrationObj = new Administration();
        $administrationObj->saveSetting("LenswareKundenNummerSettings", "KundenNummerValue", $value);

        return ['success' => true];
    }


    public function load_lensSettings(ServiceBase $api, array $args)
    {
        $administrationObj = new Administration();
        $settings = $administrationObj->retrieveSettings('LenswareKundenNummerSettings');
        $lensware_kundennummer = $settings->settings['LenswareKundenNummerSettings_KundenNummerValue'] ?? "";

        return ['success' => true, 'lensware_kundennummer' => $lensware_kundennummer];
    }
    public function check_lenswareKundennummer(ServiceBase $api, array $args)
    {
        $value = $args['lensware_kundennummer_value'] ?? "";

        $query = new SugarQuery();
        $query->from(BeanFactory::getBean('Accounts'));
        $query->where()->equals('kundennummer_c', $value);
        $results = $query->execute();

        return ['exists' => !empty($results)];
    }
    

}
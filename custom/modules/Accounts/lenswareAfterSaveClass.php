<?php

/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 06.09.2023
 * Change Date   : 06.09.2023
 * Main Program  : lensware-kundennummer-drawer-metadata.php
 * Description   : lenswareAfterSaveClass.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


use Sugarcrm\Sugarcrm\custom\modules\Accounts\lensware_check_kundennummer_class;

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class lenswareAfterSaveClass {

    function lenswareAfterSaveMethod($bean, $event, $arguments) {

        global $newNum;
        if (empty($bean->kundennummer_c)) {
            $administrationObj = new Administration();
            if (!$administrationObj) {
                $GLOBALS['log']->fatal("Fehler beim Erstellen des Administration-Objekts");
                return;
            }
            $settings = $administrationObj->retrieveSettings('LenswareKundenNummerSettings');
            if (!$settings) {
                $GLOBALS['log']->fatal("Fehler beim Abrufen der Einstellungen");
                return;
            }
            $newNum = $settings->settings['LenswareKundenNummerSettings_KundenNummerValue'] ?? 0;

            $query = new SugarQuery();
            if (!$query) {
                $GLOBALS['log']->fatal("Fehler beim Erstellen des SugarQuery-Objekts");
                return;
            }
            $query->from(BeanFactory::getBean('Accounts'),['team_security'=>false]);
            $query->where()->equals('kundennummer_c', $newNum);
            $results = $query->execute();

            if (!empty($results)) {

                $bean->duplicate_kundennummer = true;


                if (class_exists('Sugarcrm\Sugarcrm\custom\modules\Accounts\lensware_check_kundennummer_class')) {
                    try {
                        Sugarcrm\Sugarcrm\custom\modules\Accounts\lensware_check_kundennummer_class::check_kundennummer_method($bean, $event, $arguments);

                    } catch (\Exception $e) {
                        $GLOBALS['log']->fatal("Fehler beim Ausführen des zweiten Logic Hooks: " . $e->getMessage());
                    }
                } else {
                    $GLOBALS['log']->warn("Die Methode 'check_kundennummer_method' wurde nicht gefunden oder die Klasse 'lensware_check_kundennummer_class' existiert nicht.");
                }

            } else {
                $bean->kundennummer_c = $newNum;
                if (!$bean->save()) {
                    $GLOBALS['log']->fatal("Fehler beim Speichern des Beans");
                    return;
                }
                if (!$administrationObj->saveSetting("LenswareKundenNummerSettings", "KundenNummerValue", ++$newNum)) {
                    $GLOBALS['log']->fatal("Fehler beim Speichern der Einstellungen");
                    return;
                }
            }
        }
    }
}


/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.06.2025
 * Change Date   : 11.06.2025
 * Main Program  : Intern_upgrade_test_dev
 * Description   : isc_resource_sync.js
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


(function () {

    // Diese Funktion legt einen Delegations-Handler an
    function attachGlobalListener () {
        document.addEventListener('click', function (ev) {

            // Button kann <input> ODER <a> sein; Hauptsache ID passt
            if (ev.target.id !== 'projecttask_users_1_select_button') {
                return;          // fremder Klick → ignorieren
            }

            ev.preventDefault(); // ursprünglichen open_popup NICHT sofort ausführen

            var originalJS = ev.target.getAttribute('onclick');
            // fallback, falls das Attribute nicht mehr existiert (manche Browser)
            if (!originalJS && ev.target.onclick) {
                originalJS = ev.target.onclick.toString()
                    .match(/open_popup[^"]+/); // Funktionsrumpf extrahieren
                originalJS = originalJS ? originalJS[0] : '';
            }

            var txt = 'Der ausgewählte Mitarbeiter ist noch keine ' +
                'Ressource des Projekts.\nJetzt hinzufügen?';

            if (confirm(txt)) {
                // „Ja“ → ursprünglichen open_popup-Code ausführen
                // Achtung: open_popup ist global im IFrame vorhanden
                eval(originalJS);
            }
            // „Nein“ → gar nichts tun
        });
    }

    // BWC-IFrame: jQuery/YUI steht immer zur Verfügung
    if (window.YAHOO && YAHOO.util && YAHOO.util.Event) {
        YAHOO.util.Event.onDOMReady(attachGlobalListener);
    } else {
        // Fallback (sollte nie passieren, aber sicher ist sicher)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', attachGlobalListener);
        } else {
            attachGlobalListener();
        }
    }

})();

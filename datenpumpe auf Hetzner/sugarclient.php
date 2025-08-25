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
 * Description   : sugarclient.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

use Monolog\Logger;

class sugarclient
{
    var $access_token = '';
    var $SugarRestUrl = 'https://leicasandbox.sugaropencloud.eu/rest/v10/';
    var $isAuth = false;
    var $LoginData = '';
    var $oauth_token = '';
    var $LastError = '';
    var $Log = null;

    /**
     * @param string $SugarRestUrl
     * @param string $username
     * @param string $password
     * @param Logger $log
     * @param string $platform
     *
     */
    function __construct($SugarRestUrl, $username, $password, $log, $platform = 'datenpumpe')
    {
        $this->Log = $log;
        $this->SugarRestUrl = $SugarRestUrl;

        $this->LoginData = array(
            "grant_type" => "password",
            "client_id" => "sugar",
            "client_secret" => "",
            "username" => $username,
            "password" => $password,
            "platform" => $platform
        );
    }

    /**
     * /**
     * Neuen Account Erstellen
     * @param string $acName Name des Zu erstellenden Accounts
     * @return array  Array mit den Accountdaten
     */

    public function createAccount($accountData)
    {
        $path = "Accounts";
        $erg = $this->callSugarRest('POST', $path, $accountData);
        return json_decode($erg, true);
    }

    //Kontakt erstellen
    public function createContact($accountData)
    {
        $path = "Contacts";
        $erg = $this->callSugarRest('POST', $path, $accountData);
        return json_decode($erg, true);
    }

    /**
     * Ruft eine Liste von Einträgen aus SugarCRM ab
     *
     * @param string $module
     * @param string $query
     * @param int $offset
     * @param string $orderBy
     * @param array $selectFields
     * @param int $maxResults
     * @return array|bool
     */


    /**
     * Überprüft, ob ein Kontakt mit einem bestimmten Vor- und Nachnamen bereits in SugarCRM vorhanden ist
     *
     * @param sugarclient $Client
     * @param string $firstName
     * @param string $lastName
     * @return array
     */
     public function getContactByName($Client, $firstName, $lastName,$accountId)
    {
        $parameters = [
            'filter' => [
                [
                    'first_name' => [
                        '$equals' => $firstName,
                    ],
                    'last_name' => [
                        '$equals' => $lastName,
                    ],
                    'account_id' =>[
                        '$in' =>  [$accountId],
                    ] ,
                ],
            ],
            'fields' => 'id',
        ];
        $path = "Contacts/filter";
        $result = $Client->callSugarRest('POST',  $path, $parameters);
        $data= json_decode($result, true);

        if (isset($data['records'])) {
            return $data['records']  ;
        } else {
            return [];
        }
    }


    public function getEntryList($module, $query, $offset = 0, $orderBy = '', $selectFields = [], $maxResults = 20)
    {
        $parameters = [
            'module_name' => $module,
            'query' => $query,
            'order_by' => $orderBy,
            'offset' => $offset,
            'select_fields' => $selectFields,
            'max_results' => $maxResults,
        ];

        $path = "Contacts/filter";
        $result = $this->callSugarRest('GET', $path, $parameters);
        return json_decode($result, true);
    }

    /**
     * Aktualisiert einen Kontakt in SugarCRM
     *
     * @param string $contactId
     * @param array $contactData
     * @return array|bool
     */
    public function updateContact($contactId, $contactData)
    {
        $path = "Contacts/{$contactId}";
        $result = $this->callSugarRest('PUT', $path, $contactData);
        return json_decode($result, true);
    }

    /**
     * Fügt einen Kontakt einem Account hinzu
     *
     * @param string $accountId
     * @param string $contactId
     * @return array|bool
     */
    public function linkContactToAccount($accountId, $contactId)
    {
        $path = "Accounts/$accountId/link";
        $linkData = [
            'link_name' => 'contacts',
            'ids' => [$contactId],
        ];
        $result = $this->callSugarRest('POST', $path, $linkData);
        return json_decode($result, true);
    }


    //Daten werden upgedated
    public function updateAccount($accountId, $accountData)
    {
        $path = "Accounts/$accountId";
        $erg = $this->callSugarRest('PUT', $path, $accountData);
        return json_decode($erg, true);
    }

    //Email zu Firmen hinzufügen
    public function createEmail($emailData)
    {
        $path = "EmailAddresses";
        $erg = $this->callSugarRest('POST', $path, $emailData);
        return json_decode($erg, true);
    }

    public function linkEmailToAccount($accountId, $emailId)
    {
        $path = "Accounts/$accountId/link";
        $linkData = [
            'link_name' => 'email_addresses',
            'ids' => [$emailId],
        ];
        $erg = $this->callSugarRest('POST', $path, $linkData);
        return json_decode($erg, true);
    }


    //KundenNummer von sugar crm vergleichen
    public function GetAccounts($custNumb,)
    {
        $path = "Accounts/filter";

        $parameter = array(
            "filter" => array(
                array(
                    "kundennummer_c" => ['$equals' => $custNumb],

                ),
            ),
            "max_num" => 1,
            "fields" => "id,name,email",
        );


        $erg = $this->callSugarRest('POST', $path, $parameter);

        return json_decode($erg, true);
    }

    /**
     * Sugar Login mit Configurierten User und Passwort
     * @return bool
     */
    public function login()
    {
        $erg = $this->callSugarRest('POST', "oauth2/token", $this->LoginData);
        if ($erg === false) {
            $this->Log->emergency("Die oauth2/token Anfrage an die SugarCRM-API ist fehlgeschlagen");
            // Fehlerbehandlung, wenn die Anfrage fehlschlägt
            echo "Fehler: Die Anfrage an die SugarCRM-API ist fehlgeschlagen.\n";
            return false;
        }
        $oauth2_token_response_obj = json_decode($erg, true);
        if ($oauth2_token_response_obj === null) {
            // Fehlerbehandlung, wenn die Antwort nicht im erwarteten Format ist
            $this->Log->emergency("Die oauth2/token Antwort von SugarCRM-API konnte nicht verarbeitet werden");
            echo "Fehler: Die Antwort von der SugarCRM-API konnte nicht verarbeitet werden.\n";
            return false;
        }
        if (!isset($oauth2_token_response_obj['access_token'])) {
            // Fehlerbehandlung, wenn das Zugriffstoken nicht in der Antwort enthalten ist
            $this->Log->emergency("Die oauth2/token Zugriffstoken wurde nicht in der Antwort von der SugarCRM-API gefunden");
            echo "Fehler: Das Zugriffstoken wurde nicht in der Antwort von der SugarCRM-API gefunden.\n";
            return false;
        }
        $this->oauth_token = $oauth2_token_response_obj['access_token'];
        $this->Log->debug("oauth2/token Zugriffstoken erhalten");
        $this->isAuth = True;
        return true;
    }


    private function callSugarRest($typ, $endpoint, $parameter)
    {
        $auth_request = curl_init($this->SugarRestUrl . $endpoint);
        curl_setopt($auth_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($auth_request, CURLOPT_HEADER, false);
        curl_setopt($auth_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($auth_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($auth_request, CURLOPT_FOLLOWLOCATION, 0);

        if (!empty($this->oauth_token)) {
            curl_setopt($auth_request, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "oauth-token: " . $this->oauth_token
            ));
        } else {
            curl_setopt($auth_request, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
        }

        //convert arguments to json
        if ($typ == 'POST' || $typ == 'PUT') {
            $json_arguments = json_encode($parameter);
            curl_setopt($auth_request, CURLOPT_POSTFIELDS, $json_arguments);
            curl_setopt($auth_request, CURLOPT_CUSTOMREQUEST, $typ);
        }

        //execute request
        $result = curl_exec($auth_request);
        if (curl_errno($auth_request)) {
            $error_msg = curl_error($auth_request);

            error_log($error_msg, 3, 'error.log');

        }
        try {
           $pres=json_decode($result,true);
            if (isset($pres['error']) && $pres['error']) {

                 $this->Log->error('Curl error ' ,['result'=>$pres,'endpoint' =>$endpoint,'parameter'=> $json_arguments]);
           }
        } catch (Exception $ex) {

        }

        $http_code = curl_getinfo($auth_request, CURLINFO_HTTP_CODE);

        // Überprüfen ob die Authentifizierung fehlgeschlagen ist
        if ($http_code == 401) {
            // Die Authentifizierung ist fehlgeschlagen
            echo "Authentifizierung fehlgeschlagen. Versuche erneut...\n";

            // Erneut anmelden
            $this->login();

            // Versuche erneut, die Anfrage auszuführen
            curl_setopt($auth_request, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "oauth-token: " . $this->oauth_token
            ));
            $result = curl_exec($auth_request);
            $http_code = curl_getinfo($auth_request, CURLINFO_HTTP_CODE);

            // Überprüfen  ob die erneute Anmeldung erfolgreich war
            if ($http_code == 200) {
                echo "Erneute Anmeldung erfolgreich.\n";
            } else {
                echo "Erneute Anmeldung fehlgeschlagen.\n";
            }
        }

        if ($http_code != 200 && $http_code != 201 && $http_code != 202 && $http_code != 204 && $http_code != 422)  {
            // Fehler
            exit("Die Anfrage ist fehlgeschlagen. Das Skript wird beendet.\n");
        }


        return $result;
    }
}


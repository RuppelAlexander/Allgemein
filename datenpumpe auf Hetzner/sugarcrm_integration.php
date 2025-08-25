<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 25.05.2023
 * Change Date   : 25.05.2023
 * Main Program  : datenpumpe
 * Description   : sugarcrm_integration.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

// Pfad zur Lock-Datei
$lock_file = '/tmp/my_script.lock';

// Überprüfe, ob die Lock-Datei existiert
if (file_exists($lock_file)) {

    exit("Skript läuft bereits, beende\n");
}

// Erstelle die Lock-Datei
file_put_contents($lock_file, getmypid());



require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;



// create a log channel
require_once 'dpLoghandler.php';

$log = dpLoghandler::CreateLogger('Datenpumpe', 'Run.log');

/*
DEBUG (100): Detailed debug information.
INFO (200): Interesting events. Examples: User logs in, SQL logs.
NOTICE (250): Normal but significant events.
WARNING (300): Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.
CRITICAL (500): Critical conditions. Example: Application component unavailable, unexpected exception.
ALERT (550): Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
EMERGENCY (600): Emergency: system is unusable.
*/

ini_set('max_input_time', 9000);         //verarbeitungszeit von empfangenen daten
set_time_limit(0);                            //Dauer des Scripts deakteviert

// Einbinden der anderen Skripte
require_once 'SFTP_Login.php';
require_once 'sugarclient.php';


$fieldMapping2 = [

    "ContFirst" => "first_name",
    "ContLast" => "last_name",
    "ContSalut" => "salutation",
    "ContTitle" => "title",
    "Street" => "primary_address_street",
    "ZipCode" => "primary_address_postalcode",
    "City" => "primary_address_city",
    "Country" => "primary_address_country",
    "District" => "primary_address_state",

];
$fieldMapping = [
    "CustNumb" => "kundennummer_c",
    "Name1" => "name",
    "NameSh1" => "",    //fehlt
    "Street" => "billing_address_street",
    "ZipCode" => "billing_address_postalcode",
    "City" => "billing_address_city",
    "Country" => "billing_address_country",
    "District" => "billing_address_state",
    "Region" => "billing_address_reg_c",
    "Language" => "lang_code_c",
    "EDIActive" => "ediactive_c",
    "Password1" => "edipasswd_c",
    "Currency" => "",   //fehlt
    "Partner" => "",    //fehlt
    "Branch" => "",     //fehlt
    "CustType" => "cst_code_c",
    "MainGroup" => "kd_code_c",
    "AddressOnly" => "custom_only_adress_c",
    "POBox" => "po_box_c",
    "Phone" => "phone_office",
    "Fax" => "phone_fax",
    "Mail" => "email",
    "CellPhone" => "phone_mobile",
    "Name2" => "name_second_c",
    "NameSh2" => "",   //fehlt
    "Alias1" => "alias1_c",
    "Alias2" => "alias2_c",
    "SalesArea1" => "sales_agent_c",
    "SalesArea2" => "sales_area_c",
    "Carrier" => "carrier_code_c",
    "Dispatch" => "tour_c",
    "ShipCost" => "shipping_cost_c",
    "CustRef1" => "billing_adress_custnumb_c",
    "CustRef2" => "invoice_adress_custnumb_c",
    "TaxNumb" => "tax_numb_c",
    "EuVatId" => "eu_identnumber_c",
    "Insurance" => "",   //fehlt
    "Contribut" => "",    //fehlt
    "InvType" => "billing_type_c",
    "PaymTerm" => "payment_terms_c",
    "PaymDays" => "payment_days_c",
    "CashDiscType" => "discount_given_c",
    "CashDiscRate" => "discount_rate_c",
    "CashDiscDay" => "days_discount_rate_c",
    "LangDelv" => "langDelv_c",
    "LangInv" => "langInv_c",
    "DelvNoPrint" => "",  //fehlt
    "DelvPrice" => "delv_price_c",
    "LayoutDelnote" => "",   //fehlt
    "LayoutEnvelope" => "",   //fehlt
    "LayoutWarranty" => "",   //fehlt
    "BagNoEnv" => "",      //fehlt
    "CardNoWarr" => "",   //fehlt
    "PrePayment" => "prepayment_c",
    "SpecialInsp" => "specialInsp_c",
    "CustInfo" => "website",
    "PriceFromGroup" => "priceFromGroup_c",
    "DiscFromGroup" => "discFromGroup_c",
    "InvNoPrint" => "invNoPrint_c",
    "PrintCard" => "printwarrant_card_c",
    "JTNoPrint" => "",   //fehlt
    "PrintSpec" => "",   //fehlt
    "MailInv" => "send_invoice_mail_c",
    "MailInvAddr" => "mail_address_invoice_c",
    "MailDelv" => "mailDelv_c",
    "MailDelvAddr" => "mailDelvAddr_c",
    "MailConf" => "mailConf_c",
    "DelvPrSide" => "delvPrSide_c",
    "Delvexport" => "",   //fehlt
    "DelvFormat" => "",    //fehlt
    "Priority" => "priority_c",
    "Migrate" => "migrate_c",
    "InvAccount" => "invAccount_c",
    "Paymenttype" => "paymenttype_c",
    "Iban" => "iban_c",
    "Bic" => "bic_c",
    "CatABC1" => "kundenklasse_c",
    "Flag1" => "flag_1_c",
    "Flag2" => "flag_2_c",
    "Flag3" => "flag_3_c",
    "Flag4" => "flag_4_c",
    "Flag5" => "flag_5_c",
    "CatABC2" => "kundenklasse2_c"
];
$log->debug("Verbindung zum SFTP-Server herstellen...");

// Verbindung zum SFTP-Server herstellen und Dateien herunterladen
$sftpLogin = new SFTP_Login($log);
$sftpLogin->login();

$log->debug("Dateien heruntergeladen");

// Verzeichnis mit heruntergeladenen Dateien
$dir = '/home/iscuser/workfolder/';                         //geändert

/*// Skript beenden
exit;*/

$log->debug("Verbindung zu SugarCRM herstellen");
// Verbindung zu SugarCRM herstellen
$Client = new sugarclient('https://leicasandbox.sugaropencloud.eu/rest/v10/', 'admin', 'rnP9AKZZ^eQgjp6', $log, 'datenpumpe');
if (!$Client->login()) {
    echo 'Fehler:' . PHP_EOL;
    echo $Client->LastError;
    die();
}
$log->debug("Verbunden mit SugarCRM.\n");

//-----------------------------------------------------------------------------------------------------------
echo "Dateien auslesen und formatieren...\n";
// Dateien auslesen 
$files = scandir($dir);
if (empty($files)) {
    echo "Keine Dateien gefunden.\n";
}



// Überprüfen, ob die Datei im lokalen Verzeichnis existiert
foreach ($files as $file) {
    if ($file == '.' || $file == '..') {
        continue;
    }
    if (file_exists($dir . '/' . $file)) {

        echo "Verarbeite Datei: $file...\n";
        $file = fopen($dir . '/' . $file, 'r');
        // Lesen der ersten Zeile (Header)
        $header = fgetcsv($file, 0, ";");

        // Verarbeiten der restlichen Zeilen
        $HeadCount = count($header);

        while (($data = fgetcsv($file, 0, ";")) !== FALSE) {

            // Überprüfen Sie, ob die Zeile eine Header-Zeile ist
            if ($data === $header) {
                // Die Zeile ist eine Header-Zeile, überspringen Sie sie
                continue;
            }
            if (count($data) != $HeadCount) {
                $log->error('Da Passt was im CSV nicht', ['Col Count' => count($data)]);
            //    continue;
            }
            // Fehlende Werte mit einem Standardwert füllen
            $data = array_pad($data, count($header), '');
            $row = array_combine($header, $data);
            if (is_numeric($row['CustNumb']) == false) {              // hier kann noch versucher
                continue;
            };

                             
            // die Daten formatieren und an SugarCRM senden
            $accountData = [];
            $contactData = [];
            $firmenname = $row['Name1'];
            $emailAddress = '';
            foreach ($header as $field) {
                if (isset($fieldMapping[$field])) {
                    $OldValue = $row[$field];
                    $FieldEncoding = mb_detect_encoding($OldValue, ['ASCII','ISO-8859-1','Windows-1252','UTF-8']);  // was für ein Encoding hat der Text
                    if (!in_array($FieldEncoding, ['UTF-8'])) {
                        $OldValue = mb_convert_encoding($OldValue, 'UTF-8', $FieldEncoding); // was nicht past wird passend gemacht!
                    }
                    if ($field == 'Mail') {
                        // Speichern Sie die E-Mail-Adresse in einer separaten Variable
                        $emailAddress = $OldValue;
                    } else {
                        $accountData[$fieldMapping[$field]] = $OldValue;
                    }
                }

                if (isset($fieldMapping2[$field])) {
                    $OldValue = $row[$field];
                    $FieldEncoding = mb_detect_encoding($OldValue, ['ASCII', 'UTF-8', 'ISO-8859-1', 'Windows-1252']);  // was für ein Encoding hat der Text
                    if (!in_array($FieldEncoding, ['UTF-8'])) {
                        $OldValue = mb_convert_encoding($OldValue, 'UTF-8', $FieldEncoding); // was nicht past wird passend gemacht!
                    }
                    $contactData[$fieldMapping2[$field]] = $OldValue;
                }
            }

// Überprüfen, ob der Wert des "CustNumb" Headers bereits in SugarCRM vorhanden ist
            
            $custNumb = $accountData['kundennummer_c'];
            if (empty($custNumb) || !is_numeric($custNumb)) {
                $log->error('Da  Passt ws nicht', ['accountData' => $accountData]);
            }
            $get_entry_list_result = $Client->GetAccounts($custNumb);
            if (isset($get_entry_list_result['records']) && count($get_entry_list_result['records']) > 0) {

                // Der Wert ist bereits vorhanden, aktualisieren Sie den Datensatz
                echo "Aktualisiere Datensatz mit CustNumb $custNumb.\n";
                $accountId = $get_entry_list_result['records'][0]['id'];
                $result = $Client->updateAccount($accountId, $accountData);
                $KD_FromSugar = $result['kundennummer_c'];
                if ($KD_FromSugar != $custNumb) {
                    $log->error('Datensatz Past nicht', ['csvrow' => $accountData, 'Sugar' => $result]);
                } else {
                    $log->debug('Datensatz Passt', ['csvrow' => $accountData, 'Sugar' => $result]);
                }


                UpdateAccountEmail($Client, $result, $emailAddress);

                            
                // Überprüfen, ob der Kontakt bereits vorhanden ist   ( Sofern überhaut name vorhanden)
                $contacts = $Client->getContactByName($Client, $contactData['first_name'], $contactData['last_name'], $accountId);
                if(count($contacts)>1) {
                    // mist Zu viele mit Gleichen Namen
                    $log->warning('Mehrere Kontakte mit gleichen Namen für Firma gefunden',['accountId'=>$accountId ,'ContactData'=> $contactData, 'contacts'=>$contacts ] )   ;

                }elseif(count($contacts)==1) {
                    // Der Kontakt ist bereits vorhanden, aktualisieren Sie den Datensatz
                    echo "Aktualisiere Kontakt mit Vorname {$contactData['first_name']} und Nachname {$contactData['last_name']}.\n";
                    $contactId = $contacts[0]['id'];
                    $result = $Client->updateContact($contactId, $contactData);
                } else {

                // Überprüfen  ob die erforderlichen Daten vorhanden sind
                    if (!empty($contactData['first_name']) && !empty($contactData['last_name'])) {
                        // Der Kontakt ist nicht vorhanden und die erforderlichen Daten sind vorhanden, erstellen Sie den Datensatz
                        echo "Erstelle neuen Kontakt mit Vorname {$contactData['first_name']} und Nachname {$contactData['last_name']}.\n";
                        $result = $Client->createContact($contactData);

                        if (isset($result['id'])) {
                            echo "Kontakt erstellt: {$result['id']}.\n";
                            // Verknüpfen Sie den Kontakt mit der Firma
                            $contactId = $result['id'];
                            $result = $Client->linkContactToAccount($accountId, $contactId);

                        } else {
                            echo "Fehler beim Erstellen des Kontakts.\n";
                        }
                    } else {
                        // Die erforderlichen Daten sind nicht vorhanden, überspringen Sie den Datensatz
                        echo "Überspringe Datensatz aufgrund fehlender Daten.\n";
                    }
                }


                // Überprüfen Sie, ob die E-Mail-Adresse bereits vorhanden ist
                $emailExists = false;
                if (isset($get_entry_list_result['records'][0]['email'])) {
                    foreach ($get_entry_list_result['records'][0]['email'] as $email) {
                        if ($email['email_address'] == $emailAddress) {
                            $emailExists = true;
                            break;
                        }
                    }
                }

                // Fügen Sie die E-Mail-Adresse zum Konto hinzu, wenn sie noch nicht vorhanden ist
                if (!$emailExists && !empty($emailAddress)) {
                    $emailData = [
                        'email_address' => $emailAddress,
                        'email_address_caps' => strtoupper($emailAddress),
                        'invalid_email' => 0,
                        'opt_out' => 0,
                    ];
                    $result = $Client->createEmail($emailData);
                    if (isset($result['id'])) {
                        $emailId = $result['id'];
                        echo "E-Mail erstellt: $emailId.\n";
                        $result = $Client->linkEmailToAccount($accountId, $emailId);
                        if ($result) {
                            echo "E-Mail-Adresse wurde erfolgreich mit dem Konto verknüpft.\n";
                        } else {
                            echo "Fehler beim Verknüpfen der E-Mail-Adresse mit dem Konto.\n";
                        }
                    } else {
                        echo "Fehler beim Erstellen der E-Mail-Adresse.\n";
                    }
                }
            } else {
                // Der Wert ist nicht vorhanden, erstellen Sie den Datensatz
                echo "Erstelle neuen Datensatz mit CustNumb $custNumb.\n";
                $result = $Client->createAccount($accountData);
                if (isset($result['id'])) {
                    $accountId = $result['id'];

                    // Fügen Sie die E-Mail-Adresse zum Konto hinzu
                    if (!empty($emailAddress)) {
                        $emailData = [
                            'email_address' => $emailAddress,
                            'email_address_caps' => strtoupper($emailAddress),
                            'invalid_email' => 0,
                            'opt_out' => 0,
                        ];
                        $result = $Client->createEmail($emailData);
                        if (isset($result['id'])) {
                            $emailId = $result['id'];
                            echo "E-Mail erstellt: $emailId.\n";
                            $result = $Client->linkEmailToAccount($accountId, $emailId);
                            if ($result) {
                                echo "E-Mail-Adresse wurde erfolgreich mit dem Konto verknüpft.\n";
                            } else {
                                echo "Fehler beim Verknüpfen der E-Mail-Adresse mit dem Konto.\n";
                            }
                        } else {
                            echo "Fehler beim Erstellen der E-Mail-Adresse.\n";
                        }
                    }

                    if (!empty($contactData['first_name']) || !empty($contactData['last_name'])) {
                        // Erstelle einen neuen Kontakt
                        $contactData['account_id'] = $accountId;
                        $result = $Client->createContact($contactData);
                        if (isset($result['id'])) {
                            echo "Kontakt erstellt: {$result['id']}.\n";
                            $contactId = $result['id'];
                            $result = $Client->linkContactToAccount($accountId, $contactId);
                        } else {
                            echo "Fehler beim Erstellen des Kontakts.\n";
                            $log->error("Fehler beim Erstellen des Kontakts.\n");
                        }
                    } else {
                        // Überspringe die Erstellung des Kontakts
                        
                        $log->debug("Überspringe die Erstellung des Kontakts aufgrund fehlender Daten.\n");
                    }

                }
            }

        }

        fclose($file);
    } else {
        echo "Datei nicht gefunden: $file...\n";
    }
    echo "Dateien verarbeitet.\n";
}

/**
 * @param sugarclient $Client
 * @param array $get_entry_list_result
 * @param string $emailaddresse
 * @return void
 */
function UpdateAccountEmail($Client, $result, $emailAddress)
{

    // Überprüfen Sie, ob die E-Mail-Adresse bereits vorhanden ist
    $emailExists = false;
    $accountId = $result['id'];
    if (isset($result['email'])) {
        foreach ($result['email'] as $email) {
            if ($email['email_address'] == $emailAddress) {
                $emailExists = true;
                break;
            }
        }
    }

    // Fügen Sie die E-Mail-Adresse zum Konto hinzu, wenn sie noch nicht vorhanden ist
    if (!$emailExists && !empty($emailAddress)) {
        $emailData = [
            'email_address' => $emailAddress,
            'email_address_caps' => strtoupper($emailAddress),
            'invalid_email' => 0,
            'opt_out' => 0,
        ];
        $result = $Client->createEmail($emailData);
        if (isset($result['id'])) {
            $emailId = $result['id'];
            echo "E-Mail erstellt: $emailId.\n";
            $result = $Client->linkEmailToAccount($accountId, $emailId);
            if ($result) {
                echo "E-Mail-Adresse wurde erfolgreich mit dem Konto verknüpft.\n";
            } else {
                echo "Fehler beim Verknüpfen der E-Mail-Adresse mit dem Konto.\n";
            }
        } else {
            echo "Fehler beim Erstellen der E-Mail-Adresse.\n";
        }
    }

}


// Entferne die Lock-Datei
unlink($lock_file);



// Definiere das Zielverzeichnis
$destination_directory = '/home/iscuser/BAK/';

// Überprüfe, ob das Zielverzeichnis existiert
if (!is_dir($destination_directory)) {
    // Das Zielverzeichnis existiert nicht, erstelle es
    mkdir($destination_directory, 0777, true);
}

// Hole alle Dateien aus dem Quellverzeichnis
$files = glob($dir . '*');

// Verschiebe jede Datei in das Zielverzeichnis
foreach ($files as $file) {
    // Überprüfe, ob die Datei existiert
    if (is_file($file)) {
        // Verschiebe die Datei in das Zielverzeichnis
        rename($file, $destination_directory . basename($file));
    }
}






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
 * Description   : SFTP_Login.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SFTP;
use Monolog\Logger;

class SFTP_Login
{
    // Eigenschaften
    private $sftpHost = 'ftp0.leica-camera.com';
    private $sftpPort = 2222;
    private $sftpUsername = 'lecsugar';
    private $sftpPassword = '76834EMXK9642BVof6AN';
    private $privateKeyPath = 'Key/isc_leica_sftp_eddsa_priv';
    private $Log = null;
    // Methoden

    /**
     * @param Logger $log
     */
    function __construct($log)
    {
        $this->Log = $log;
    }


    public function login()
    {

        // Privaten Schlüssel laden
        $keyPassword = '76834EMXK9642BVof6AN';
        $privateKey = PublicKeyLoader::load(file_get_contents($this->privateKeyPath), $keyPassword);

        // Verbindung zum SFTP-Server herstellen
        $sftp = new SFTP($this->sftpHost, $this->sftpPort);
        if (!$sftp->login($this->sftpUsername, $privateKey, $this->sftpPassword)) {
            $this->Log->emergency('Login Failed');
            exit('Login Failed');
        }
        $this->Log->debug('ftp Login success');
        // Verzeichnis auf dem SFTP-Server
        $remoteDir = '/lecsugar';

        // Liste der lokalen Dateien erstellen
        $localFiles = scandir('/home/iscuser/workfolder/');

        // Dateien auflisten
        $files = $sftp->nlist($remoteDir);

        // Neue Dateien herunterladen und in einem bestimmten Verzeichnis speichern

        /*
          foreach ($files as $file) {
              if ($file != '.' && $file != '..' && !in_array($file, $localFiles)) {
                  // Datei herunterladen
                  $data = $sftp->get($remoteDir . '/' . $file);
                  // Datei in einem bestimmten Verzeichnis speichern
                  $savePath = '/home/iscuser/workfolder/\\' . $file;
                  file_put_contents($savePath, $data);
                  $this->Log->info('file downloaded', $files);
              }
          }*/

        //Änderung des codes, weil in leicaverzeichniss ein ordner sich befindet  änderung 09.06.2023 12:50 Uhr
        /*   foreach ($files as $file) {
               if ($file != '.' && $file != '..' && !in_array($file, $localFiles) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'csv') {
                   // Überprüfen, ob es sich um eine Datei handelt
                   if ($sftp->is_file($remoteDir . '/' . $file)) {
                       // Datei herunterladen
                       $data = $sftp->get($remoteDir . '/' . $file);
                       // Datei in einem bestimmten Verzeichnis speichern
                       $savePath = '/home/iscuser/workfolder/' . $file;
                       file_put_contents($savePath, $data);
                       $this->Log->info('file downloaded', $files);

                       // Datei auf dem SFTP-Server in den BAK-Ordner verschieben
                       $sftp->rename($remoteDir . '/' . $file, $remoteDir . '/BAK/' . $file);
                   }
               }
           }*/

        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && !in_array($file, $localFiles) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'csv') {
                // Überprüfen, ob es sich um eine Datei handelt
                if ($sftp->is_file($remoteDir . '/' . $file)) {
                    // Datei herunterladen
                    $data = $sftp->get($remoteDir . '/' . $file);
                    // Datei in einem bestimmten Verzeichnis speichern
                    $savePath = '/home/iscuser/workfolder/' . $file;
                    file_put_contents($savePath, $data);
                    $this->Log->info('File ' . $file . ' downloaded successfully');

                    // Vorhandene Datei im BAK-Ordner löschen
                    if ($sftp->is_file($remoteDir . '/BAK/' . $file)) {
                        $sftp->delete($remoteDir . '/BAK/' . $file);
                    }

                    // Datei auf dem SFTP-Server in den BAK-Ordner verschieben
                    if ($sftp->rename($remoteDir . '/' . $file, $remoteDir . '/BAK/' . $file)) {
                        $this->Log->info('File ' . $file . ' moved to BAK folder successfully');
                    } else {
                        $this->Log->error('Failed to move file ' . $file . ' to BAK folder');
                    }

                } else {
                    $this->Log->error('Failed to download file ' . $file);
                }
            }
        }


    }
}


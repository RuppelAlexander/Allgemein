<?php

/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 06.06.2023
 * Change Date   : 06.06.2023
 * Main Program  : sugarcrm_integration.php
 * Description   : dpLoghandler.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
  class dpLoghandler
{
      /**
       * @param $LoggerChannel
       * @param $File
       * @return Logger
       */
   static  function CreateLogger($LoggerChannel,$File,)
    {
        $dateFormat = "Y-m-d H:i:s";
        $output = "%datetime% [%channel%] %level_name%: %message% %context% %extra%\n";
        $formatter = new LineFormatter($output, $dateFormat);
// Create a handler
        $stream = new StreamHandler($File, Logger::DEBUG);
        $stream->setFormatter($formatter);

// bind it to a logger object
        $log = new Logger($LoggerChannel);
        $log->pushHandler($stream);
        return  $log;
    }

}
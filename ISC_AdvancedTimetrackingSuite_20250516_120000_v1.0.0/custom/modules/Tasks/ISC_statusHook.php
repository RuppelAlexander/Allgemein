<?php
/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : MoschkauM
 * Create Date   : 03.03.2025
 * Change Date   : 03.03.2025
 * Main Program  : Zeiterfassung Usability-Anpassungen
 * Description   : Hook zum setzen des Statues
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

namespace Sugarcrm\Sugarcrm\custom\modules\Tasks;

class ISC_statusHook
{
    function setStatus($bean, $event, $arguments)
    {
        if ($arguments['isUpdate']) {
            if (isset($bean->fetched_row['date_end_c']) && $bean->fetched_row['date_end_c'] !== $bean->date_end_c) {
                if (!empty($bean->date_end_c)) {
                    $bean->status="Completed";
                }
            }
        }
    }
}

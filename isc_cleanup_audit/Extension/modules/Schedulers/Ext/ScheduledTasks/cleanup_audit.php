<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 12.06.2025
 * Change Date   : 12.06.2025
 * Main Program  : cleanupAudit
 * Description   :
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

$job_strings[] = 'job_cleanup_audit';
function job_cleanup_audit()
{
    (new CleanupAuditJob())->run($GLOBALS['current_job']);
    return true;
}

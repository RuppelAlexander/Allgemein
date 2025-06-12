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
$manifest = [
    'key'                       => 'cleanup_audit',
    'name'                      => 'Cleanup Audit Tables',
    'description'               => 'Batch-delete old audit rows',
    'version'                   => '1.0.0',
    'author'                    => 'WOT Projekt',
    'is_uninstallable'          => true,
    'acceptable_sugar_versions' => ['14.*','25.*'],
    'post_execute'              => [],
    'type'                      => 'module',
];
$installdefs = [
    'id' => 'cleanup_audit',
    'copy' => [
        ['from'=>'src/CleanupAuditJob.php','to'=>'custom/src/CleanupAuditJob.php'],
    ],
    'beans' => [],
];

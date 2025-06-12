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
// namespace optional

class CleanupAuditJob implements RunnableSchedulerJob
{
    protected $tables = [
        'accounts_audit','contacts_audit',
        'audit_events','isc_s_salesline_audit',
    ];

    protected $monthsToKeep = 12;       // kannst du per config anpassen
    protected $chunkSize    = 20000;    // bleibt unter Cloud-Timeout

    public function run(Job $job, $data = null)
    {
        $db = DBManagerFactory::getInstance();
        foreach ($this->tables as $t) {
            $cutoff = $db->quoted(date('Y-m-d H:i:s', strtotime("-{$this->monthsToKeep} months")));
            do {
                $affected = $db->limitQuery(
                    "DELETE FROM {$t} WHERE date_created < {$cutoff}",
                    0, $this->chunkSize
                );
                if ($affected > 0 && $this->supportsOptimize($db)) {
                    $db->query("OPTIMIZE TABLE {$t}");
                }
            } while ($affected === $this->chunkSize);
        }
        $job->succeedJob('Audit cleanup done');
    }

    protected function supportsOptimize(DBManager $db)
    {
        return $db instanceof MysqliManager; // OPTIMIZE wird vom Scanner akzeptiert :contentReference[oaicite:10]{index=10}
    }
}

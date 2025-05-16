<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 14.02.2024
 * Change Date   : 30.01.2025
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : CostCalculationHook.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 12.06.2024  DontG  fix line endings LF
 * 30.01.2025  DontG  Fix Wrong Field estimated_effort use budget_c
 * ----------------------------------------------------------------------------
 */

class CostCalculationHook {
    /**
     *  before_save
     * @param \SugarBean $bean
     * @param string     $event
     * @param array      $arguments
     * @return void
     */
    function QueueJob($bean, $event, $arguments) {
        $JobTarget = 'class::isc_pjtCostCalculation_job';

        // Bedingung $estimated_effort = 0 (sonst keine nachberechnug nötig)
        $budget_c = $bean->budget_c;
        if (empty($budget_c)) {
            $budget_c = 0;
        }

        if ($budget_c == 0) {
            // Prüfen, ob bereits ein Job mit dem gleichen Ziel und den gleichen Daten läuft
            if ($this->CheckInQueue($JobTarget, $bean->id)) {
                $GLOBALS['log']->fatal("QueueJob: Job bereits vorhanden.");
                return;
            }
            // Job zur Ausführung einreihen
            $this->AddToQueue($JobTarget, "ResaveProjectTasks: {$bean->name}", $bean->id, new SugarDateTime("+1 minutes"));
        }
    }

    /**
     * @param string         $JobTarget         Job class|function name
     * @param string         $JobTitle          Name
     * @param string         $data              (ProjectTask id)
     * @param \SugarDateTime $Job_due_date_time Job Startdatum
     * @return void
     * @throws \SugarQueryException
     */
    function AddToQueue($JobTarget, $JobTitle, $data, $Job_due_date_time) {
        global $current_user;
        $scheduler_id = $this->GetSchedulerId($JobTarget); // Passende Scheduler Id ermitteln
        $job = new SchedulersJob();
        $job->name = $JobTitle;
        $job->data = $data;
        $job->target = $JobTarget;
        if ($scheduler_id !== false) {
            $job->scheduler_id = $scheduler_id; // Wenn scheduler Id vorhanden dan diese Nehmen (job run liegt dan unter diesem Scheduler)
        }
        $job->assigned_user_id = $current_user->id;
        $job->execute_time = $Job_due_date_time->asDb();

        $queue = new SugarJobQueue();
        if ($queue->submitJob($job)) {
            //$GLOBALS['log']->fatal("QueueJob: Job erfolgreich eingereiht.");
        } else {
            $GLOBALS['log']->fatal("QueueJob: Fehler beim Einreihen des Jobs.");
        }

    }

    /**
     * @param String $JobTarget Job class|function name
     * @param String $data
     * @return bool
     * @throws \SugarQueryException
     */
    function CheckInQueue($JobTarget, $data) {
        $sq = new SugarQuery();
        $sq->from(BeanFactory::newBean('SchedulersJobs'));
        $sq->select(['id']);
        $sq->where()
            ->equals('target', $JobTarget)
            ->in('status', ['running', 'queued'])
            ->equals('data', $data);

        return $sq->getOne() !== false;
    }

    /**
     * Get Id Of Scheduler if Exist otherwise false
     * @param String $JobTarget Job class|function name
     * @return false|string false|Scheduler Id
     * @throws \SugarQueryException
     */
    function GetSchedulerId($JobTarget) {
        $oSugarQuery = new \SugarQuery();
        $oSugarQuery->from(\BeanFactory::newBean('Schedulers'));
        $oSugarQuery->select(['id']);
        $oSugarQuery->where()->equals('job', $JobTarget);
        return $oSugarQuery->getOne(); // Id des Passende Schedulers ermitteln (um Job darunter anzulegen)
    }
}

<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 06.05.2024
 * Change Date   : 06.05.2024
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Scheduler nachberechnung kosten_c
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 11.06.2024  DontG  Recreated from ar - my_custom_job
 * ----------------------------------------------------------------------------
 */

array_push($job_strings, 'class::isc_pjtCostCalculation_job');

class isc_pjtCostCalculation_job implements RunnableSchedulerJob {
    protected $job;

    public function setJob(SchedulersJob $job) {
        $this->job = $job;
    }

    public function run($data) {
        //  global $log;

        if (empty($data)) {
            $this->job->succeedJob("No Data - No Action"); // Meldung Im Job log was schiefgegangen ist
            return true;
        }
        // Prüfen, ob der Job bereits läuft
        $existingJob = $this->CheckIsRunning($data);
        if ($existingJob) {
            // $log->fatal("Job is already running, refusing to run twice!");
            $this->job->failJob("Job is already running, refusing to run twice!"); // Meldung Im Job log was schiefgegangen ist
            return false;
        }

        // Laden des ProjectTask Beans
        $bean = BeanFactory::getBean('ProjectTask', $data);
        if (empty($bean)) {
            // if (empty($bean)) {
            //   $log->fatal("Fehler: Bean konnte nicht geladen werden");
            $this->job->failJob("Fehler: ProjectTask {$bean->id}  konnte nicht geladen werden"); // Meldung Im Job log was schiefgegangen ist
            return false;
        }
        // Bedingung $estimated_effort = 0
        $budget_c = $bean->budget_c;
        if (empty($budget_c)) {
            $budget_c = 0;
        }
        if ($budget_c > 0) {
            //   das da IST KEIN FEHLER!
            $this->job->succeedJob("Keine Aktion benötigt: ProjectTask {$bean->id} erfordert keine Neuberechnung.");
            return true;
        } else {
            $query = new SugarQuery();
            $query->from(BeanFactory::newBean('ISC_Zeiterfassung'), array('team_security' => false));
            $query->join('projecttask_isc_zeiterfassung_1', array('alias' => 'zeiterfassung'));
            $query->select->selectReset()->fieldRaw('SUM(isc_zeiterfassung.working_hours)', 'gesamtstunden');
            $query->where()->equals('zeiterfassung.id', $bean->id);
            $gesamtstunden = $query->getOne();
            $bean->kosten_c = $gesamtstunden;
            $bean->save();
            $this->job->succeedJob("Erfolg: ProjectTask {$bean->id} aktualisiert mit gesamtstunden = {$bean->kosten_c}" . number_format()); // Meldung Im Job log was schiefgegangen ist
            return true;

        }
    }

    function CheckIsRunning($data) {
        if (empty($data)) {
            $data = '';
        }
        $query = new SugarQuery();
        $query->from(BeanFactory::newBean('SchedulersJobs'));
        $query->select(['id']);
        $query->where()->equals('status', 'running')->equals('target', $this->job->target)->equals('data', $data)->notEquals('id', $this->job->id);
        return $query->getOne();
    }
}

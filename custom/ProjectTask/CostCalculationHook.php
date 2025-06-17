<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 14.02.2024
 * Change Date   : 14.02.2024
 * Main Program  : sugar_intern_update_dev
 * Description   : CostCalculationHook.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


// custom/modules/ProjectTask/CostCalculationHook.php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CostCalculationHook
{
    function QueueJob(&$bean, $event, $arguments)
    {
        $GLOBALS['log']->fatal("QueueJob: startet.");

        // Prüfen, ob bereits ein Job mit dem gleichen Ziel und den gleichen Daten läuft
        if ($this->CheckInQueue("class::my_custom_jobs", $bean->id)) {
            $GLOBALS['log']->fatal("QueueJob: Job bereits vorhanden.");
            return;
        }

        // Job zur Ausführung einreihen
        $this->AddToQueue("class::my_custom_jobs", "ResaveProjectTasks: {$bean->name}", $bean->id, new SugarDateTime("+1 minutes"));
    }

    function AddToQueue($JobTarget, $JobTitle, $data, $Job_due_date_time)
    {
        global $current_user;

        $job = new SchedulersJob();
        $job->name = $JobTitle;
        $job->data = $data;
        $job->target = $JobTarget;
        $job->assigned_user_id = $current_user->id;
        $job->execute_time = $Job_due_date_time->asDb();

        $queue = new SugarJobQueue();
        if ($queue->submitJob($job)) {
            $GLOBALS['log']->fatal("QueueJob: Job erfolgreich eingereiht.");
        } else {
            $GLOBALS['log']->fatal("QueueJob: Fehler beim Einreihen des Jobs.");
        }
    }

    function CheckInQueue($JobTarget, $data)
    {
        $sq = new SugarQuery();
        $sq->from(BeanFactory::newBean('SchedulersJobs'));
        $sq->select(['id']);
        $sq->where()
            ->equals('target', $JobTarget)
            ->in('status', ['running', 'queued'])
            ->equals('data', $data);

        return $sq->getOne() !== false;
    }
}

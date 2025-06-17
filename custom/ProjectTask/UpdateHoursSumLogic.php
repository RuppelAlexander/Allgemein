<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class UpdateProjectTaskHoursLogic
{
    function updateHoursSum($bean, $event, $arguments)
    {
        try {
            if (empty($bean)) {
                $GLOBALS['log']->fatal("UpdateHoursSumLogic: Bean ist leer");
                return;
            }

            $totalHours = 0;
            foreach ($bean->linked_beans('projecttask_isc_zeiterfassung_1') as $timeEntry) {
                $totalHours += $timeEntry->working_hours;
            }

            $bean->kosten_c = $totalHours;
            $bean->save();
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("UpdateHoursSumLogic Fehler: " . $e->getMessage());
        }
    }
}




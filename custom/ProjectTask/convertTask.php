<?php

$priorities = array(
    'High' => 'P1',
    'Medium' => 'P2',
    'Low' => 'P3',
);



$task = new ProjectTask();
$task->retrieve($_REQUEST['record']);

if (!empty($task->acase_id_c))
    $ticketid = $task->acase_id_c;

$user = new User();
$user->retrieve($task->resource_id);

$project = new Project();
$project->retrieve($task->project_id);

$account = new Account();
$project->load_relationship('accounts');
$accounts = $project->accounts->getBeans();
foreach ($accounts as $key => $value)
    $account->retrieve($key);

$ticket = new aCase();
if (isset($ticketid))
    $ticket->retrieve($ticketid);
$ticket->name = $task->name;
$ticket->assigned_user_id = $task->resource_id;

$ticket->status = 'Assigned';
$ticket->priority = $priorities[$task->priority];
$ticket->projecttask_id_c = $task->id;
$ticket->project_nr_c = $project->projektnummer_c;
$ticket->main_project_nr_c = '';
if (strpos($account->name, 'ISC') !== false)
    $ticket->area_c = 'internal';
else
    $ticket->area_c = 'external';
$ticket->kind_c = $task->kind_c;
$ticket->date_inquiry_c = $task->date_inquiry_c;
$ticket->budget_c = $task->budget_c;
$ticket->billing_c = $task->billing_c;
$ticket->faktura_c = $task->faktura_c;
$ticket->date_start_c = $task->date_start;
$ticket->date_end_planned_c = $task->date_finish;
$ticket->date_end_real_c = '';
$ticket->account_id = $account->id;
$ticket->description = $task->description;
$ticket->save();
$task->acase_id_c = $ticket->id;
$task->save();
$url = "index.php?module=Cases&action=DetailView&record=" . $ticket->id;
SugarApplication::redirect($url);
?>

<?php
/**
 * ------------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ------------------------------------------------------------------------------
 * Author        : dontg
 * Create Date   : 13.04.2021
 * Change Date   : 13.04.2021
 * Main Program  : Sugar 10 Upgrade
 * Description   : convert ProjectTask  to Ticket
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date       name   Description
 * ------------------------------------------------------------------------------
 * ------------------------------------------------------------------------------
 */

class ISCProjectTask2TicketApi extends SugarApi
{
	public function registerApiRest()
	{
		return array(
			'ISCProjectTask2Ticket' => array(
				'reqType'   => 'GET',
				'path'      => array('ProjectTask', '?', 'convertProjectTask2Ticket'),
				'pathVars'  => array('ProjectTask', 'record', ''),
				'method'    => 'convertProjectTask2Ticket',
				'shortHelp' => 'convert ProjectTask to Ticket',
				'longHelp'  => '',
			),
		);
	}

	/**
	 * convertTask
	 * @param ServiceBase $api
	 * @param array       $args
	 * @return array
	 */
	public function convertProjectTask2Ticket(ServiceBase $api, array $args)
	{
		$rt = ['success' => true, 'ticket_id' => ''];
		$ProjectTask_id = $args['record'];


		$priorities = array(
			'High'   => 'P1',
			'Medium' => 'P2',
			'Low'    => 'P3',
		);


		$task = new ProjectTask();
		$task->retrieve($ProjectTask_id);

		if (!empty($task->acase_id_c)) {
			$ticketid = $task->acase_id_c;
		}
		$user = new User();
		$user->retrieve($task->resource_id);

		$project = new Project();
		$project->retrieve($task->project_id);

		$account = new Account();
		$project->load_relationship('accounts');
		$accounts = $project->accounts->getBeans();
		foreach ($accounts as $key => $value) {
			$account->retrieve($key);
		}

		$ticket = new aCase();
		if (isset($ticketid)) {
			$ticket->retrieve($ticketid);
		}
		$ticket->name = $task->name;
		$ticket->assigned_user_id = $task->resource_id;

		$ticket->status = 'Assigned';
		$ticket->priority = $priorities[$task->priority];
		$ticket->projecttask_id_c = $task->id;
		$ticket->project_nr_c = $project->projektnummer_c;
		$ticket->main_project_nr_c = '';
		if (strpos($account->name, 'ISC') !== false) {
			$ticket->area_c = 'internal';
		} else {
			$ticket->area_c = 'external';
		}
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
		$rt ['ticket_id'] = $ticket->id;
		return $rt;
	}
}

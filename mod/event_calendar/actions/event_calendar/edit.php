<?php

/**
 * Edit action
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

elgg_load_library('elgg:event_calendar');

// start a new sticky form session in case of failure
elgg_make_sticky_form('event_calendar');

$event_guid = get_input('event_guid', 0);
$group_guid = get_input('group_guid', 0);
$event = event_calendar_set_event_from_form($event_guid, $group_guid);

if ($event) {
	/* cyu notes:
	 * This section of the code will edit an existing event calendar entity
	 */

	// remove sticky form entries
	elgg_clear_sticky_form('event_calendar');
	$user_guid = elgg_get_logged_in_user_guid();
	if ($event_guid) {
		$action = 'update';
		$email_users = event_calendar_get_users_for_event($event_guid, $limit, $offset, false);
		$time = event_calendar_get_formatted_time($event);
		$date = explode("-", $time);
		$startdate = $date[0]; 
		$enddate = $date[1]; 
			
		$count = count($email_users);

		$cp_email_users = $email_users;
    	if ($count == 1) {

     		foreach($email_users as $result)
    			$email_users = $result['email'];
    		
		} else {
 	
			foreach($email_users as $result)
    			$array_email[] = $result['email'];
   
			$email_users = implode(",", $array_email);
    	}


		if (elgg_is_active_plugin('cp_notifications')) {
			// cyu - implemented minor edit option
			$minor_edit_thing = get_input('chk_ec_minor_edit');

			$message = array(
				'cp_event_send_to_user' => $cp_email_users,
				'cp_event_invite_url' => elgg_add_action_tokens_to_url("action/event_calendar/add_ics?guid={$event->guid}"),
				'cp_event_time' => "{$startdate} - {$enddate}",
				'cp_event' => $event,
				'type_event' => 'UPDATE',
				'cp_msg_type' => 'cp_event',
				'is_minor_edit' => $minor_edit_thing[0]
			);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
		}

		system_message(elgg_echo('event_calendar:manage_event_response'));
	
	} else {

		/* cyu notes:
		 * This section of the code will create the event calendar
		 */

		$action = 'create';

		$event_calendar_autopersonal = elgg_get_plugin_setting('autopersonal', 'event_calendar');
		if (!$event_calendar_autopersonal || ($event_calendar_autopersonal == 'yes'))
			event_calendar_add_personal_event($event->guid, $user_guid);

		$email_users = event_calendar_get_users_for_event($event->guid, $limit, $offset, false);
		$time = event_calendar_get_formatted_time($event);
		$date = explode("-", $time);
		$startdate = $date[0]; 
		$enddate = $date[1];

		$cp_email_users = $email_users; // cyu - we need the user entity
		$count = count($email_users);
    	if ($count == 1) {

     		foreach($email_users as $result)
    			$email_users = $result['email'];
    		
		} else {

 			foreach($email_users as $result)
    			$array_email[] = $result['email'];
    		
			$email_users = implode(",", $array_email);
    	}

		// cyu - trigger a plugin hook
    	if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_event_send_to_user' => $cp_email_users,
				'cp_event_invite_url' => elgg_add_action_tokens_to_url("action/event_calendar/add_ics?guid={$event->guid}"),
				'cp_event_time' => "{$startdate} - {$enddate}",
				'cp_event' => $event,
				'type_event' => 'REQUEST',
				'cp_msg_type' => 'cp_event',
				'is_minor_edit' => 0 // new event calendar will always send notifications
			);			
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
		}
		
		system_message(elgg_echo('event_calendar:add_event_response'));
	}

	elgg_create_river_item(array(
		'view' => "river/object/event_calendar/$action",
		'action_type' => $action,
		'subject_guid' => $user_guid,
		'object_guid' => $event->guid,
	));

	if ($event->schedule_type == 'poll')
		forward('event_poll/add/'.$event->guid);

	forward($event->getURL());

} else {

	// re-display form with error message
	register_error(elgg_echo('event_calendar:manage_event_error'));
	if ($event_guid) {
	
		forward('event_calendar/edit/'.$event_guid);
	
	} else {
		
		if ($group_guid)
			forward('event_calendar/add/'.$group_guid);
		else
			forward('event_calendar/add/');
		
	}

}

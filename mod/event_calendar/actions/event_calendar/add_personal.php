<?php

elgg_load_library('elgg:event_calendar');

$event_guid = get_input('guid', 0);
$event = get_entity($event_guid);
if (elgg_instanceof($event, 'object', 'event_calendar')) {
	$user_guid = elgg_get_logged_in_user_guid();
	if (!event_calendar_has_personal_event($event_guid,$user_guid)) {
		if (event_calendar_add_personal_event($event_guid,$user_guid)) {
			// the message
			$email_users = get_loggedin_user()->email; 
			$time = event_calendar_get_formatted_time($event);
			$date = explode("-", $time);
			$startdate = $date[0]; 
			$enddate = $date[1]; 
			
			
			if (elgg_is_active_plugin('cp_notifications')) {
				$message = array(
					'cp_event_send_to_user' => elgg_get_logged_in_user_entity(),
					'cp_event_invite_url' => elgg_add_action_tokens_to_url("action/event_calendar/add_ics?guid={$event->guid}"),
					'cp_event_time' => "{$startdate} - {$enddate}",
					'cp_event' => $event,
					'type_event' => 'REQUEST',
					'cp_msg_type' => 'cp_event',
					'is_minor_edit' => 0	// cyu - this will always send out a notification
				);
				$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
			}

			system_message(elgg_echo('event_calendar:add_to_my_calendar_response'));

		} else {
			register_error(elgg_echo('event_calendar:add_to_my_calendar_error'));
		}
	}
}

forward(REFERER);

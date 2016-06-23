<?php

elgg_load_library('elgg:event_calendar');

$event_guid = get_input('guid', 0);
$event = get_entity($event_guid);
if (elgg_instanceof($event, 'object', 'event_calendar')) {
	$user_guid = elgg_get_logged_in_user_guid();
	
		
			// the message
			$email_users = get_loggedin_user()->email; 
			$time = event_calendar_get_formatted_time($event);
			$date = explode("-", $time);
			$startdate = $date[0]; 
			$enddate = $date[1]; 
			$obj = elgg_get_entities(array(
   							'type' => 'user',
   							'guid' => $user_guid
						));
			if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_event_send_to_user' => $obj,
				//'cp_event_invite_url' => elgg_add_action_tokens_to_url("action/event_calendar/add_personal?guid={$event->guid}"),
				'cp_event_time' => "{$startdate} - {$enddate}",
				'startdate' => $startdate,
				'enddate' => $enddate,
				'cp_event' => $event,
				'type_event' => 'REQUEST',
				'cp_msg_type' => 'cp_event_ics',
						);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);

		}
			system_message(elgg_echo('event_calendar:add_to_my_calendar_ics_response'));

		} else {
			register_error(elgg_echo('event_calendar:add_to_my_calendar_ics_error'));
		}
	


forward(REFERER);

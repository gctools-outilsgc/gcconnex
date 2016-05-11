<?php
// asks the event owner to add you to the event

elgg_load_library('elgg:event_calendar');

$event_guid = get_input('guid', 0);
$user_guid = elgg_get_logged_in_user_guid();
$event = get_entity($event_guid);

if (elgg_instanceof($event, 'object', 'event_calendar')) {
	if (event_calendar_send_event_request($event, $user_guid)) {
		system_message(elgg_echo('event_calendar:request_event_response'));

			$link = elgg_get_site_url().'event_calendar/review_requests/'.$event->guid;
			$event_container = get_entity($event->container_guid);
			$email_users = get_loggedin_user()->email; 
			$name = get_loggedin_user()->name;
			$time = event_calendar_get_formatted_time($event);
			$date = explode("-", $time);
			$startdate = $date[0]; 
			$enddate = $date[1]; 

		if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_event_receiver' => $event_container->email,
				'cp_event_invite_url' => $link,
				'cp_topic_author' => $name,
				'startdate' => $startdate,
				'enddate' => $enddate,
				'event' => $event,
				'type_event' => 'REQUEST',
				'cp_msg_type' => 'cp_event_request',
						);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);

		}

	} else {
		register_error(elgg_echo('event_calendar:request_event_error'));
	}
}

forward(REFERER);

<?php
elgg_load_library('elgg:event_calendar');

$event_guid = get_input('guid', 0);
$event = get_entity($event_guid);
//$email_users = get_loggedin_user()->email; 

if (elgg_instanceof($event, 'object', 'event_calendar') && $event->canEdit()) {
	if (get_input('cancel', '')) {
		system_message(elgg_echo('event_calendar:delete_cancel_response'));
	} else {
		$email_users = event_calendar_get_users_for_event($event_guid, $limit, $offset, false);
		$count = count($email_users);
    	if ($count == 1){
     		foreach($email_users as $result) {
    		$email_users = $result['email'];
    		}
		}else{
 			foreach($email_users as $result) {
    		$array_email[] = $result['email'];
    		}
		$email_users = implode(",", $array_email);
    	}
		$time = event_calendar_get_formatted_time($event);
			$date = explode("-", $time);
			$startdate = $date[0]; 
			$enddate = $date[1]; 
			if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_event_receiver' => $email_users,
				'cp_event_invite_url' => $view_events_url,
				'startdate' => $startdate,
				'enddate' => $enddate,
				'event' => $event,
				'type_event' => 'CANCEL',
				'cp_msg_type' => 'cp_event',
						);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);

		}
		$container = get_entity($event->container_guid);
		$event->delete();
		system_message(elgg_echo('event_calendar:delete_response'));

			//$email_users = event_calendar_get_users_for_event($event_guid, $limit, $offset, false);

			


		if (elgg_instanceof($container, 'group')) {
			forward('event_calendar/group/'.$container->guid);
		} else {
			forward('event_calendar/list');
		}
	}
} else {
	register_error(elgg_echo('event_calendar:error_delete'));
}

forward(REFERER);

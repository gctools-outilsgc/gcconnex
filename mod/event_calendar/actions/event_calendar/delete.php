<?php
elgg_load_library('elgg:event_calendar');

$event_guid = get_input('guid', 0);
$event = get_entity($event_guid);
$email_users = get_loggedin_user()->email; 
		event_email($event, $resquest='CANCEL',$email_users);
if (elgg_instanceof($event, 'object', 'event_calendar') && $event->canEdit()) {
	if (get_input('cancel', '')) {
		system_message(elgg_echo('event_calendar:delete_cancel_response'));
	} else {
		$email_users = event_calendar_get_users_for_event($event_guid, $limit, $offset, false);
		event_email($event, $resquest='CANCEL',$email_users);
		$container = get_entity($event->container_guid);
		$event->delete();
		system_message(elgg_echo('event_calendar:delete_response'));
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

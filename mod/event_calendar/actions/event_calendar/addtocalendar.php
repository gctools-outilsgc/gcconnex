<?php
// this action allows an admin or event owner to approve a calendar request

elgg_load_library('elgg:event_calendar');

$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$event_guid = get_input('event_guid');

$user = get_entity($user_guid);
$event = get_entity($event_guid);

if (elgg_instanceof($event, 'object', 'event_calendar')
	&& elgg_instanceof($user, 'user')
	&& $event->canEdit()
	&& check_entity_relationship($user_guid, 'event_calendar_request', $event_guid)) {
		
	if (event_calendar_add_personal_event($event_guid, $user_guid)) {
		remove_entity_relationship($user_guid, 'event_calendar_request', $event_guid);
		if ($user_guid != elgg_get_logged_in_user_guid()) {
			$user_language = ($user->language) ? $user->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');
			$subject = elgg_echo('event_calendar:add_users_notify:subject', array(), $user_language);
			$message = elgg_echo('event_calendar:add_users_notify:body', array($user->name, $event->title, $event->getURL()), $user_language);
			notify_user($user_guid, elgg_get_logged_in_user_guid(), $subject, $message, array(
				'object' => $event,
				'action' => 'subscribe',
				'summary' => $subject
			));
		}
		system_message(elgg_echo('event_calendar:request_approved'));
	}
} else {
	register_error(elgg_echo('event_calendar:review_requests:error:approve'));
}

forward(REFERER);

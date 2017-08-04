<?php
	
$friend_guid = (int) get_input('friend_guid');
$user_guid = (int) get_input('user_guid');

$friend = get_user($friend_guid);
if (empty($friend)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$user = get_user($user_guid);
if (!($user instanceof \ElggUser) || !$user->canEdit()) {
	register_error(elgg_echo('action:unauthorized'));
	forward(REFERER);
}

if (!remove_entity_relationship($friend->getGUID(), 'friendrequest', $user->getGUID())) {
	register_error(elgg_echo('friend_request:decline:fail'));
	forward(REFERER);
}

$subject = elgg_echo('friend_request:decline:subject', [$user->name], $friend->language);
$message = elgg_echo('friend_request:decline:message', [$friend->name, $user->name], $friend->language);

$params = [
	'action' => 'friend_request_decline',
	'object' => $user,
];

notify_user($friend->getGUID(), $user->getGUID(), $subject, $message, $params);

system_message(elgg_echo('friend_request:decline:success'));

forward(REFERER);

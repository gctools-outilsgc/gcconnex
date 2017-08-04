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


if (remove_entity_relationship($user->getGUID(), 'friendrequest', $friend->getGUID())) {
	system_message(elgg_echo('friend_request:revoke:success'));
} else {
	register_error(elgg_echo('friend_request:revoke:fail'));
}

forward(REFERER);

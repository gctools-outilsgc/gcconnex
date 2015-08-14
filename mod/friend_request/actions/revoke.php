<?php
	
$friend_guid = (int) get_input("guid");

$friend = get_user($friend_guid);
if (!empty($friend)) {
	$user = elgg_get_logged_in_user_entity();
	
	if (remove_entity_relationship($user->getGUID(), "friendrequest", $friend->getGUID())) {
		system_message(elgg_echo("friend_request:revoke:success"));
	} else {
		register_error(elgg_echo("friend_request:revoke:fail"));
	}
}

forward(REFERER);

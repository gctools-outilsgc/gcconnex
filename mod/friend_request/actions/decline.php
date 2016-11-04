<?php

/**
* Friend request
* 
* @author ColdTrick IT Solutions
*/	

$friend_guid = (int) get_input("guid");

$friend = get_user($friend_guid);
if (!empty($friend)) {
	$user = elgg_get_logged_in_user_entity();
	
	if (remove_entity_relationship($friend->getGUID(), "friendrequest", $user->getGUID())) {
		$subject = elgg_echo("friend_request:decline:subject", array($user->name));
		$message = elgg_echo("friend_request:decline:message", array($friend->name, $user->name));
		
		system_message(elgg_echo("friend_request:decline:success"));
	} else {
		register_error(elgg_echo("friend_request:decline:fail"));
	}
}

forward(REFERER);

<?php
	
$friend_guid = (int) get_input("guid");

$friend = get_user($friend_guid);
if (!empty($friend)) {
	$user = elgg_get_logged_in_user_entity();
	
	if (remove_entity_relationship($friend->getGUID(), "friendrequest", $user->getGUID())) {
		
		$user->addFriend($friend->getGUID());
		$friend->addFriend($user->getGUID());			//Friends mean reciprical...
		
		// notify the user about the acceptance
		$subject = elgg_echo("friend_request:approve:subject", array($user->name, $user->name));
		$message = elgg_echo("friend_request:approve:message", array($user->name, $user->getURL(), $user->name, $user->getURL()));
		
		$params = array(
			"action" => "add_friend",
			"object" => $user
		);
		notify_user($friend->getGUID(), $user->getGUID(), $subject, $message, $params);
		
		system_message(elgg_echo("friend_request:approve:successful", array($friend->name)));
		
		// add to river
		elgg_create_river_item(array(
			"view" => "river/relationship/friend/create",
			"action_type" => "friend",
			"subject_guid" => $user->getGUID(),
			"object_guid" => $friend->getGUID(),
		));
		elgg_create_river_item(array(
			"view" => "river/relationship/friend/create",
			"action_type" => "friend",
			"subject_guid" => $friend->getGUID(),
			"object_guid" => $user->getGUID(),
		));
	} else {
		register_error(elgg_echo("friend_request:approve:fail", array($friend->name)));
	}
}

forward(REFERER);
	
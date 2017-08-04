<?php
	
//Get our data
$friend_guid = (int) get_input('friend');
$friend = get_user($friend_guid);

$user = elgg_get_logged_in_user_entity();

// Now we need to attempt to create the relationship
if (empty($user) || empty($friend)) {
	register_error(elgg_echo('friend_request:add:failure'));
	forward(REFERER);
}

// New for v1.1 - If the other user is already a friend (fan) of this user we should auto-approve the friend request...
if (check_entity_relationship($friend->getGUID(), 'friend', $user->getGUID())) {
	try {
		
		$user->addFriend($friend->getGUID());
		
		system_message(elgg_echo('friends:add:successful', [$friend->name]));
		forward(REFERER);
	} catch (Exception $e) {
		register_error(elgg_echo('friends:add:failure', [$friend->name]));
		forward(REFERER);
	}
} elseif (check_entity_relationship($friend->getGUID(), 'friendrequest', $user->getGUID())) {
	// Check if your potential friend already invited you, if so make friends
	if (remove_entity_relationship($friend->getGUID(), 'friendrequest', $user->getGUID())) {
		
		// Friends mean reciprical...
		$user->addFriend($friend->getGUID());
		$friend->addFriend($user->getGUID());
		
		system_message(elgg_echo('friend_request:approve:successful', [$friend->name]));
		
		// add to river
		friend_request_create_river_events($user->getGUID(), $friend->getGUID());
		
		forward(REFERER);
	} else {
		register_error(elgg_echo('friend_request:approve:fail', [$friend->name]));
		forward(REFERER);
	}
} else {
	try {
		if (!add_entity_relationship($user->getGUID(), 'friendrequest', $friend->getGUID())) {
			register_error(elgg_echo('friend_request:add:exists', [$friend->name]));
			forward(REFERER);
		}
	} catch (Exception $e) {
		// add_entity_relationship calls insert_data which CAN raise Exceptions.
		register_error(elgg_echo('friend_request:add:exists', [$friend->name]));
		forward(REFERER);
	}
}

system_message(elgg_echo('friend_request:add:successful', array($friend->name)));
forward(REFERER);

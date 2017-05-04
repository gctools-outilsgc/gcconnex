<?php
	
// Get the GUID of the user to friend
$friend_guid = (int) get_input("friend");

$errors = false;

// Get the user
$friend = get_user($friend_guid);
if (!empty($friend)) {
	$user = elgg_get_logged_in_user_entity();
	
	try{
		$user->removeFriend($friend->getGUID());
		
		// remove river items
		elgg_delete_river(array(
			"view" => "river/relationship/friend/create",
			"subject_guid" => $user->getGUID(),
			"object_guid" => $friend->getGUID()
		));
		
		try {
			//V1.1 - Old relationships might not have the 2 as friends...
			$friend->removeFriend($user->getGUID());
			
			// remove river items
			elgg_delete_river(array(
				"view" => "river/relationship/friend/create",
				"subject_guid" => $friend->getGUID(),
				"object_guid" => $user->getGUID()
			));

			// cyu - remove the relationship (if applicable) for the subscribed to user
			remove_entity_relationship($user->guid, 'cp_subscribed_to_email',$friend_guid);
			remove_entity_relationship($user->guid, 'cp_subscribe_to_site_mail',$friend_guid);

		} catch (Exception $e) {
			// do nothing
		}
	} catch (Exception $e) {
		register_error(elgg_echo("friends:remove:failure", array($friend->name)));
		$errors = true;
	}
} else {
	register_error(elgg_echo("friends:remove:failure", array($friend_guid)));
	$errors = true;
}

if (!$errors) {
	system_message(elgg_echo("friends:remove:successful", array($friend->name)));
}
	
forward(REFERER);

<?php
/**
 * All helper functions are bundled here
 */

/**
 * Create river events when a friend is added
 *
 * @param int $user_guid   the user who is accepting
 * @param int $friend_guid the friend who he accepted
 *
 * @return bool
 */
function friend_request_create_river_events($user_guid, $friend_guid) {
	
	$user_guid = sanitise_int($user_guid, false);
	$friend_guid = sanitise_int($friend_guid, false);
	
	if (empty($user_guid) || empty($friend_guid)) {
		return false;
	}
	
	// check plugin setting
	if (elgg_get_plugin_setting('add_river', 'friend_request') === 'no') {
		// no event are to be created
		return true;
	}
	
	// add to river
	elgg_create_river_item([
		'view' => 'river/relationship/friend/create',
		'action_type' => 'friend',
		'subject_guid' => $user_guid,
		'object_guid' => $friend_guid,
	]);
	elgg_create_river_item([
		'view' => 'river/relationship/friend/create',
		'action_type' => 'friend',
		'subject_guid' => $friend_guid,
		'object_guid' => $user_guid,
	]);
	
	return true;
}

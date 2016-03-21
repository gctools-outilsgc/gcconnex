<?php
/**
 * All event handlers are bundled in this file
 */

/**
 * Notify a user when a friend relationship is created
 *
 * @param string           $event       the name of the event
 * @param string           $object_type the type of the event
 * @param ElggRelationship $object      supplied realationship
 *
 * @return void
 */
function friend_request_event_create_friendrequest($event, $object_type, $object) {
	if (($object instanceof ElggRelationship)) {
		$user_one = get_user($object->guid_one);
		$user_two = get_user($object->guid_two);
			
		$view_friends_url = elgg_get_site_url() . "friend_request/" . $user_two->username;
			
		// Notify target user
		$subject = elgg_echo("friend_request:newfriend:subject", array($user_one->name));
		$message = elgg_echo("friend_request:newfriend:body", array($user_one->name, $view_friends_url));
		
		$params = array(
			"action" => "friend_request",
			"object" => $user_one
		);

		// cyu - 03/08/2016: modified to improve notifications
		if (elgg_is_active_plugin('cp_notifications')) {
			$message = array(
				'cp_friend_requester' => $user_one,
				'cp_friend_receiver' => $user_two,
				'cp_friend_invite_url' => $view_friends_url,
				'cp_msg_type' => 'cp_friend_request'
			);
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);

		} else {

			notify_user($object->guid_two, $object->guid_one, $subject, $message, $params);
		
		}

	}
}
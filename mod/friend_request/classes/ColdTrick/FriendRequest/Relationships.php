<?php

namespace ColdTrick\FriendRequest;

class Relationships {
	
	/**
	 * Send a notification on a friend request
	 *
	 * @param string            $event        the name of the event
	 * @param string            $type         the type of the event
	 * @param \ElggRelationship $relationship supplied param
	 *
	 * @return void
	 */
	public static function createFriendRequest($event, $type, $relationship) {
		
		if (!($relationship instanceof \ElggRelationship)) {
			return;
		}
		
		if ($relationship->relationship !== 'friendrequest') {
			return;
		}
		
		$requester = get_user($relationship->guid_one);
		$new_friend = get_user($relationship->guid_two);
		
		if (empty($requester) || empty($new_friend)) {
			return;
		}
		
		$view_friends_url = elgg_normalize_url("friend_request/{$new_friend->username}");
		
		// Notify target user
		$subject = elgg_echo('friend_request:newfriend:subject', [$requester->name], $new_friend->language);
		$message = elgg_echo('friend_request:newfriend:body', [
			$requester->name,
			$view_friends_url
		], $new_friend->language);
		
		$params = [
			'action' => 'friend_request',
			'object' => $requester,
		];
		notify_user($new_friend->getGUID(), $requester->getGUID(), $subject, $message, $params);
	}
}

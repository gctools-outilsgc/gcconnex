<?php

namespace ColdTrick\FriendRequest;

class PageHandler {

	/**
	 * Handle /friend_request pages
	 *
	 * @param array $page the url segments
	 *
	 * @return bool
	 */
	public static function friendRequest($page) {

		if (isset($page[0])) {
			$username = $page[0];
		} elseif (elgg_is_logged_in()) {
			$user = elgg_get_logged_in_user_entity();
			$username = $user->username;
		}

		if (!$username) {
			return false;
		}

		echo elgg_view_resource('friend_request', array(
			'username' => $username,
		));
		return true;
	}

	/**
	 * Forwards friendsof pagehandler to friends
	 *
	 * @param array $page the url segments
	 *
	 * @return bool
	 */
	public static function friendsofForward($page) {
		$username = elgg_extract('0', $page);
		forward("friends/$username");
	}

}

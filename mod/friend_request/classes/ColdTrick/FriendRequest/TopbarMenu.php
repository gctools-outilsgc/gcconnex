<?php

namespace ColdTrick\FriendRequest;

class TopbarMenu {
	
	/**
	 * Add menu items to the topbar
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value the current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register($hook, $type, $return_value, $params) {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			return;
		}
		
		$options = [
			'type' => 'user',
			'count' => true,
			'relationship' => 'friendrequest',
			'relationship_guid' => $user->getGUID(),
			'inverse_relationship' => true,
		];
	
		$count = elgg_get_entities_from_relationship($options);
		if (empty($count)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'friend_request',
			'href' => "friend_request/{$user->username}",
			'text' => elgg_view_icon('user') . elgg_format_element('span', ['class' => 'friend-request-new'], $count),
			'title' => elgg_echo('friend_request:menu'),
			'priority' => 301
		]);
		
		return $return_value;
	}
}

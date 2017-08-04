<?php

namespace ColdTrick\FriendRequest;

class Users {
	
	/**
	 * Add menu items to the entity menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value the current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerEntityMenu($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		if ($entity->getGUID() === $user->getGUID()) {
			// looking at yourself
			return;
		}
		
		// are we friends
		if (!$entity->isFriendOf($user->getGUID())) {
			// no, check if pending request
			if (check_entity_relationship($user->getGUID(), 'friendrequest', $entity->getGUID())) {
				// pending request
				$return_value[] = \ElggMenuItem::factory([
					'name' => 'friend_request',
					'text' => elgg_echo('friend_request:friend:add:pending'),
					'href' => "friend_request/{$user->username}#friend_request_sent_listing",
					'priority' => 500,
				]);
			} else {
				// add as friend
				$return_value[] = \ElggMenuItem::factory([
					'name' => 'add_friend',
					'text' => elgg_echo('friend:add'),
					'href' => "action/friends/add?friend={$entity->getGUID()}",
					'is_action' => true,
					'priority' => 500,
				]);
			}
		} else {
			// is friend, se remove friend link
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'remove_friend',
				'text' => elgg_echo('friend:remove'),
				'href' => "action/friends/remove?friend={$entity->getGUID()}",
				'is_action' => true,
				'priority' => 500,
			]);
		}
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the hover menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value the current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerUserHoverMenu($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
	
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		if ($entity->getGUID() === $user->getGUID()) {
			// looking at yourself
			return;
		}
		
		$requested = check_entity_relationship($user->getGUID(), 'friendrequest', $entity->getGUID());
		$is_friend = $entity->isFriend($user->getGUID());
		
		foreach ($return_value as $index => $item) {
			// change the text of the button to tell you already requested a friendship
			switch ($item->getName()) {
				case 'add_friend':
					if ($requested) {
						$item->setItemClass('hidden');
					}
					
					break;
				case 'remove_friend':
					if (!$requested && !$is_friend) {
						unset($return_value[$index]);
					}
					break;
			}
		}
		
		if ($requested) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'friend_request',
				'text' => elgg_echo('friend_request:friend:add:pending'),
				'href' => "friend_request/{$user->username}#friend_request_sent_listing",
				'section' => 'action',
			]);
		}
		
		return $return_value;
	}
}

<?php
/**
 * All plugin hook handlers are bundled here
 */

/**
 * Change the url of the friend user hover menu item when already requested to be friend
 *
 * @param string         $hook        the name of the hook
 * @param string         $type        the type of the hook
 * @param ElggMenuItem[] $returnvalue current return value
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function friend_request_user_menu_handler($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}

	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "user")) {
		return $returnvalue;
	}
	
	if ($entity->getGUID() == $user->getGUID()) {
		return $returnvalue;
	}
	
	if (!check_entity_relationship($user->getGUID(), "friendrequest", $entity->getGUID())) {
		return $returnvalue;
	}
	
	foreach ($returnvalue as $item) {
		// change the text of the button to tell you already requested a friendship
		if ($item->getName() == "add_friend") {
			$item->setText(elgg_echo("friend_request:friend:add:pending"));
			$item->setHref("friend_request/" . $user->username . "#friend_request_sent_listing");
			
			break;
		}
	}
	
	return $returnvalue;
}

/**
 * Add menu items to the entity menu of a user
 *
 * @param string         $hook        the name of the hook
 * @param string         $type        the type of the hook
 * @param ElggMenuItem[] $returnvalue current return value
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function friend_request_entity_menu_handler($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "user")) {
		return $returnvalue;
	}
	
	if ($entity->getGUID() == $user->getGUID()) {
		return $returnvalue;
	}
	
	// are we friends
	if (!$entity->isFriendOf($user->getGUID())) {
		// no, check if pending request
		if (check_entity_relationship($user->getGUID(), "friendrequest", $entity->getGUID())) {
			// pending request
			$returnvalue[] = ElggMenuItem::factory(array(
				"name" => "friend_request",
				"text" => elgg_echo("friend_request:friend:add:pending"),
				"href" => "friend_request/" . $user->username . "#friend_request_sent_listing",
				"priority" => 500
			));
		} else {
			// add as friend
			$returnvalue[] = ElggMenuItem::factory(array(
				"name" => "add_friend",
				"text" => elgg_echo("friend:add"),
				"href" => "action/friends/add?friend=" . $entity->getGUID(),
				"is_action" => true,
				"priority" => 500
			));
		}
	} else {
		// is friend, se remove friend link
		$returnvalue[] = ElggMenuItem::factory(array(
			"name" => "remove_friend",
			"text" => elgg_echo("friend:remove"),
			"href" => "action/friends/remove?friend=" . $entity->getGUID(),
			"is_action" => true,
			"priority" => 500
		));
	}
	
	return $returnvalue;
}

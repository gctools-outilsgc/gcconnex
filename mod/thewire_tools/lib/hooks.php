<?php
/**
 * all plugin hooks for this plugin are bundled here
 */

/**
 * Extends thewire pagehandler with some extra pages
 *
 * @param string $hook_name   'route'
 * @param string $entity_type 'thewire'
 * @param bool   $return      the default return value
 * @param array  $params      supplied params
 *
 * @return bool
 */
function thewire_tools_route_thewire($hook_name, $entity_type, $return, $params) {
	$page = elgg_extract("segments", $return);
	
	if (is_array($page)) {
		switch ($page[0]) {
			case "group":
				if (!empty($page[1])) {
					set_input("group_guid", $page[1]); // @todo is this still needed or replace with page_owner in page
						
					if (!empty($page[2])) {
						set_input("wire_username", $page[2]); // @todo is this still needed?
					}
						
					$include_file = "pages/group.php";
					break;
				}
			case "tag":
			case "search":
				if (isset($page[1])) {
					if ($page[0] == "tag") {
						set_input("query", "#" . $page[1]);
					} else {
						set_input("query", $page[1]);
					}
				}
				
				$include_file = "pages/search.php";
				break;
			case "autocomplete":
				$include_file = "procedures/autocomplete.php";
				break;
			case "conversation":
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				$include_file = "procedures/conversation.php";
				break;
			case "thread":
				elgg_push_context("thewire_thread");
			case "reply":
				if (!empty($page[1])) {
					$entity = get_entity($page[1]);
					
					if (!empty($entity) && elgg_instanceof($entity->getContainerEntity(), "group")) {
						elgg_set_page_owner_guid($entity->getContainerGUID());
					}
				}
				break;
			
		}
		
		if (!empty($include_file)) {
			include(dirname(dirname(__FILE__)) . "/" . $include_file);
			
			$return = false;
		}
		
	}
	
	return $return;
}

/**
 * Optionally extend the group owner block with a link to the wire posts of the group
 *
 * @param string         $hook_name   'register'
 * @param string         $entity_type 'menu:owner_block'
 * @param ElggMenuItem[] $return      all the current menu items
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function thewire_tools_owner_block_menu($hook_name, $entity_type, $return, $params) {
	
	$group = elgg_extract("entity", $params);
	if (elgg_instanceof($group, "group") && $group->thewire_enable != "no") {
		$url = "thewire/group/" . $group->getGUID();
		$item = new ElggMenuItem("thewire", elgg_echo("thewire_tools:group:title"), $url);
		$return[] = $item;
	}
	
	return $return;
}

/**
 * Provide a custom access pulldown for use on personal wire posts
 *
 * @param string $hook_name   'access:collections:write'
 * @param string $entity_type 'all'
 * @param array  $return      the current access options
 * @param array  $params      supplied params
 *
 * @return array
 */
function thewire_tools_access_write_hook($hook_name, $entity_type, $return, $params) {
	
	if (!elgg_in_context("thewire_add")) {
		return $return;
	}
	
	if (empty($return) || !is_array($return)) {
		return $return;
	}
	
	if (empty($params) || !is_array($params)) {
		return $return;
	}
	
	$user_guid = (int) elgg_extract("user_id", $params, elgg_get_logged_in_user_guid());
	if (empty($user_guid)) {
		return $return;
	}
	
	// remove unwanted access options
	unset($return[ACCESS_PRIVATE]);
	unset($return[ACCESS_FRIENDS]);
	
	// add groups (as this hook is only trigged when thewire_groups is enabled
	$options = array(
		"type" => "group",
		"limit" => false,
		"relationship" => "member",
		"relationship_guid" => $user_guid,
		"joins" => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
		"order_by" => "ge.name ASC"
	);
	
	$groups = new ElggBatch("elgg_get_entities_from_relationship", $options);
	foreach ($groups as $group) {
		if ($group->thewire_enable !== "no") {
			$return[$group->group_acl] = $group->name;
		}
	}
	
	return $return;
}

/**
 * Improves entity menu items for thewire objects
 *
 * @param string         $hook_name   'register'
 * @param string         $entity_type 'menu:entity'
 * @param ElggMenuItem[] $return      the current menu items
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function thewire_tools_register_entity_menu_items($hook_name, $entity_type, $return, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return;
	}
	
	$entity = elgg_extract("entity", $params, false);
	if (empty($entity) || !elgg_instanceof($entity, "object")) {
		return $return;
	}
		
	if (elgg_instanceof($entity, "object", "thewire")) {
		
		foreach ($return as $index => $menu_item) {
			switch ($menu_item->getName()) {
				case "thread":
					
					if (elgg_in_context("thewire_tools_thread") || elgg_in_context("thewire_thread")) {
						unset($return[$index]);
						break;
					}
					
					//removes thread link from thewire entity menu if there is no conversation
					if (!($entity->countEntitiesFromRelationship("parent") || $entity->countEntitiesFromRelationship("parent", true))) {
						unset($return[$index]);
					} else {
						$menu_item->rel = $entity->getGUID();
					}
					break;
				case "previous":
					unset($return[$index]);
					break;
				case "reply":
					if (elgg_in_context("thewire_tools_thread")) {
						unset($return[$index]);
						break;
					}
					
					$menu_item->setHref("#thewire-tools-reply-" . $entity->getGUID());
					$menu_item->rel = "toggle";
					break;
			}
		}
	}
	
	return $return;
}

/**
 * Add wire reply link to river wire entities
 *
 * @param string         $hook_name   'register'
 * @param string         $entity_type 'menu:river'
 * @param ElggMenuItem[] $return      the current menu items
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function thewire_tools_register_river_menu_items($hook_name, $entity_type, $return, $params) {
	$entity = $params["item"]->getObjectEntity();

	if (elgg_is_logged_in() && !empty($entity) && elgg_instanceof($entity, "object", "thewire")) {
		if (!is_array($return)) {
			$return = array();
		}
		$options = array(
			"name" => "reply",
			"text" => elgg_echo("reply"),
			"href" => "thewire/reply/" . $entity->getGUID(),
			"priority" => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}
	
	return $return;
}

/**
 * returns the correct widget title
 *
 * @param string $hook_name   'widget_url'
 * @param string $entity_type 'widget_manager'
 * @param string $return      the current widget url
 * @param array  $params      supplied params
 *
 * @return string the url for the widget
 */
function thewire_tools_widget_title_url($hook_name, $entity_type, $return, $params) {
	$result = $return;
	
	if (empty($result) && !empty($params) && is_array($params)) {
		$widget = $params["entity"];
		
		if ($widget instanceof ElggWidget) {
			switch ($widget->handler) {
				case "thewire":
					$result = "thewire/owner/" . $widget->getOwnerEntity()->username;
					break;
				case "index_thewire":
				case "thewire_post":
					$result = "thewire/all";
					break;
				case "thewire_groups":
					$result = "thewire/group/" . $widget->getOwnerGUID();
					break;
			}
		}
	}
	
	return $result;
}

/**
 * Add or remove widgets based on the group tool option
 *
 * @param string $hook_name   'group_tool_widgets'
 * @param string $entity_type 'widget_manager'
 * @param array  $return      current enable/disable widget handlers
 * @param array  $params      supplied params
 *
 * @return array
 */
function thewire_tools_tool_widgets_handler($hook_name, $entity_type, $return, $params) {
	
	if (!empty($params) && is_array($params)) {
		$entity = elgg_extract("entity", $params);
	
		if (!empty($entity) && elgg_instanceof($entity, "group")) {
			if (!is_array($return)) {
				$return = array();
			}
				
			if (!isset($return["enable"])) {
				$return["enable"] = array();
			}
			if (!isset($return["disable"])) {
				$return["disable"] = array();
			}
				
			// check different group tools for which we supply widgets
			if ($entity->thewire_enable == "yes") {
				$return["enable"][] = "thewire_groups";
			} else {
				$return["disable"][] = "thewire_groups";
			}
			
		}
	}
	
	return $return;
}

/**
 * Save the wire_tools preferences for the user
 *
 * @param string $hook         the name of the hook
 * @param stirng $type         the type of the hook
 * @param array  $return_value the current return value
 * @param array  $params       supplied values
 *
 * @return void
 */
function thewire_tools_notifications_settings_save_hook($hook, $type, $return_value, $params) {

	$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();
	if (empty($NOTIFICATION_HANDLERS) || !is_array($NOTIFICATION_HANDLERS)) {
		return;
	}

	$user_guid = (int) get_input("guid");
	if (empty($user_guid)) {
		return;
	}

	$user = get_user($user_guid);
	if (empty($user) || !$user->canEdit()) {
		return;
	}

	$methods = array();

	foreach ($NOTIFICATION_HANDLERS as $method) {
		$setting = get_input("thewire_tools_" . $method);

		if (!empty($setting)) {
			$methods[] = $method;
		}
	}

	if (!empty($methods)) {
		elgg_set_plugin_user_setting("notification_settings", implode(",", $methods), $user->getGUID(), "thewire_tools");
	} else {
		elgg_unset_plugin_user_setting("notification_settings", $user->getGUID(), "thewire_tools");
	}

	// set flag for correct fallback behaviour
	elgg_set_plugin_user_setting("notification_settings_saved", "1", $user->getGUID(), "thewire_tools");

}
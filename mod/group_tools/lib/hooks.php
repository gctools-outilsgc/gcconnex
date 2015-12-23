<?php
/**
 * All plugin hook callback functions are defined in this file
 *
 * @package group_tools
 */

/**
 * Allow group admins (not owners) to also edit group content
 *
 * @param string $hook         the 'permissions_check' hook
 * @param string $type         for the 'group' type
 * @param bool   $return_value the current value
 * @param array  $params       supplied params to help change the outcome
 *
 * @return bool true if can edit, false otherwise
 */
function group_tools_multiple_admin_can_edit_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	if (!empty($params) && is_array($params) && !$result) {
		if (array_key_exists("entity", $params) && array_key_exists("user", $params)) {
			$entity = $params["entity"];
			$user = $params["user"];

			if (($entity instanceof ElggGroup) && ($user instanceof ElggUser)) {
				if ($entity->isMember($user) && check_entity_relationship($user->getGUID(), "group_admin", $entity->getGUID())) {
					$result = true;
				}
			}
		}
	}

	return $result;
}

/**
 * Take over the groups page handler in some cases
 *
 * @param string $hook         the 'route' hook
 * @param string $type         for the 'groups' page handler
 * @param bool   $return_value tells which page is handled, contains:
 *    $return_value['handler'] => requested handler
 *    $return_value['segments'] => url parts ($page)
 * @param null   $params       no params provided
 *
 * @return bool false if we take over the page handler
 */
function group_tools_route_groups_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!empty($return_value) && is_array($return_value)) {
		$page = $return_value['segments'];
		
		switch ($page[0]) {
			case "all":
				$filter = get_input("filter");
				$default_filter = elgg_get_plugin_setting("group_listing", "group_tools");
				
				if (empty($filter) && !empty($default_filter)) {
					$filter = $default_filter;
					set_input("filter", $default_filter);
				} elseif (empty($filter)) {
					$filter = "newest";
					set_input("filter", $filter);
				}
				
				if (in_array($filter, array("yours", "open", "closed", "alpha", "ordered", "suggested"))) {
					// we will handle the output
					$result = false;
					
					include(dirname(dirname(__FILE__)) . "/pages/groups/all.php");
				}
				
				break;
			case "suggested":
				$result = false;
				
				include(dirname(dirname(__FILE__)) . "/pages/groups/suggested.php");
				break;
			case "search":
				$result = false;
					
				include(dirname(dirname(__FILE__)) . "/pages/groups/search.php");
				break;
			case "requests":
				$result = false;
				
				set_input("group_guid", $page[1]);
				if (isset($page[2])) {
					set_input("subpage", $page[2]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/groups/membershipreq.php");
				break;
			case "invite":
				$result = false;
				
				set_input("group_guid", $page[1]);
				
				include(dirname(dirname(__FILE__)) . "/pages/groups/invite.php");
				break;
			case "mail":
				$result = false;
				
				set_input("group_guid", $page[1]);
					
				include(dirname(dirname(__FILE__)) . "/pages/mail.php");
				break;
			case "group_invite_autocomplete":
				$result = false;
				
				include(dirname(dirname(__FILE__)) . "/procedures/group_invite_autocomplete.php");
				break;
			case "add":
				if (group_tools_is_group_creation_limited()) {
					admin_gatekeeper();
				}
				break;
			case "invitations":
				$result = false;
				if (isset($page[1])) {
					set_input("username", $page[1]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/groups/invitations.php");
				break;
			case "related":
				$result = false;
				
				if (isset($page[1])) {
					set_input("group_guid", $page[1]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/groups/related.php");
				break;
			case "profile":
				if (isset($page[1]) && is_numeric($page[1])) {
					$group = get_entity($page[1]);
					if (empty($group)) {
						// is this a hidden group
						$ia = elgg_set_ignore_access(true);
						
						$group = get_entity($page[1]);
						if (!empty($group) && elgg_instanceof($group, "group")) {
							// report to the user
							if (!elgg_is_logged_in()) {
								$_SESSION["last_forward_from"] = current_page_url();
								
								register_error(elgg_echo("loggedinrequired"));
							} else {
								register_error(elgg_echo("membershiprequired"));
							}
						}
						
						// restore access
						elgg_set_ignore_access($ia);
					}
				}
				break;
			case "activity":
				$result = false;
				
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/groups/river.php");
				break;
			default:
				// check if we have an old group profile link
				if (isset($page[0]) && is_numeric($page[0])) {
					$group = get_entity($page[0]);
					if (!empty($group) && elgg_instanceof($group, "group", null, "ElggGroup")) {
						register_error(elgg_echo("changebookmark"));
						forward($group->getURL());
					}
				}
				break;
		}
	}
	
	return $result;
}

/**
 * Modify the title menu in the groups context.
 *
 * @param string $hook         the 'register' hook
 * @param string $type         for the 'menu:title' menu
 * @param array  $return_value the menu items to show
 * @param array  $params       params to help extend the menu items
 *
 * @return ElggMenuItem[] a list of menu items
 */
function group_tools_menu_title_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	$page_owner = elgg_get_page_owner_entity();
	$user = elgg_get_logged_in_user_entity();
	
	if (elgg_in_context("groups")) {
		// modify some group menu items
		if (!empty($page_owner) && !empty($user) && ($page_owner instanceof ElggGroup)) {
			$invite_found = false;
			
			if (!empty($result) && is_array($result)) {
				
				foreach ($result as $menu_item) {
					
					switch ($menu_item->getName()) {
						case "groups:joinrequest":
							if (check_entity_relationship($user->getGUID(), "membership_request", $page_owner->getGUID())) {
								// user already requested to join this group
								$menu_item->setText(elgg_echo("group_tools:joinrequest:already"));
								$menu_item->setTooltip(elgg_echo("group_tools:joinrequest:already:tooltip"));
								$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/killrequest?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
							} elseif (check_entity_relationship($page_owner->getGUID(), "invited", $user->getGUID())) {
								// the user was invited, so let him/her join
								$menu_item->setName("groups:join");
								$menu_item->setText(elgg_echo("groups:join"));
								$menu_item->setTooltip(elgg_echo("group_tools:join:already:tooltip"));
								$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/join?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
							} elseif (group_tools_check_domain_based_group($page_owner, $user)) {
								// user has a matching email domain
								$menu_item->setName("groups:join");
								$menu_item->setText(elgg_echo("groups:join"));
								$menu_item->setTooltip(elgg_echo("group_tools:join:domain_based:tooltip"));
								$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/join?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
							}
							
							break;
						case "groups:invite":
							$invite_found = true;
							
							$invite = elgg_get_plugin_setting("invite", "group_tools");
							$invite_email = elgg_get_plugin_setting("invite_email", "group_tools");
							$invite_csv = elgg_get_plugin_setting("invite_csv", "group_tools");
							
							if (in_array("yes", array($invite, $invite_csv, $invite_email))) {
								$menu_item->setText(elgg_echo("group_tools:groups:invite"));
							}
							
							break;
					}
				}
				
				// check if we need to remove the group add button
				if (!empty($user) && !$user->isAdmin() && group_tools_is_group_creation_limited()) {
					foreach ($result as $index => $menu_item) {
						if ($menu_item->getName() == "add") {
							unset($result[$index]);
						}
					}
				}
			}
				
			// maybe allow normal users to invite new members
			if (elgg_in_context("group_profile") && !$invite_found) {
				// this is only allowed for group members
				if ($page_owner->isMember($user)) {
					// we're on a group profile page, but haven't found the invite button yet
					// so check if it should be here
					$setting = elgg_get_plugin_setting("invite_members", "group_tools");
					if (in_array($setting, array("yes_off", "yes_on"))) {
						$invite_members = $page_owner->invite_members;
						if (empty($invite_members)) {
							$invite_members = "no";
							if ($setting == "yes_on") {
								$invite_members = "yes";
							}
						}
						
						if ($invite_members == "yes") {
							// normal users are allowed to invite users
							$invite = elgg_get_plugin_setting("invite", "group_tools");
							$invite_email = elgg_get_plugin_setting("invite_email", "group_tools");
							$invite_csv = elgg_get_plugin_setting("invite_csv", "group_tools");
							
							if (in_array("yes", array($invite, $invite_csv, $invite_email))) {
								$text = elgg_echo("group_tools:groups:invite");
							} else {
								$text = elgg_echo("groups:invite");
							}
							
							$result[] = ElggMenuItem::factory(array(
								"name" => "groups:invite",
								"href" => "groups/invite/" . $page_owner->getGUID(),
								"text" => $text,
								"link_class" => "elgg-button elgg-button-action",
							));
						}
					}
				}
			}
			
			// group member export
			if (current_page_url() == elgg_normalize_url("groups/members/" . $page_owner->getGUID())) {
				if ($page_owner->canEdit() && (elgg_get_plugin_setting("member_export", "group_tools") == "yes")) {
					$result[] = ElggMenuItem::factory(array(
						"name" => "member_export",
						"text" => elgg_echo("group_tools:member_export:title_button"),
						"href" => "action/group_tools/member_export?group_guid=" . $page_owner->getGUID(),
						"is_action" => true,
						"class" => "elgg-button elgg-button-action"
					));
				}
			}
		}
	}
	
	return $result;
}

/**
 * Modify the user hover menu.
 *
 * @param string $hook         the 'register' hook
 * @param string $type         for the 'menu:user_hover' menu
 * @param array  $return_value the menu items to show
 * @param array  $params       params to help extend the menu items
 *
 * @return ElggMenuItem[] a list of menu items
 */
function group_tools_menu_user_hover_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	$page_owner = elgg_get_page_owner_entity();
	$loggedin_user = elgg_get_logged_in_user_entity();
	
	if (empty($page_owner) || !elgg_instanceof($page_owner, "group") || empty($loggedin_user)) {
		// not a group or logged in
		return $result;
	}
	
	if (!$page_owner->canEdit()) {
		// can't edit the group
		return $result;
	}
	
	if (empty($params) || !is_array($params)) {
		// wrong params
		return $result;
	}
	
	$user = elgg_extract("entity", $params);
	if (empty($user) || !elgg_instanceof($user, "user")) {
		// not a user menu
		return $result;
	}
	
	if (($page_owner->getOwnerGUID() == $user->getGUID()) || ($loggedin_user->getGUID() == $user->getGUID())) {
		// group owner or current user
		return $result;
	}
	
	if (!$page_owner->isMember($user)) {
		// user is not a member of the group
		return $result;
	}
	
	if (group_tools_group_multiple_admin_enabled($page_owner)) {
		$is_admin = check_entity_relationship($user->getGUID(), "group_admin", $page_owner->getGUID());
		
		$result[] = ElggMenuItem::factory(array(
			"name" => "group_admin",
			"text" => elgg_echo("group_tools:multiple_admin:profile_actions:add"),
			"href" => "action/group_tools/toggle_admin?group_guid=" . $page_owner->getGUID() . "&user_guid=" . $user->getGUID(),
			"is_action" => true,
			"item_class" => $is_admin ? "hidden" : ""
		));
		
		$result[] = ElggMenuItem::factory(array(
			"name" => "group_admin_remove",
			"text" => elgg_echo("group_tools:multiple_admin:profile_actions:remove"),
			"href" => "action/group_tools/toggle_admin?group_guid=" . $page_owner->getGUID() . "&user_guid=" . $user->getGUID(),
			"is_action" => true,
			"item_class" => $is_admin ? "" : "hidden"
		));
	}
	
	return $result;
}

/**
 * Modify the entity menu.
 *
 * @param string $hook         the 'register' hook
 * @param string $type         for the 'menu:entity' menu
 * @param array  $return_value the menu items to show
 * @param array  $params       params to help extend the menu items
 *
 * @return ElggMenuItem[] a list of menu items
 */
function group_tools_menu_entity_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!empty($params) && is_array($params)) {
		
		$entity = elgg_extract("entity", $params);
		$page_owner = elgg_get_page_owner_entity();
		
		if (elgg_in_context("group_tools_related_groups") && !empty($page_owner) && elgg_instanceof($page_owner, "group") && $page_owner->canEdit() && elgg_instanceof($entity, "group")) {
			// remove related group
			$result[] = ElggMenuItem::factory(array(
				"name" => "related_group",
				"text" => elgg_echo("group_tools:related_groups:entity:remove"),
				"href" => "action/group_tools/remove_related_groups?group_guid=" . $page_owner->getGUID() . "&guid=" . $entity->getGUID(),
				"confirm" => elgg_echo("question:areyousure")
			));
		} elseif (elgg_in_context("widgets_groups_show_members") && elgg_instanceof($entity, "group")) {
			// number of members
			$num_members = $entity->getMembers(10, 0, true);
			
			$result[] = ElggMenuItem::factory(array(
				"name" => "members",
				"text" => $num_members . " " . elgg_echo("groups:member"),
				"href" => false,
				"priority" => 200,
			));
		} elseif (elgg_instanceof($entity, "object", "groupforumtopic") && $entity->canEdit()) {
			$result[] = ElggMenuItem::factory(array(
				"name" => "status_change_open",
				"text" => '<i class="fa fa-lock fa-lg icon-unsel"><span class="wb-inv">Open</span></i>', //elgg_echo("open");,
				"confirm" => elgg_echo("group_tools:discussion:confirm:open"),
				"href" => "action/discussion/toggle_status?guid=" . $entity->getGUID(),
				"is_trusted" => true,
                 "title" => "Open the topic",
				"priority" => 200,
				"item_class" => ($entity->status == "closed") ? "" : "hidden"
			));
			$result[] = ElggMenuItem::factory(array(
				"name" => "status_change_close",
				"text" => '<i class="fa fa-unlock fa-lg icon-unsel"><span class="wb-inv">Close</span></i>', //elgg_echo("close");,
				"confirm" => elgg_echo("group_tools:discussion:confirm:close"),
				"href" => "action/discussion/toggle_status?guid=" . $entity->getGUID(),
				"is_trusted" => true,
                "title" => "Close the topic",
				"priority" => 201,
				"item_class" => ($entity->status == "closed") ? "hidden" : ""
			));
		} elseif (elgg_instanceof($entity, "group") && group_tools_show_hidden_indicator($entity)) {
			$access_id_string = get_readable_access_level($entity->access_id);
			$access_id_string = htmlspecialchars($access_id_string, ENT_QUOTES, "UTF-8", false);
			
			$text = "<span title='" . $access_id_string . "'>" . elgg_view_icon("eye") . "</span>";
			
			$result[] = ElggMenuItem::factory(array(
				"name" => "hidden_indicator",
				"text" => $text,
				"href" => false,
				"priority" => 1
			));
		} elseif (!elgg_in_context("widgets") && !empty($page_owner) && elgg_instanceof($page_owner, "group") && $page_owner->canEdit() && elgg_instanceof($entity, "user")) {
			// user listing in a group
			if (($page_owner->getOwnerGUID() != $entity->getGUID()) && ($entity->getGUID() != elgg_get_logged_in_user_guid()) && $page_owner->isMember($entity)) {
				// remove user from group
				$result[] = ElggMenuItem::factory(array(
					"name" => "removeuser",
					"text" => elgg_echo('groups:removeuser'),
					"href" => "action/groups/remove?user_guid=" . $entity->getGUID() . "&group_guid=" . $page_owner->getGUID(),
					"confirm" => elgg_echo("question:areyousure"),
					"priority" => 900
				));
				
				// add/remove group admins
				if (group_tools_group_multiple_admin_enabled($page_owner)) {
					$is_admin = check_entity_relationship($entity->getGUID(), "group_admin", $page_owner->getGUID());
					
					$result[] = ElggMenuItem::factory(array(
						"name" => "group_admin",
						"text" => elgg_echo("group_tools:multiple_admin:profile_actions:add"),
						"href" => "action/group_tools/toggle_admin?group_guid=" . $page_owner->getGUID() . "&user_guid=" . $entity->getGUID(),
						"is_action" => true,
						"priority" => 800,
						"item_class" => $is_admin ? "hidden" : ""
					));
					
					$result[] = ElggMenuItem::factory(array(
						"name" => "group_admin_remove",
						"text" => elgg_echo("group_tools:multiple_admin:profile_actions:remove"),
						"href" => "action/group_tools/toggle_admin?group_guid=" . $page_owner->getGUID() . "&user_guid=" . $entity->getGUID(),
						"is_action" => true,
						"priority" => 801,
						"item_class" => $is_admin ? "" : "hidden"
					));
				}
			}
		}
	}
	
	return $result;
}

/**
 * return an url to be used by Widget Manager
 *
 * @param string $hook         the 'widget_url' hook
 * @param string $type         for 'widget_manager'
 * @param string $return_value the default return value
 * @param array  $params       params to help set a correct url
 *
 * @return string the widger url
 */
function group_tools_widget_url_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!$result && !empty($params) && is_array($params)) {
		$widget = elgg_extract("entity", $params);
		
		if (!empty($widget) && elgg_instanceof($widget, "object", "widget")) {
			switch ($widget->handler) {
				case "group_members":
					$result = "groups/members/" . $widget->getOwnerGUID();
					break;
				case "group_invitations":
					$user = elgg_get_logged_in_user_entity();
					if (!empty($user)) {
						$result = "groups/invitations/" . $user->username;
					}
					break;
				case "discussion":
					$result = "discussion/all";
					break;
				case "group_forum_topics":
					$page_owner = elgg_get_page_owner_entity();
					if (!empty($page_owner) && ($page_owner instanceof ElggGroup)) {
						$result = "discussion/owner/" . $page_owner->getGUID();
						break;
					}
				case "group_river_widget":
					if ($widget->context != "groups") {
						$group_guid = (int) $widget->group_guid;
					} else {
						$group_guid = $widget->getOwnerGUID();
					}
					
					if (!empty($group_guid)) {
						$group = get_entity($group_guid);
						if (!empty($group) && elgg_instanceof($group, "group", null, "ElggGroup")) {
							$result = "groups/activity/" . $group_guid;
						}
					}
					break;
				case "index_groups":
				case "featured_groups":
					$result = "groups/all";
					break;
				case "a_user_groups":
					$owner = $widget->getOwnerEntity();
					if (!empty($owner) && elgg_instanceof($owner, "user")) {
						$result = "groups/member/" . $owner->username;
					}
					break;
				case "start_discussion":
					$owner = $widget->getOwnerEntity();
					if (!empty($owner) && elgg_instanceof($owner, "group")) {
						$result = "discussion/add/" . $owner->getGUID();
					}
					break;
				case "group_related":
					$result = "groups/related/" . $widget->getOwnerGUID();
					break;
			}
		}
	}
	
	return $result;
}

/**
 * Allows the edit of default access
 *
 * See:
 * @link http://trac.elgg.org/ticket/4415
 * @link https://github.com/Elgg/Elgg/pull/253
 *
 * @param string $hook         the 'access:default' hook
 * @param string $type         for the 'user' type
 * @param int    $return_value the default access for this user
 * @param array  $params       params to help change the value
 *
 * @return int the access_id to use as default
 */
function group_tools_access_default_handler($hook, $type, $return_value, $params) {
	
	// check if the page owner is a group
	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner) || !elgg_instanceof($page_owner, "group")) {
		return $return_value;
	}
	
	// check if the group as a default access set
	$group_access = $page_owner->getPrivateSetting("elgg_default_access");
	if ($group_access !== null) {
		$return_value = (int) $group_access;
	} else {
		// if the group hasn't set anything check if there is a site setting for groups
		$site_group_access = elgg_get_plugin_setting("group_default_access", "group_tools");
		if ($site_group_access !== null) {
			switch ($site_group_access) {
				case GROUP_TOOLS_GROUP_ACCESS_DEFAULT:
					$return_value = (int) $page_owner->group_acl;
					break;
				default:
					$return_value = (int) $site_group_access;
					break;
			}
		}
	}
	
	return $return_value;
}

/**
 * Changed the content of an input/access
 *
 * @param string $hook         the 'access:collections:write' hook
 * @param string $type         for the 'user' type
 * @param array  $return_value the default values
 * @param array  $params       params to help change the values
 *
 * @return array the new access options
 */
function group_tools_access_write_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (elgg_in_context("group_tools_default_access") && !empty($result) && is_array($result)) {
		// unset ACCESS_PRIVATE & ACCESS_FRIENDS;
		if (isset($result[ACCESS_PRIVATE])) {
			unset($result[ACCESS_PRIVATE]);
		}
		
		if (isset($result[ACCESS_FRIENDS])) {
			unset($result[ACCESS_FRIENDS]);
		}
		
		// reverse the array
		$result = array_reverse($result, true);
		
		// add group option
		$result[GROUP_TOOLS_GROUP_ACCESS_DEFAULT] = elgg_echo("group_tools:default:access:group");
	}
	
	return $result;
}

/**
 * Allow a group to be transfered by the correct user
 *
 * @param string $hook         the 'permissions_check' hook
 * @param string $type         for the 'group' type
 * @param bool   $return_value is the current user allowed to perform the action
 * @param array  $params       params to help chnage the return value
 *
 * @return bool true if we allow admin transfer
 */
function group_tools_admin_transfer_permissions_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	if (!$result && !empty($params) && is_array($params)) {
		$group = elgg_extract("entity", $params);
		if (!empty($group) && elgg_instanceof($group, "group")) {
			$result = true;
		}
	}

	return $result;
}

/**
 * A prepend hook to the groups/join action
 *
 * @param string $hook         'action'
 * @param string $type         'groups/join'
 * @param bool   $return_value true, return false to stop the action
 * @param null   $params       passed on params
 *
 * @return bool
 */
function group_tools_join_group_action_handler($hook, $type, $return_value, $params) {
	// hacky way around a short comming of Elgg core to allow users to join a group
	if (group_tools_domain_based_groups_enabled()) {
		elgg_register_plugin_hook_handler("permissions_check", "group", "group_tools_permissions_check_groups_join_hook");
	}
}

/**
 * A hook on the ->canEdit() of a group. This is done to allow e-mail domain users to join a group
 *
 * Note: this is a very hacky way arround a short comming of Elgg core
 *
 * @param string $hook         'permissions_check'
 * @param string $type         'group'
 * @param bool   $return_value is the current user allowed to edit the group
 * @param mixed  $params       passed on params
 *
 * @return bool
 */
function group_tools_permissions_check_groups_join_hook($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!$result && group_tools_domain_based_groups_enabled()) {
		// domain based groups are enabled, lets check if this user is allowed to join based on that
		if (!empty($params) && is_array($params)) {
			$group = elgg_extract("entity", $params);
			$user = elgg_extract("user", $params);
			
			if (!empty($group) && elgg_instanceof($group, "group") && !empty($user) && elgg_instanceof($user ,"user")) {
				if (group_tools_check_domain_based_group($group, $user)) {
					$result = true;
				}
			}
		}
	}
	
	return $result;
}

/**
 * A hook to extend the owner block of groups
 *
 * @param string         $hook         'register'
 * @param string         $type         'menu:owner_block'
 * @param ElggMenuItem[] $return_value the current menu items
 * @param mixed          $params       passed on params
 *
 * @return ElggMenuItem[]
 */
function group_tools_register_owner_block_menu_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	if (!empty($params) && is_array($params)) {
		$entity = elgg_extract("entity", $params);
		
		if (!empty($entity) && elgg_instanceof($entity, "group")) {
			if ($entity->related_groups_enable == "yes") {
				$result[] = ElggMenuItem::factory(array(
					"name" => "related_groups",
					"text" => elgg_echo("group_tools:related_groups:title"),
					"href" => "groups/related/" . $entity->getGUID(),
					"is_trusted" => true
				));
			}
		}
	}
	
	return $result;
}

/**
 * Check if registration is disabled, if so check for a valid group invite code and allow registration
 *
 * This will allow access to the registration page
 *
 * @param string $hook         'route'
 * @param string $type         'register'
 * @param array  $return_value the current page_handler settings
 * @param null   $params       null
 *
 * @return void
 */
function group_tools_route_register_handler($hook, $type, $return_value, $params) {
	
	// enable registration if disabled
	group_tools_enable_registration();
}

/**
 * Check if registration is disabled, if so check for a valid group invite code and allow registration
 *
 * This will allow access to the registration page
 *
 * @param string $hook         'action'
 * @param string $type         'register'
 * @param bool   $return_value true is the action is allowed to procceed
 * @param null   $params       null
 *
 * @return void
 */
function group_tools_action_register_handler($hook, $type, $return_value, $params) {
	
	// enable registration if disabled
	group_tools_enable_registration();
}

/**
 * Take over the livesearch pagehandler in case of group search
 *
 * @param string $hook         'route'
 * @param string $type         'livessearch'
 * @param array  $return_value the current params for the pagehandler
 * @param null   $params       null
 *
 * @return bool|void
 */
function group_tools_route_livesearch_handler($hook, $type, $return_value, $params) {
	
	// only return results to logged in users.
	if (!$user = elgg_get_logged_in_user_entity()) {
		exit;
	}
	
	if (!$q = get_input("term", get_input("q"))) {
		exit;
	}
	
	$input_name = get_input("name", "groups");
	
	$q = sanitise_string($q);
	
	// replace mysql vars with escaped strings
	$q = str_replace(array("_", "%"), array("\_", "\%"), $q);
	
	$match_on = get_input("match_on", "all");
	
	if (!is_array($match_on)) {
		$match_on = array($match_on);
	}
	
	// only take over groups search
	if (count($match_on) > 1 || !in_array("groups", $match_on)) {
		return $return_value;
	}
	
	if (get_input("match_owner", false)) {
		$owner_guid = $user->getGUID();
	} else {
		$owner_guid = ELGG_ENTITIES_ANY_VALUE;
	}
	
	$limit = sanitise_int(get_input("limit", 10));
	
	// grab a list of entities and send them in json.
	$results = array();
	
	$options = array(
		"type" => "group",
		"limit" => $limit,
		"owner_guid" => $owner_guid,
		"joins" => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
		"wheres" => array("(ge.name LIKE '%" . $q . "%' OR ge.description LIKE '%" . $q . "%')")
	);
	
	$entities = elgg_get_entities($options);
	if (!empty($entities)) {
		foreach ($entities as $entity) {
			$output = elgg_view_list_item($entity, array(
				"use_hover" => false,
				"class" => "elgg-autocomplete-item",
				"full_view" => false,
			));
			
			$icon = elgg_view_entity_icon($entity, "tiny", array(
				"use_hover" => false,
			));
			
			$result = array(
				"type" => "group",
				"name" => $entity->name,
				"desc" => $entity->description,
				"guid" => $entity->getGUID(),
				"label" => $output,
				"value" => $entity->getGUID(),
				"icon" => $icon,
				"url" => $entity->getURL(),
				"html" => elgg_view("input/grouppicker/item", array(
					"entity" => $entity,
					"input_name" => $input_name,
				)),
			);
			
			$results[$entity->name . rand(1, 100)] = $result;
		}
	}
	
	ksort($results);
	header("Content-Type: application/json");
	echo json_encode(array_values($results));
	exit;
}

/**
 * Add or remove widgets based on the group tool option
 *
 * @param string $hook         'group_tool_widgets'
 * @param string $type         'widget_manager'
 * @param array  $return_value current enable/disable widget handlers
 * @param array  $params       supplied params
 *
 * @return array
 */
function group_tools_tool_widgets_handler($hook, $type, $return_value, $params) {
	
	if (!empty($params) && is_array($params)) {
		$entity = elgg_extract("entity", $params);
		
		if (!empty($entity) && elgg_instanceof($entity, "group")) {
			if (!is_array($return_value)) {
				$return_value = array();
			}
			
			if (!isset($return_value["enable"])) {
				$return_value["enable"] = array();
			}
			if (!isset($return_value["disable"])) {
				$return_value["disable"] = array();
			}
			
			// check different group tools for which we supply widgets
			if ($entity->forum_enable == "yes") {
				$return_value["enable"][] = "group_forum_topics";
			} else {
				$return_value["disable"][] = "group_forum_topics";
				$return_value["disable"][] = "start_discussion";
			}
			
			if ($entity->related_groups_enable == "yes") {
				$return_value["enable"][] = "group_related";
			} else {
				$return_value["disable"][] = "group_related";
			}
			
			if ($entity->activity_enable == "yes") {
				$return_value["enable"][] = "group_river_widget";
			} else {
				$return_value["disable"][] = "group_river_widget";
			}
		}
	}
		
	return $return_value;
}

/**
 * make a filter menu on the membership request page
 *
 * @param string         $hook         name of the hook
 * @param string         $type         type of the hook
 * @param ElggMenuItem[] $return_value current menu items
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function group_tools_menu_filter_handler($hook, $type, $return_value, $params) {
	
	if (!elgg_in_context("group_membershipreq")) {
		return $return_value;
	}
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "group")) {
		return $return_value;
	}
	
	$return_value = array();
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "membershipreq",
		"text" => elgg_echo("group_tools:groups:membershipreq:requests"),
		"href" => "groups/requests/" . $entity->getGUID(),
		"is_trusted" => true,
		"priority" => 100
	));
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "invites",
		"text" => elgg_echo("group_tools:groups:membershipreq:invitations"),
		"href" => "groups/requests/" . $entity->getGUID() . "/invites",
		"is_trusted" => true,
		"priority" => 200
	));
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "email_invites",
		"text" => elgg_echo("group_tools:groups:membershipreq:email_invitations"),
		"href" => "groups/requests/" . $entity->getGUID() . "/email_invites",
		"is_trusted" => true,
		"priority" => 300
	));
	
	return $return_value;
}

/**
 * Set the correct url for group thumbnails
 *
 * @param string $hook         name of the hook
 * @param string $type         type of the hook
 * @param string $return_value current return value
 * @param array  $params       supplied params
 *
 * @return string
 */
function groups_tools_group_icon_url_handler($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$group = elgg_extract("entity", $params);
	if (empty($group) || !elgg_instanceof($group, "group")) {
		return $return_value;
	}
	
	$size = elgg_extract("size", $params, "medium");
	$iconsizes = elgg_get_config("icon_sizes");
	if (empty($size) || empty($iconsizes) || !array_key_exists($size, $iconsizes)) {
		return $return_value;
	}
	
	$icontime = $group->icontime;
	if (is_null($icontime)) {
		$icontime = 0;
		
		// handle missing metadata (pre 1.7 installations)
		// @see groups_icon_url_override()
		$fh = new ElggFile();
		$fh->owner_guid = $group->getOwnerGUID();
		$fh->setFilename("groups/{$group->getGUID()}large.jpg");
		
		if ($fh->exists()) {
			$icontime = time();
		}
		
		create_metadata($group->getGUID(), "icontime", $icontime, "integer", $group->getOwnerGUID(), ACCESS_PUBLIC);
	}
	if (empty($icontime)) {
		return $return_value;
	}
	
	$params = array(
		"group_guid" => $group->getGUID(),
		"guid" => $group->getOwnerGUID(),
		"size" => $size,
		"icontime" => $icontime
	);
	return elgg_http_add_url_query_elements("mod/group_tools/pages/groups/thumbnail.php", $params);
}

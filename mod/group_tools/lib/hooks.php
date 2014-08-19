<?php

	function group_tools_multiple_admin_can_edit_hook($hook, $type, $return_value, $params){
		$result = $return_value;
	
		if(!empty($params) && is_array($params) && !$result){
			if(array_key_exists("entity", $params) && array_key_exists("user", $params)){
				$entity = $params["entity"];
				$user = $params["user"];
	
				if(($entity instanceof ElggGroup) && ($user instanceof ElggUser)){
					if($entity->isMember($user) && check_entity_relationship($user->getGUID(), "group_admin", $entity->getGUID())){
						$result = true;
					}
				}
			}
		}
	
		return $result;
	}
	
	function group_tools_route_groups_handler($hook, $type, $return_value, $params){
		/**
		 * $return_value contains:
		 * $return_value['handler'] => requested handler
		 * $return_value['segments'] => url parts ($page)
		 */
		$result = $return_value;
		
		if(!empty($return_value) && is_array($return_value)){
			$page = $return_value['segments'];
			
			switch($page[0]){
				case "all":
					$filter = get_input("filter");
					
					if(empty($filter) && ($default_filter = elgg_get_plugin_setting("group_listing", "group_tools"))){
						$filter = $default_filter;
						set_input("filter", $default_filter);
					} elseif(empty($filter)) {
						$filter = "newest";
						set_input("filter", $filter);
					}
					
					if(in_array($filter, array("open", "closed", "alpha", "ordered", "suggested"))){
						// we will handle the output
						$result = false;
						
						include(dirname(dirname(__FILE__)) . "/pages/groups/all.php");
					}
					
					break;
				case "suggested":
					$result = false;
					
					include(dirname(dirname(__FILE__)) . "/pages/groups/suggested.php");
					break;
				case "requests":
					$result = false;
					
					set_input("group_guid", $page[1]);
					
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
					if(group_tools_is_group_creation_limited()){
						admin_gatekeeper();
					}
					break;
				case "invitations":
					$result = false;
					if(isset($page[1])){
						set_input("username", $page[1]);
					}
					
					include(dirname(dirname(__FILE__)) . "/pages/groups/invitations.php");
					break;
				default:
					// check if we have an old group profile link
					if(isset($page[0]) && is_numeric($page[0])) {
						if(($group = get_entity($page[0])) && elgg_instanceof($group, "group", null, "ElggGroup")){
							register_error(elgg_echo("changebookmark"));
							forward($group->getURL());
						}
					}
					break;
			}
		}
		
		return $result;
	}
	
	function group_tools_menu_title_handler($hook, $type, $return_value, $params){
		$result = $return_value;
		
		$page_owner = elgg_get_page_owner_entity();
		$user = elgg_get_logged_in_user_entity();
		
		if(!empty($result) && is_array($result)){
			if(elgg_in_context("groups")){
				// modify some group menu items
				if(!empty($page_owner) && !empty($user) && ($page_owner instanceof ElggGroup)){
					$invite_found = false;
					
					foreach($result as $menu_item){
						
						switch($menu_item->getName()){
							case "groups:joinrequest":
								if(check_entity_relationship($user->getGUID(), "membership_request", $page_owner->getGUID())){
									$menu_item->setText(elgg_echo("group_tools:joinrequest:already"));
									$menu_item->setTooltip(elgg_echo("group_tools:joinrequest:already:tooltip"));
									$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/killrequest?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
								}
								
								break;
							case "groups:invite":
								$invite_found = true;
								
								$invite = elgg_get_plugin_setting("invite", "group_tools");
								$invite_email = elgg_get_plugin_setting("invite_email", "group_tools");
								$invite_csv = elgg_get_plugin_setting("invite_csv", "group_tools");
								
								if(in_array("yes", array($invite, $invite_csv, $invite_email))){
									$menu_item->setText(elgg_echo("group_tools:groups:invite"));
								}
								
								break;
						}
					}
					
					// maybe allow normal users to invite new members
					if (elgg_in_context("group_profile") && !$invite_found) {
						// this is only allowed for group members
						if ($page_owner->isMember($user)) {
							// we're on a group profile page, but haven't found the invite button yet
							// so check if it should be here
							if (($setting = elgg_get_plugin_setting("invite_members", "group_tools")) && in_array($setting, array("yes_off", "yes_on"))) {
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
									
									if(in_array("yes", array($invite, $invite_csv, $invite_email))){
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
				}
				
				if(!empty($user) && !$user->isAdmin() && group_tools_is_group_creation_limited()){
					foreach($result as $index => $menu_item){
						if($menu_item->getName() == "add"){
							unset($result[$index]);
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	function group_tools_menu_user_hover_handler($hook, $type, $return_value, $params){
		$result = $return_value;
		
		$page_owner = elgg_get_page_owner_entity();
		$loggedin_user = elgg_get_logged_in_user_entity();
		
		if(!empty($page_owner) && ($page_owner instanceof ElggGroup) && !empty($loggedin_user)){
			// are multiple admins allowed
			if(elgg_get_plugin_setting("multiple_admin", "group_tools") == "yes"){
				if(!empty($params) && is_array($params)){
					$user = $params["entity"];
					
					// do we have a user
					if(!empty($user) && ($user instanceof ElggUser)){
						// is the user not the owner of the group and noet the current user
						if($page_owner->getOwnerGUID() != $user->getGUID() && $user->getGUID() != $loggedin_user->getGUID()){
							// is the user a member od this group
							if($page_owner->isMember($user)){
								// can we add/remove an admin
								if(($page_owner->getOwnerGUID() == $loggedin_user->getGUID()) || ($page_owner->group_multiple_admin_allow_enable == "yes" && $page_owner->canEdit()) || $loggedin_user->isAdmin()){
									if(check_entity_relationship($user->getGUID(), "group_admin", $page_owner->getGUID())){
										$text = elgg_echo("group_tools:multiple_admin:profile_actions:remove");
									} else {
										$text = elgg_echo("group_tools:multiple_admin:profile_actions:add");
									}
									
									$result[] = ElggMenuItem::factory(array(
										"text" => $text,
										"name" => "group_admin",
										"href" => elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/group_tools/toggle_admin?group_guid=" . $page_owner->getGUID() . "&user_guid=" . $user->getGUID())
									));
								}
							}
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	function group_tools_menu_entity_handler($hook, $type, $return_value, $params) {
		$result = $return_value;
		
		if (!empty($params) && is_array($params)) {
			
			$entity = elgg_extract("entity", $params);
			
			if (elgg_in_context("widgets_groups_show_members") && elgg_instanceof($entity, "group")) {
				// number of members
				$num_members = $entity->getMembers(10, 0, true);
				
				$result[] = ElggMenuItem::factory(array(
					"name" => "members",
					"text" => $num_members . " " . elgg_echo("groups:member"),
					"href" => false,
					"priority" => 200,
				));
			} elseif (elgg_instanceof($entity, "object", "groupforumtopic") && $entity->canEdit()) {
				$text = elgg_echo("close");
				$confirm = elgg_echo("group_tools:discussion:confirm:close");
				if ($entity->status == "closed") {
					$text = elgg_echo("open");
					$confirm = elgg_echo("group_tools:discussion:confirm:open");
				}
				
				$result[] = ElggMenuItem::factory(array(
					"name" => "status_change",
					"text" => $text,
					"confirm" => $confirm,
					"href" => "action/discussion/toggle_status?guid=" . $entity->getGUID(),
					"is_trusted" => true,
					"priority" => 200
				));
			}
		}
		
		return $result;
	}
	
	function group_tools_widget_url_handler($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if(!$result && !empty($params) && is_array($params)){
			$widget = elgg_extract("entity", $params);
			
			if(!empty($widget) && elgg_instanceof($widget, "object", "widget")){
				switch($widget->handler){
					case "group_members":
						$result = "/groups/members/" . $widget->getOwnerGUID();
						break;
					case "group_invitations":
						if($user = elgg_get_logged_in_user_entity()){
							$result = "/groups/invitations/" . $user->username;
						}
						break;
					case "discussion":
						$result = "/discussion/all";
						break;
					case "group_forum_topics":
						if(($page_owner = elgg_get_page_owner_entity()) && ($page_owner instanceof ElggGroup)){
							$result = "/discussion/owner/" . $page_owner->getGUID();
							break;
						}
					case "group_river_widget":
						if($widget->context != "groups"){
							$group_guid = (int) $widget->group_guid;
						} else {
							$group_guid = $widget->getOwnerGUID();
						}
						
						if(!empty($group_guid) && ($group = get_entity($group_guid))){
							if(elgg_instanceof($group, "group", null, "ElggGroup")){
								$result = "/groups/activity/" . $group_guid;
							}
						}
						break;
					case "index_groups":
					case "featured_groups":
						$result = "/groups/all";
						break;
					case "a_user_groups":
						if($owner = $widget->getOwnerEntity()){
							$result = "/groups/member/" . $owner->username;
						}
						break;
					case "start_discussion":
						if (($owner = $widget->getOwnerEntity()) && elgg_instanceof($owner, "group")) {
							$result = "/discussion/add/" . $owner->getGUID();
						}
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
	 * @param string $hook
	 * @param string $type
	 * @param int $return_value
	 * @param array $params
	 * @return int
	 */
	function group_tools_access_default_handler($hook, $type, $return_value, $params){
		global $GROUP_TOOLS_GROUP_DEFAULT_ACCESS_ENABLED;
		$GROUP_TOOLS_GROUP_DEFAULT_ACCESS_ENABLED = true;
		
		$result = $return_value;
		
		// check if the page owner is a group
		if(($page_owner = elgg_get_page_owner_entity()) && elgg_instanceof($page_owner, "group", null, "ElggGroup")){
			// check if the group as a default access set
			if(($group_access = $page_owner->getPrivateSetting("elgg_default_access")) !== false){
				$result = $group_access;
			}
			
			// if the group hasn't set anything check if there is a site setting for groups
			if($group_access === false){
				if(($site_group_access = elgg_get_plugin_setting("group_default_access", "group_tools")) !== null){
					switch($site_group_access){
						case GROUP_TOOLS_GROUP_ACCESS_DEFAULT:
							$result = $page_owner->group_acl;
							break;
						default:
							$result = $site_group_access;
							break;
					}
				}
			}
		}
		
		return $result;
	}
	
	function group_tools_access_write_handler($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if(elgg_in_context("group_tools_default_access") && !empty($result) && is_array($result)){
			// unset ACCESS_PRIVATE & ACCESS_FRIENDS;
			if(isset($result[ACCESS_PRIVATE])){
				unset($result[ACCESS_PRIVATE]);
			}
			
			if(isset($result[ACCESS_FRIENDS])){
				unset($result[ACCESS_FRIENDS]);
			}
			
			// reverse the array
			$result = array_reverse($result, true);
			
			// add group option
			$result[GROUP_TOOLS_GROUP_ACCESS_DEFAULT] = elgg_echo("group_tools:default:access:group");
		}
		
		return $result;
	}
	
	function group_tools_admin_transfer_permissions_hook($hook, $type, $return_value, $params) {
		$result = $return_value;
	
		if (!$result && !empty($params) && is_array($params)) {
			if (($group = elgg_extract("entity", $params)) && elgg_instanceof($group, "group")) {
				$result = true;
			}
		}
	
		return $result;
	}
	
<?php
/**
 * Fixes issues with Group ACLs
 *
 */

// maybe this could take a while
set_time_limit(0);

// what do we need to fix
$fix = get_input("fix");

switch ($fix) {
	case "missing":
		// users without access to group content
		$missing_users = group_tools_get_missing_acl_users();
		if (!empty($missing_users)) {
			// make sure we can see all users
			$hidden = access_get_show_hidden_status();
			access_show_hidden_entities(true);
			
			foreach ($missing_users as $user_data) {
				/**
				 * $user_data = row stdClass
				 * 		-> acl_id 		=> the acl the user should be added to
				 * 		-> group_guid 	=> the group the acl belongs to
				 * 		-> user_guid 	=> the user that should be added
				 */
				add_user_to_access_collection($user_data->user_guid, $user_data->acl_id);
			}
			
			// restore hidden settings
			access_show_hidden_entities($hidden);
			
			system_message(elgg_echo("group_tools:action:fix_acl:success:missing", array(count($missing_users))));
		} else {
			register_error(elgg_echo("group_tools:action:fix_acl:error:missing:nothing"));
		}
		break;
	case "excess":
		// users with access to group content, but no longer member
		$excess_users = group_tools_get_excess_acl_users();
		if (!empty($excess_users)) {
			foreach ($excess_users as $user_data) {
				/**
				* $user_data = row stdClass
				* 		-> acl_id 		=> the acl the user should be removed from
				* 		-> group_guid 	=> the group the acl belongs to
				* 		-> user_guid 	=> the user that should be removed
				*/
				group_tools_remove_user_from_access_collection($user_data->user_guid, $user_data->acl_id);
			}
			
			system_message(elgg_echo("group_tools:action:fix_acl:success:excess", array(count($excess_users))));
		} else {
			register_error(elgg_echo("group_tools:action:fix_acl:error:excess:nothing"));
		}
		break;
	case "without":
		// groups without acl
		$groups = group_tools_get_groups_without_acl();
		if (!empty($groups)) {
			// create the acl's for each group
			foreach ($groups as $group) {
				groups_create_event_listener("create", "group", $group);
			}
			
			// now add the group members
			$missing_users = group_tools_get_missing_acl_users();
			if (!empty($missing_users)) {
				// make sure we can see all users
				$hidden = access_get_show_hidden_status();
				access_show_hidden_entities(true);
				
				foreach ($missing_users as $user_data) {
					/**
					 * $user_data = row stdClass
					 * 		-> acl_id 		=> the acl the user should be added to
					 * 		-> group_guid 	=> the group the acl belongs to
					 * 		-> user_guid 	=> the user that should be added
					 */
					add_user_to_access_collection($user_data->user_guid, $user_data->acl_id);
				}
				
				// restore hidden settings
				access_show_hidden_entities($hidden);
			}
			
			system_message(elgg_echo("group_tools:action:fix_acl:success:without", array(count($groups))));
		} else {
			register_error(elgg_echo("group_tools:action:fix_acl:error:without:nothing"));
		}
		break;
	case "all":
		// fix all problems
		
		// first: groups without acl
		$groups = group_tools_get_groups_without_acl();
		if (!empty($groups)) {
			// create the acl's for each group
			foreach ($groups as $group) {
				groups_create_event_listener("create", "group", $group);
			}
			
			system_message(elgg_echo("group_tools:action:fix_acl:success:without", array(count($groups))));
		}
		
		// now add the group members
		$missing_users = group_tools_get_missing_acl_users();
		if (!empty($missing_users)) {
			// make sure we can see all users
			$hidden = access_get_show_hidden_status();
			access_show_hidden_entities(true);
			
			foreach ($missing_users as $user_data) {
				/**
				 * $user_data = row stdClass
				 * 		-> acl_id 		=> the acl the user should be added to
				 * 		-> group_guid 	=> the group the acl belongs to
				 * 		-> user_guid 	=> the user that should be added
				 */
				add_user_to_access_collection($user_data->user_guid, $user_data->acl_id);
			}
			
			// restore hidden settings
			access_show_hidden_entities($hidden);
			
			system_message(elgg_echo("group_tools:action:fix_acl:success:missing", array(count($missing_users))));
		}
		
		// users with access to group content, but no longer member
		$excess_users = group_tools_get_excess_acl_users();
		if (!empty($excess_users)) {
			foreach ($excess_users as $user_data) {
				/**
				 * $user_data = row stdClass
				 * 		-> acl_id 		=> the acl the user should be removed from
				 * 		-> group_guid 	=> the group the acl belongs to
				 * 		-> user_guid 	=> the user that should be removed
				 */
				group_tools_remove_user_from_access_collection($user_data->user_guid, $user_data->acl_id);
			}
			
			system_message(elgg_echo("group_tools:action:fix_acl:success:excess", array(count($excess_users))));
		}
		
		break;
	default:
		register_error(elgg_echo("group_tools:action:fix_acl:error:input", array($fix)));
		break;
}

forward(REFERER);

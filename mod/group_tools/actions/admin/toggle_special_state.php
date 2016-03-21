<?php
/**
 * (un)Mark a group a as special
 */

$group_guid = (int) get_input("group_guid");
$state = get_input("state");

if (!empty($group_guid)) {
	$group = get_entity($group_guid);
	if (!empty($group) && ($group instanceof ElggGroup)) {
		$result = false;
		
		switch ($state) {
			case "auto_join":
				$auto_join_groups = array();
				$auto_join_setting = elgg_get_plugin_setting("auto_join", "group_tools");
				if (!empty($auto_join_setting)) {
					$auto_join_groups = string_to_tag_array($auto_join_setting);
				}
					
				if (($key = array_search($group_guid, $auto_join_groups)) !== false) {
					unset($auto_join_groups[$key]);
				} else {
					$auto_join_groups[] = $group_guid;
				}
					
				if (!empty($auto_join_groups)) {
					$result = elgg_set_plugin_setting("auto_join", implode(",", $auto_join_groups), "group_tools");
				} else {
					$result = elgg_unset_plugin_setting("auto_join", "group_tools");
				}
				
				$success_message = elgg_echo("group_tools:action:toggle_special_state:auto_join");
				$error_message = elgg_echo("group_tools:action:toggle_special_state:error:auto_join");
				
				break;
			case "suggested":
				$suggested_groups = array();
				$suggested_setting = elgg_get_plugin_setting("suggested_groups", "group_tools");
				if (!empty($suggested_setting)) {
					$suggested_groups = string_to_tag_array($suggested_setting);
				}
				
				if (($key = array_search($group_guid, $suggested_groups)) !== false) {
					unset($suggested_groups[$key]);
				} else {
					$suggested_groups[] = $group_guid;
				}
				
				if (!empty($suggested_groups)) {
					$result = elgg_set_plugin_setting("suggested_groups", implode(",", $suggested_groups), "group_tools");
				} else {
					$result = elgg_unset_plugin_setting("suggested_groups", "group_tools");
				}
				
				$success_message = elgg_echo("group_tools:action:toggle_special_state:suggested");
				$error_message = elgg_echo("group_tools:action:toggle_special_state:error:suggested");
				
				break;
			default:
				$error_message = elgg_echo("group_tools:action:toggle_special_state:error:state");
				break;
		}
		
		if ($result) {
			system_message($success_message);
		} else {
			register_error($error_message);
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:entity"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward(REFERER);

<?php

/**
* Group Tools
*
* (un)Mark a group a as special
* 
* @author ColdTrick IT Solutions
*/	

$group_guid = (int) get_input('group_guid');
$state = get_input('state');

if (empty($group_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($group_guid, 'group');
$group = get_entity($group_guid);

$result = false;
$success_message = '';
$error_message = '';

switch ($state) {
	case 'suggested':
		$suggested_groups = [];
		$suggested_setting = elgg_get_plugin_setting('suggested_groups', 'group_tools');
		if (!empty($suggested_setting)) {
			$suggested_groups = string_to_tag_array($suggested_setting);
		}
		
		if (($key = array_search($group_guid, $suggested_groups)) !== false) {
			unset($suggested_groups[$key]);
		} else {
			$suggested_groups[] = $group_guid;
		}
		
		if (!empty($suggested_groups)) {
			$result = elgg_set_plugin_setting('suggested_groups', implode(',', $suggested_groups), 'group_tools');
		} else {
			$result = elgg_unset_plugin_setting('suggested_groups', 'group_tools');
		}
		
		$success_message = elgg_echo('group_tools:action:toggle_special_state:suggested');
		$error_message = elgg_echo('group_tools:action:toggle_special_state:error:suggested');
		
		break;
	default:
		$error_message = elgg_echo('group_tools:action:toggle_special_state:error:state');
		break;
}

if ($result) {
	system_message($success_message);
} else {
	register_error($error_message);
}

forward(REFERER);

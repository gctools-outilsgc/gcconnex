<?php
/**
 * save setting to show widgets on closed groups
 */

$group_guid = (int) get_input("group_guid");
$profile_widgets = get_input("profile_widgets", "no");

$forward_url = REFERER;

if (!empty($group_guid)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && ($group instanceof ElggGroup) && $group->canEdit()) {
		$group->profile_widgets = $profile_widgets;
		
		if ($group->save()) {
			$forward_url = $group->getURL();
			
			system_message(elgg_echo("group_tools:action:success"));
		} else {
			register_error(elgg_echo("group_tools:action:error:save"));
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:entity"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward($forward_url);

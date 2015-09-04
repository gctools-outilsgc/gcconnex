<?php
/**
 * Save the group welcome message
 */

$group_guid = (int) get_input("group_guid");
$welcome_message = get_input("welcome_message");

$forward_url = REFERER;

if (!empty($group_guid)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && elgg_instanceof($group, "group")) {
		if ($group->canEdit()) {
			$check_message = trim(strip_tags($welcome_message));
			
			if (!empty($check_message)) {
				$group->setPrivateSetting("group_tools:welcome_message", $welcome_message);
			} else {
				$group->removePrivateSetting("group_tools:welcome_message");
			}
			
			system_message(elgg_echo("group_tools:action:welcome_message:success"));
			$forward_url = $group->getURL();
		} else {
			register_error(elgg_echo("groups:cantedit"));
		}
	} else {
		register_error(elgg_echo("groups:notfound:details"));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward($forward_url);
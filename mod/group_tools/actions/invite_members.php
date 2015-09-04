<?php
/**
 * Invite users to the group
 */

$invite_members = get_input("invite_members");
$group_guid = (int) get_input("group_guid");

$forward_url = REFERER;

if (!empty($group_guid)) {
	$group = get_entity($group_guid);
	
	if (!empty($group) && $group->canEdit()) {
		if (elgg_instanceof($group, "group")) {
			$group->invite_members = $invite_members;
			
			$forward_url = $group->getURL();
			system_message(elgg_echo("group_tools:action:success"));
		} else {
			register_error(elgg_echo("ClassException:ClassnameNotClass", array($group_guid, elgg_echo("item:group"))));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

forward($forward_url);

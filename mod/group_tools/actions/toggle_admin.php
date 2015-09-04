<?php
/**
 * add/remove a user as a group admin
 */

$group_guid = (int) get_input("group_guid");
$user_guid = (int) get_input("user_guid");

$group = get_entity($group_guid);
$user = get_user($user_guid);

if (!empty($group) && !empty($user)) {
	if (($group instanceof ElggGroup) && $group->canEdit() && $group->isMember($user) && ($group->getOwnerGUID() != $user->getGUID())) {
		if (!check_entity_relationship($user->getGUID(), "group_admin", $group->getGUID())) {
			// user is admin, so remove
			if (add_entity_relationship($user->getGUID(), "group_admin", $group->getGUID())) {
				system_message(elgg_echo("group_tools:action:toggle_admin:success:add"));
			} else {
				register_error(elgg_echo("group_tools:action:toggle_admin:error:add"));
			}
		} else {
			// user is not admin, so add
			if (remove_entity_relationship($user->getGUID(), "group_admin", $group->getGUID())) {
				system_message(elgg_echo("group_tools:action:toggle_admin:success:remove"));
			} else {
				register_error(elgg_echo("group_tools:action:toggle_admin:error:remove"));
			}
		}
	} else {
		register_error(elgg_echo("group_tools:action:toggle_admin:error:group"));
	}
} else {
	register_error(elgg_echo("group_tools:action:error:input"));
}

forward(REFERER);

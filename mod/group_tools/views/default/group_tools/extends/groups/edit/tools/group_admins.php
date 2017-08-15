<?php
/**
 * Don't allow group admins (not owner) to set the group tool
 * option for assigning other group admins
 */

if (!group_tools_multiple_admin_enabled()) {
	return;
}

$page_owner = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();
if (!($page_owner instanceof ElggGroup) || !($user instanceof ElggUser)) {
	// how did you get here
	return;
}

if (($page_owner->getOwnerGUID() === $user->getGUID()) || $user->isAdmin()) {
	// user is the group owner
	// or a site admin
	return;
}

remove_group_tool_option('group_multiple_admin_allow');

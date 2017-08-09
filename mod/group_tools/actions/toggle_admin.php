<?php

/**
* Group Tools
*
* add/remove a user as a group admin
* 
* @author ColdTrick IT Solutions
*/

$group_guid = (int) get_input('group_guid');
$user_guid = (int) get_input('user_guid');

elgg_entity_gatekeeper($group_guid, 'group');
elgg_entity_gatekeeper($user_guid, 'user');

$group = get_entity($group_guid);
$user = get_user($user_guid);

if (!$group->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if (!$group->isMember($user) || ($group->getOwnerGUID() === $user->getGUID())) {
	register_error(elgg_echo('group_tools:action:toggle_admin:error:group'));
	forward(REFERER);
}

if (!check_entity_relationship($user->getGUID(), 'group_admin', $group->getGUID())) {
	// user is admin, so remove
	if (add_entity_relationship($user->getGUID(), 'group_admin', $group->getGUID())) {
		system_message(elgg_echo('group_tools:action:toggle_admin:success:add'));
	} else {
		register_error(elgg_echo('group_tools:action:toggle_admin:error:add'));
	}
} else {
	// user is not admin, so add
	if (remove_entity_relationship($user->getGUID(), 'group_admin', $group->getGUID())) {
		system_message(elgg_echo('group_tools:action:toggle_admin:success:remove'));
	} else {
		register_error(elgg_echo('group_tools:action:toggle_admin:error:remove'));
	}
}

forward(REFERER);

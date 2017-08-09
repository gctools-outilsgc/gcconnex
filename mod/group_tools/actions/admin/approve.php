<?php
/**
 * Approve a new group for use
 */

$group_guid = (int) get_input('guid');
elgg_entity_gatekeeper($group_guid, 'group');

$group = get_entity($group_guid);

// get access_id
$access_id = ACCESS_PUBLIC;
if (group_tools_allow_hidden_groups()) {
	$intended_access_id = $group->intended_access_id;
	if ($intended_access_id !== null) {
		$access_id = (int) $intended_access_id;
	}
	
	if ($access_id === ACCESS_PRIVATE) {
		$access_id = (int) $group->group_acl;
	}
}

// save access
$group->access_id = $access_id;
$group->save();

// unset temp access
unset($group->intended_access_id);

// notify owner
$owner = $group->getOwnerEntity();

$subject = elgg_echo('group_tools:group:admin_approve:approve:subject', [$group->name], $owner->language);
$summary = elgg_echo('group_tools:group:admin_approve:approve:summary', [$group->name], $owner->language);
$message = elgg_echo('group_tools:group:admin_approve:approve:message', [
	$owner->name,
	$group->name,
	$group->getURL(),
], $owner->language);

$params = [
	'object' => $group,
	'action' => 'approve',
	'summary' => $summary,
];
notify_user($owner->getGUID(), elgg_get_logged_in_user_guid(), $subject, $message, $params);

// report success
system_message(elgg_echo('group_tools:group:admin_approve:approve:success'));
forward(REFERER);

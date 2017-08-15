<?php
/**
 * Decline a new group
 */

$group_guid = (int) get_input('guid');
elgg_entity_gatekeeper($group_guid, 'group');

$group = get_entity($group_guid);

// notify owner
$owner = $group->getOwnerEntity();

$subject = elgg_echo('group_tools:group:admin_approve:decline:subject', [$group->name], $owner->language);
$summary = elgg_echo('group_tools:group:admin_approve:decline:summary', [$group->name], $owner->language);
$message = elgg_echo('group_tools:group:admin_approve:decline:message', [
	$owner->name,
	$group->name,
], $owner->language);

$params = [
	'summary' => $summary,
];
notify_user($owner->getGUID(), elgg_get_logged_in_user_guid(), $subject, $message, $params);

// correct forward url
$forward_url = REFERER;
if ($_SERVER['HTTP_REFERER'] === $group->getURL()) {
	$forward_url = 'groups/all';
}

// delete group
$group->delete();

// report success
system_message(elgg_echo('group_tools:group:admin_approve:decline:success'));
forward($forward_url);

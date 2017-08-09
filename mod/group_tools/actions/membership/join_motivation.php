<?php
/**
 * Join a group with motivation provided
 *
 */

$group_guid = (int) get_input('group_guid');
$motivation = get_input('motivation');

if (empty($group_guid) || empty($motivation)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$group = get_entity($group_guid);
if (!($group instanceof ElggGroup)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

// create membership request
add_entity_relationship($user->getGUID(), 'membership_request', $group->getGUID());

// add motivation
$group->annotate('join_motivation', $motivation, $group->group_acl, $user->getGUID());

// notify owner
$owner = $group->getOwnerEntity();

$url = elgg_normalize_url("groups/requests/{$group->getGUID()}");

$subject = elgg_echo('group_tools:join_motivation:notification:subject', [
	$user->name,
	$group->name,
], $owner->language);
$summary = elgg_echo('group_tools:join_motivation:notification:summary', [
	$user->name,
	$group->name,
], $owner->language);

$body = elgg_echo('group_tools:join_motivation:notification:body', [
	$owner->name,
	$user->name,
	$group->name,
	$motivation,
	$user->getURL(),
	$url,
], $owner->language);

$params = [
	'action' => 'membership_request',
	'object' => $group,
	'summary' => $summary,
];

// Notify group owner
if (notify_user($owner->getGUID(), $user->getGUID(), $subject, $body, $params)) {
	system_message(elgg_echo("groups:joinrequestmade"));
} else {
	register_error(elgg_echo("groups:joinrequestnotmade"));
}

forward(REFERER);

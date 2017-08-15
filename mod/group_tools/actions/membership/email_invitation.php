<?php
/**
 * Accept an email invitation
 */

$invitecode = get_input('invitecode');

$user = elgg_get_logged_in_user_entity();

if (empty($invitecode)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$group = group_tools_check_group_email_invitation($invitecode);

if (empty($group)) {
	register_error(elgg_echo('group_tools:action:groups:email_invitation:error:code'));
	forward("groups/invitations/{$user->username}");
}

if (!groups_join_group($group, $user)) {
	register_error(elgg_echo('group_tools:action:groups:email_invitation:error:join', [$group->name]));
	forward("groups/invitations/{$user->username}");
}

$invitecode = sanitise_string($invitecode);

$options = [
	'guid' => $group->getGUID(),
	'annotation_name' => 'email_invitation',
	'wheres' => [
		"(v.string = '{$invitecode}' OR v.string LIKE '{$invitecode}|%')",
	],
	'annotation_owner_guid' => $group->getGUID(),
	'limit' => 1,
];

$annotations = elgg_get_annotations($options);
if (!empty($annotations)) {
	// ignore access in order to cleanup the invitation
	$ia = elgg_set_ignore_access(true);
	
	$annotations[0]->delete();
	
	// restore access
	elgg_set_ignore_access($ia);
}

system_message(elgg_echo('group_tools:action:groups:email_invitation:success'));
forward($group->getURL());

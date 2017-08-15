<?php
/**
 * Invite email addresses to a group
 *
 * used in /forms/groups/invite
 */

$group = elgg_extract('entity', $vars);

echo elgg_format_element('div', [], elgg_echo('group_tools:group:invite:email:description'));
echo elgg_view('input/group_invite_autocomplete', [
	'name' => 'user_guid',
	'id' => 'group_tools_group_invite_autocomplete_email',
	'group_guid' => $group->getGUID(),
	'relationship' => 'email',
]);

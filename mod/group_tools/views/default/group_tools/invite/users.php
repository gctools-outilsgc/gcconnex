<?php
/**
 * Invite users to a group
 *
 * used in /forms/groups/invite
 */

$group = elgg_extract('entity', $vars);

echo elgg_format_element('div', [], elgg_echo('group_tools:group:invite:users:description'));
echo elgg_view('input/group_invite_autocomplete', [
	'name' => 'user_guid',
	'id' => 'group_tools_group_invite_autocomplete',
	'group_guid' => $group->getGUID(),
	'relationship' => 'site',
]);

if (elgg_is_admin_logged_in()) {
	echo elgg_view('input/checkbox', [
		'name' => 'all_users',
		'value' => 'yes',
		'label' => elgg_echo('group_tools:group:invite:users:all'),
	]);
}

<?php
/**
 * User view for in the gorup invite autocomplete
 */

$name = elgg_extract('inputname', $vars);
$user = elgg_extract('user', $vars);
$group_guid = (int) elgg_extract('group_guid', $vars);

// user icon
$icon = elgg_view_entity_icon($user, 'tiny', [
	'use_hover' => false,
	'use_link' => false,
]);

// body
$body = elgg_view('input/hidden', [
	'name' => "{$name}[]",
	'value' => $user->getGUID(),
]);
$body .= elgg_view_icon('delete-alt', 'elgg-discoverable float-alt');
$body .= elgg_format_element('h3', [], $user->name);
if (check_entity_relationship($user->getGUID(), 'member', $group_guid)) {
	$body .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('group_tools:groups:invite:user_already_member'));
}

// build wrapper
$wrapper_attr = [
	'class' => [
		'group_tools_group_invite_autocomplete_autocomplete_result',
		'elgg-discover',
		'clearfix',
	],
];

echo elgg_format_element('div', $wrapper_attr, elgg_view_image_block($icon, $body));

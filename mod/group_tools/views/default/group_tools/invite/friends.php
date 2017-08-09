<?php
/**
 * Invite friends to a group
 *
 * used in /forms/groups/invite
 */

$user = elgg_get_logged_in_user_entity();
$friends_count = $user->getFriends(['count' => true]);

if (empty($friends_count)) {
	echo elgg_format_element('div', ['class' => 'group-tools-no-results'], elgg_echo('groups:nofriendsatall'));
	return;
}

$friends = $user->getFriends(['limit' => false]);

$toggle_content = elgg_format_element('span', [], elgg_echo('group_tools:group:invite:friends:select_all'));
$toggle_content .= elgg_format_element('span', ['class' => 'hidden'], elgg_echo('group_tools:group:invite:friends:deselect_all'));

echo elgg_view('input/friendspicker', [
	'entities' => $friends,
	'name' => 'user_guid',
	'highlight' => 'all',
]);
echo elgg_view('output/url', [
	'text' => $toggle_content,
	'href' => 'javascript:void(0);',
	'id' => 'group-tools-friends-toggle',
	'class' => 'elgg-button elgg-button-action',
]);

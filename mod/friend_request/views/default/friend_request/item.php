<?php

elgg_require_js('friend_request/item');

$size = elgg_extract('size', $vars, 'small');
$friend = elgg_extract('entity', $vars);
$user = elgg_get_page_owner_entity();

if (!$friend instanceof ElggUser || !$user instanceof ElggUser) {
	return;
}

$buttons = array();
if (check_entity_relationship($friend->guid, 'friendrequest', $user->guid)) {
	// received request
	$buttons[] = elgg_view('output/url', [
		'href' => "action/friend_request/approve?user_guid={$user->guid}&friend_guid={$friend->guid}",
		'text' => elgg_echo('friend_request:approve'),
		'is_action' => true,
		'class' => 'friend-request-button',
	]);
	$buttons[] = elgg_view('output/url', [
		'href' => "action/friend_request/decline?user_guid={$user->guid}&friend_guid={$friend->guid}",
		'text' => elgg_echo('friend_request:decline'),
		'is_action' => true,
		'class' => 'friend-request-button',
	]);
} else if (check_entity_relationship($user->guid, 'friendrequest', $friend->guid)) {
	// sent request
	$buttons[] = elgg_view('output/url', [
		'href' => "action/friend_request/revoke?user_guid={$user->guid}&friend_guid={$friend->guid}",
		'text' => elgg_echo('friend_request:revoke'),
		'is_action' => true,
		'class' => 'friend-request-button',
	]);
}

$menu = implode("&nbsp;|&nbsp;", $buttons);

$icon = elgg_view_entity_icon($friend, $size);
$summary = elgg_view('user/elements/summary', [
	'entity' => $friend,
	'content' => $menu,
]);

echo elgg_view_image_block($icon, $summary);

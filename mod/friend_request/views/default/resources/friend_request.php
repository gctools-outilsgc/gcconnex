<?php

elgg_gatekeeper();

$username = elgg_extract('username', $vars);
$user = get_user_by_username($username);

if (!$user instanceof ElggUser || !$user->canEdit()) {
	forward('', '404');
}

elgg_set_page_owner_guid($user->guid);

// set the correct context and page owner
elgg_push_context('friends');

// breadcrumb
elgg_push_breadcrumb(elgg_echo('friends'), "friends/{$user->username}");
elgg_push_breadcrumb(elgg_echo('friend_request:menu'));

// Get page elements
$title_text = elgg_echo('friend_request:title', [$user->name]);

$content = elgg_view('friend_request/received');
$content .= elgg_view('friend_request/sent');

// Build page
$body = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => false,
]);

// Draw page
echo elgg_view_page($title_text, $body);
	
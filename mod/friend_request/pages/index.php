<?php

gatekeeper();

$user = elgg_get_page_owner_entity();
if (!elgg_instanceof($user, "user")) {
	$user = elgg_get_logged_in_user_entity();
	elgg_set_page_owner_guid($user->getGUID());
}

if (!$user->canEdit()) {
	forward(REFERER);
}

// set the correct context and page owner
elgg_set_context("friends");

// fix to show collections links
if ($user->getGUID() == elgg_get_logged_in_user_guid()) {
	collections_submenu_items();
}

// breadcrumb
elgg_push_breadcrumb(elgg_echo("friends"), "friends/" . $user->username);
elgg_push_breadcrumb(elgg_echo("friend_request:menu"));

$options = array(
	"type" => "user",
	"limit" => false,
	"relationship" => "friendrequest",
	"relationship_guid" => $user->getGUID(),
	"inverse_relationship" => true
);

// Get all received requests
$received_requests = elgg_get_entities_from_relationship($options);

// Get all received requests
$options["inverse_relationship"] = false;
$sent_requests = elgg_get_entities_from_relationship($options);

// Get page elements
$title_text = elgg_echo('friend_request:title', array($user->name));
$title = elgg_view_title($title_text);

$received = elgg_view("friend_request/received", array("entities" => $received_requests));
$sent = elgg_view("friend_request/sent", array("entities" => $sent_requests));

// Build page
$params = array(
	"title" => $title_text,
	"content" => $received . $sent,
	"filter" => false
);

$body = elgg_view_layout("content", $params);

// Draw page
echo elgg_view_page($title_text, $body);
	
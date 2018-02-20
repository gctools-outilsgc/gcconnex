<?php

/**
* Friend Request Page
*
* @author ColdTrick IT Solutions
*/

elgg_gatekeeper();

$user = elgg_get_page_owner_entity();
if (!elgg_instanceof($user, "user")) {
	$user = elgg_get_logged_in_user_entity();
	elgg_set_page_owner_guid($user->getGUID());
}

if (!$user->canEdit()) {
	forward(REFERER);
}

// set the correct context and page owner
elgg_push_context("friends");

// breadcrumb
elgg_push_breadcrumb(elgg_echo("friends"), "friends/" . $user->username);
elgg_push_breadcrumb(elgg_echo("friend_request:menu"));

$dbprefix = elgg_get_config('dbprefix');
$options = array(
	"type" => "user",
	"limit" => "500",
	"relationship" => "friendrequest",
	"relationship_guid" => $user->getGUID(),
	"inverse_relationship" => true,
	'joins' => array("JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid"),
	'order_by' => 'ue.name ASC',
	'full_view' => false,
	'item_view' => "friend_request/received",
	'no_results' => elgg_echo('friend_request:received:none')

);

// Get all received requests
$received_requests = elgg_list_entities_from_relationship($options);
$received = elgg_view_module("info", elgg_echo("friend_request:received:title"), $received_requests, array("class" => "mbm"));

// Get all sent requests
$options["inverse_relationship"] = false;
$options["item_view"] = "friend_request/sent";
$options['no_results'] = elgg_echo('friend_request:sent:none');
$sent_requests = elgg_list_entities_from_relationship($options);
$sent = elgg_view_module("info", elgg_echo("friend_request:sent:title"), $sent_requests, array("class" => "mbm"));

// Get page elements
$title_text = elgg_echo('friend_request:title', array($user->name));
$title = elgg_view_title($title_text);


// Build page
$params = array(
	"title" => $title_text,
	"content" => $received . $sent,
	"filter" => false
);

$body = elgg_view_layout("content", $params);

// Draw page
echo elgg_view_page($title_text, $body);

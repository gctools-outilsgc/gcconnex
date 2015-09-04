<?php
/**
 * List all group invitations
 */

gatekeeper();

$user = elgg_get_page_owner_entity();
if (empty($user) || !elgg_instanceof($user, "user") || !$user->canEdit()) {
	forward();
}

// build breadcrumb
elgg_push_breadcrumb(elgg_echo("groups"), "groups/all");

$title = elgg_echo("groups:invitations");
elgg_push_breadcrumb($title);

// @todo temporary workaround for exts #287.
$invitations = groups_get_invited_groups($user->getGUID());

// get membership requests
$request_options = array(
	"type" => "group",
	"relationship" => "membership_request",
	"relationship_guid" => $user->getGUID(),
	"limit" => false,
	"full_view" => false,
	"pagination" => false
);
$requests = elgg_get_entities_from_relationship($request_options);

// invite by email allowed
$invite_email = false;
$email_invitations = false;

if (elgg_get_plugin_setting("invite_email", "group_tools") == "yes") {
	$invite_email = true;
	
	$email_invitations = group_tools_get_invited_groups_by_email($user->email);
}

$content = elgg_view("groups/invitationrequests", array(
	"user" => $user,
	"invitations" => $invitations,
	"requests" => $requests,
	"invite_email" => $invite_email,
	"email_invitations" => $email_invitations
));

// build page content
$params = array(
	"content" => $content,
	"title" => $title,
	"filter" => "",
);
$body = elgg_view_layout("content", $params);

// draw page
echo elgg_view_page($title, $body);

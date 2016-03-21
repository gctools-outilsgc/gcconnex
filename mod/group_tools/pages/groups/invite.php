<?php
/**
 * Invite users to groups
 *
 * @package ElggGroups
 */

gatekeeper();

$guid = (int) get_input("group_guid");
$group = get_entity($guid);

if (!empty($group) && ($group instanceof ElggGroup)) {

	if ($group->canEdit() || group_tools_allow_members_invite($group)) {
		elgg_set_page_owner_guid($guid);
		
		// get plugin settings
		$invite = elgg_get_plugin_setting("invite", "group_tools");
		$invite_email = elgg_get_plugin_setting("invite_email", "group_tools");
		$invite_csv = elgg_get_plugin_setting("invite_csv", "group_tools");
			
		if (in_array("yes", array($invite, $invite_csv, $invite_email))) {
			$title = elgg_echo("group_tools:groups:invite:title");
			$breadcrumb = elgg_echo("group_tools:groups:invite");
		} else {
			$title = elgg_echo("groups:invite:title");
			$breadcrumb = elgg_echo("groups:invite");
		}
		
		elgg_push_breadcrumb(elgg_echo("groups"), "groups/all");
		elgg_push_breadcrumb($group->name, $group->getURL());
		elgg_push_breadcrumb($breadcrumb);
	
		$content = elgg_view_form("groups/invite", array(
			"id" => "invite_to_group",
			"class" => "elgg-form-alt mtm",
			"enctype" => "multipart/form-data"
		), array(
			"entity" => $group,
			"invite" => $invite,
			"invite_email" => $invite_email,
			"invite_csv" => $invite_csv
		));
		
		$params = array(
			"content" => $content,
			"title" => $title,
			"filter" => "",
		);
		$body = elgg_view_layout("content", $params);
	
		echo elgg_view_page($title, $body);
	} else {
		register_error(elgg_echo("groups:noaccess"));
		forward(REFERER);
	}
} else {
	register_error(elgg_echo("groups:noaccess"));
	forward(REFERER);
}

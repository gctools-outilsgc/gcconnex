<?php
/**
 * Configure a welcome message to send to a new member when he/she joins the group
 */

$group = elgg_extract("entity", $vars);

if (!empty($group) && ($group instanceof ElggGroup) && $group->canEdit()) {
	$title = elgg_echo("group_tools:welcome_message:title");
	
	$form_body = "<div>" . elgg_echo("group_tools:welcome_message:description") . "</div>";
	$form_body .= elgg_view("input/longtext", array("name" => "welcome_message", "value" => $group->getPrivateSetting("group_tools:welcome_message")));
	
	$form_body .= "<div class='elgg-subtext'>";
	$form_body .= elgg_view("output/longtext", array("value" => elgg_echo("group_tools:welcome_message:explain", array(
		elgg_get_logged_in_user_entity()->name,
		$group->name,
		$group->getURL()
	))));
	$form_body .= "</div>";
	
	$form_body .= "<div class='elgg-footer'>";
	$form_body .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
	
	$content = elgg_view("input/form", array("action" => "action/group_tools/welcome_message", "body" => $form_body));
	
	echo elgg_view_module("info", $title, $content);
}
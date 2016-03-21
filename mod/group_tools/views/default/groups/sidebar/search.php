<?php
/**
 * Search for content in this group
 *
 * @uses vars["entity"] ElggGroup
 */

$group = elgg_extract("entity", $vars);

if (!empty($group) && elgg_instanceof($group, "group")) {
	if ($group->getPrivateSetting("group_tools:cleanup:search") != "yes") {
		$url = elgg_get_site_url() . "search";
		$body = elgg_view_form("groups/search", array(
			"action" => $url,
			"method" => "get",
			"disable_security" => true,
		), $vars);
		
		echo elgg_view_module("aside", elgg_echo("groups:search_in_group"), $body);
	}
}

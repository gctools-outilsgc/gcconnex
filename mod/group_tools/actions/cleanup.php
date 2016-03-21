<?php
/**
 * Cleanup the group sidebar
 */

$group_guid = (int) get_input("group_guid");

$owner_block = get_input("owner_block");
$actions = get_input("actions");
$menu = get_input("menu");
$members = get_input("members");
$search = get_input("search");
$featured = get_input("featured");
$featured_sorting = get_input("featured_sorting");
$my_status = get_input("my_status");

$forward_url = REFERER;

$group = get_entity($group_guid);

if (!empty($group) && ($group instanceof ElggGroup)) {
	if ($group->canEdit()) {
		$prefix = "group_tools:cleanup:";
		
		$group->setPrivateSetting($prefix . "owner_block", $owner_block);
		$group->setPrivateSetting($prefix . "actions", $actions);
		$group->setPrivateSetting($prefix . "menu", $menu);
		$group->setPrivateSetting($prefix . "members", $members);
		$group->setPrivateSetting($prefix . "search", $search);
		$group->setPrivateSetting($prefix . "featured", $featured);
		$group->setPrivateSetting($prefix . "featured_sorting", $featured_sorting);
		$group->setPrivateSetting($prefix . "my_status", $my_status);
		
		
		$forward_url = $group->getURL();
		system_message(elgg_echo("group_tools:actions:cleanup:success"));
	} else {
		register_error(elgg_echo("groups:cantedit"));
	}
} else {
	register_error(elgg_echo("groups:notfound:details"));
}

forward($forward_url);

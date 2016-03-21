<?php
/**
 * Group module to show related groups
 */

$group = elgg_extract("entity", $vars);
if (empty($group) || !elgg_instanceof($group, "group")) {
	return true;
}

if ($group->related_groups_enable != "yes") {
	return true;
}

$all_link = elgg_view("output/url", array(
	"href" => "groups/related/" . $group->getGUID(),
	"text" => elgg_echo("link:view:all"),
	"is_trusted" => true,
));

$dbprefix = elgg_get_config("dbprefix");

$options = array(
	"type" => "group",
	"limit" => 4,
	"relationship" => "related_group",
	"relationship_guid" => $group->getGUID(),
	"full_view" => false,
	"joins" => array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid"),
	"order_by" => "ge.name ASC"
);

elgg_push_context("widgets");
$content = elgg_list_entities_from_relationship($options);
elgg_pop_context();

if (empty($content)) {
	$content = "<div>" . elgg_echo("groups_tools:related_groups:none") . "</div>";
}

echo elgg_view("groups/profile/module", array(
	"title" => elgg_echo("groups_tools:related_groups:widget:title"),
	"content" => $content,
	"all_link" => $all_link,
));

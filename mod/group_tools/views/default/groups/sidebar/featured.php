<?php
/**
 * Featured groups
 *
 * @package ElggGroups
 */

$limit = (int) elgg_extract("limit", $vars, 10);
$sort = elgg_extract("sort", $vars);

$featured_groups_options = array(
	"metadata_name" => "featured_group",
	"metadata_value" => "yes",
	"types" => "group",
	"limit" => $limit,
);

if (!empty($sort) && ($sort == "alphabetical")) {
	$featured_groups_options["joins"] = array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid");
	$featured_groups_options["order_by"] = "ge.name ASC";
}

elgg_push_context("widgets");
$body = "";

$featured_groups = new ElggBatch("elgg_get_entities_from_metadata", $featured_groups_options);
foreach ($featured_groups as $group) {
	$body .= elgg_view_entity($group, array("full_view" => false));
}

elgg_pop_context();

if (!empty($body)) {
	echo elgg_view_module("aside", elgg_echo("groups:featured"), $body);
}

<?php
/**
 * Overrule to group search page
 */

elgg_push_breadcrumb(elgg_echo("groups"), "groups/all");
elgg_push_breadcrumb(elgg_echo("search"));

$db_prefix = elgg_get_config("dbprefix");
$query = sanitise_string(get_input("tag"));

$title = elgg_echo("groups:search:title", array($query));
$content = false;

if (!empty($query)) {
	$params = array(
		"type" => "group",
		"full_view" => FALSE,
	);
	
	// search all profile fields
	$profile_fields = array_keys(elgg_get_config("group"));
	if (!empty($profile_fields)) {
		$params["joins"] = array(
			"JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid",
			"JOIN {$db_prefix}metadata md on e.guid = md.entity_guid",
			"JOIN {$db_prefix}metastrings msv ON md.value_id = msv.id"
		);
	} else {
		$params["joins"] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
	}
	
	$where = "ge.name LIKE '%$query%' OR ge.description LIKE '%$query%'";
	
	if (!empty($profile_fields)) {
		// get the where clauses for the md names
		// can't use egef_metadata() because the n_table join comes too late.
		// 		$clauses = elgg_entities_get_metastrings_options("metadata", array(
		// 				"metadata_names" => $profile_fields,
		// 		));
	
		// 		$params["joins"] = array_merge($clauses["joins"], $params["joins"]);
	
		$tag_name_ids = array();
		foreach ($profile_fields as $field) {
			$tag_name_ids[] = elgg_get_metastring_id($field);
		}
	
		$md_where = "((md.name_id IN (" . implode(",", $tag_name_ids) . ")) AND (msv.string LIKE '%$query%'))";
		$params["wheres"] = array("(($where) OR ($md_where))");
	} else {
		$params["wheres"] = array($where);
	}

	$content = elgg_list_entities($params);
}

if (empty($content)) {
	$content = elgg_echo("groups:search:none");
}

$sidebar = elgg_view("groups/sidebar/find");
$sidebar .= elgg_view("groups/sidebar/featured");

$params = array(
	"content" => $content,
	"sidebar" => $sidebar,
	"filter" => false,
	"title" => $title,
);
$body = elgg_view_layout("content", $params);

echo elgg_view_page($title, $body);

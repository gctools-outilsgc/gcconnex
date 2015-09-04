<?php
/**
 * content of the featured groups widget
 */

$widget = elgg_extract("entity", $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 5;
}

$show_random = $widget->show_random;

$featured_options = array(
	"type" => "group",
	"limit" => $num_display,
	"full_view" => false,
	"pagination" => false,
	"metadata_name_value_pairs" => array("featured_group" => "yes"),
	"order_by" => "RAND()"
);

if ($widget->show_members == "yes") {
	$show_members = true;
} else {
	$show_members = false;
}

if ($show_members) {
	elgg_push_context("widgets_groups_show_members");
}

$featured = elgg_list_entities_from_metadata($featured_options);

if ($show_members) {
	elgg_pop_context();
}

$random = "";
if ($show_random == "yes") {
	$dbprefix = elgg_get_config("dbprefix");
	$featured_id = elgg_get_metastring_id("featured_group");
	$yes_id = elgg_get_metastring_id("yes");
	
	$random_options = array(
		"type" => "group",
		"limit" => 1,
		"order_by" => "RAND()",
		"wheres" => array("NOT EXISTS (
			SELECT 1 FROM {$dbprefix}metadata md
			WHERE md.entity_guid = e.guid
				AND md.name_id = $featured_id
				AND md.value_id = $yes_id)")
	);
	
	if ($random_groups = elgg_get_entities($random_options)) {
		$group = $random_groups[0];
		
		$title = elgg_view("output/url", array("text" => $group->name, "href" => $group->getURL()));
		$icon = elgg_view_entity_icon($group, "large");
		
		$random = elgg_view_module("main", $title, $icon, array("class" => "center"));
	}
}

$list = $featured . $random;
if (empty($list)) {
	$list = elgg_echo("notfound");
}

echo $list;

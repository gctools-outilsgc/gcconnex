<?php
/**
 * content of the index groups widget
 */

$widget = $vars["entity"];

// get widget settings
$count = sanitise_int($widget->group_count, false);
if (empty($count)) {
	$count = 8;
}

$options = array(
	"type" => "group",
	"limit" => $count,
	"full_view" => false,
	"pagination" => false,
	"metadata_name_value_pairs" => array(),
	"metadata_case_sensitive" => false
);

// limit to featured groups?
if ($widget->featured == "yes") {
	$options["metadata_name_value_pairs"][] = array(
		"name" => "featured_group",
		"value" => "yes"
	);
}

// enable advanced filter
$filter_name = $widget->filter_name;
$filter_value = $widget->filter_value;
if (!empty($filter_name) && !empty($filter_value)) {
	$profile_fields = elgg_get_config("group");
	if (!empty($profile_fields)) {
		$found = false;
		
		foreach ($profile_fields as $name => $type) {
			if (($name == $filter_name) && ($type == "tags")) {
				$found = true;
				break;
			}
		}
		
		if ($found) {
			$filter_value = string_to_tag_array($filter_value);
			
			$options["metadata_name_value_pairs"][] = array(
				"name" => $filter_name,
				"value" => $filter_value
			);
		}
	}
}

$sorting_value = $widget->sorting;
if (empty($sorting_value) && ($widget->apply_sorting == "yes")) {
	$sorting_value = "ordered";
}

$getter = "elgg_get_entities_from_metadata";
// check if groups should respect a specific order
switch ($sorting_value) {
	case "ordered":
		$dbprefix = elgg_get_config("dbprefix");
		$order_id = elgg_get_metastring_id("order");
		
		$options["selects"] = array(
			"IFNULL((
				SELECT order_ms.string as order_val
				FROM " . $dbprefix . "metadata mo
				JOIN " . $dbprefix . "metastrings order_ms ON mo.value_id = order_ms.id
				WHERE e.guid = mo.entity_guid
				AND mo.name_id = " . $order_id . "
			), 99999) AS order_val"
		);
			
		$options["order_by"] = "CAST(order_val AS SIGNED) ASC, e.time_created DESC";
		break;
	case "popular":
		$getter = "elgg_get_entities_from_relationship_count";
		
		$options["relationship"] = "member";
		$options["inverse_relationship"] = false;
		break;
	default:
		// just use default time created sorting
		break;
}
	
// show group member count
if ($widget->show_members == "yes") {
	$show_members = true;
	elgg_push_context("widgets_groups_show_members");
} else {
	$show_members = false;
}

// list groups
$groups = elgg_list_entities($options, $getter);
if (!empty($groups)) {
	echo $groups;
} else {
	echo elgg_echo("groups:none");
}

if ($show_members) {
	elgg_pop_context();
}

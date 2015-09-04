<?php
/**
 * Extra tabs for the all groups page
 */

// all groups doesn"t get link to self
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo("groups"));

// only register title button if allowed
if ((elgg_get_plugin_setting("limited_groups", "groups") != "yes") || elgg_is_admin_logged_in()) {
	elgg_register_title_button();
}

$selected_tab = get_input("filter");

// default group options
$group_options = array(
	"type" => "group",
	"full_view" => false,
);

$dbprefix = elgg_get_config("dbprefix");

switch ($selected_tab) {
	case "ordered":
		
		$order_id = elgg_get_metastring_id("order");
		
		$group_options["limit"] = false;
		$group_options["pagination"] = false;
		$group_options["selects"] = array(
			"IFNULL((SELECT order_ms.string as order_val FROM " . $dbprefix . "metadata mo JOIN " . $dbprefix . "metastrings order_ms ON mo.value_id = order_ms.id WHERE e.guid = mo.entity_guid AND mo.name_id = " . $order_id . "), 99999) AS order_val"
		);
		
		$group_options["order_by"] = "CAST(order_val AS SIGNED) ASC, e.time_created DESC";
		
		if (elgg_is_admin_logged_in()) {
			$group_options["list_class"] = "group-tools-list-ordered";
		}
		
		break;
	case "yours":
		elgg_gatekeeper();
		
		$group_options["relationship"] = "member";
		$group_options["relationship_guid"] = elgg_get_logged_in_user_guid();
		$group_options["inverse_relationship"] = false;

		break;
	case "open":
		$group_options["metadata_name_value_pairs"] = array(
			"name" => "membership",
			"value" => ACCESS_PUBLIC
		);
		
		break;
	case "closed":
		$group_options["metadata_name_value_pairs"] = array(
			"name" => "membership",
			"value" => ACCESS_PUBLIC,
			"operand" => "<>"
		);
		
		break;
	case "alpha":
		$group_options["joins"]	= array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid");
		$group_options["order_by"] = "ge.name ASC";
		
		break;
}

if (isset($group_options["relationship"])) {
	$content = elgg_list_entities_from_relationship($group_options);
} else {
	$content = elgg_list_entities_from_metadata($group_options);
}
if (empty($content)) {
	$content = elgg_echo("groups:none");
}

$filter = elgg_view("groups/group_sort_menu", array("selected" => $selected_tab));

$sidebar = elgg_view("groups/sidebar/find");
$sidebar .= elgg_view("groups/sidebar/featured");

$params = array(
	"content" => $content,
	"sidebar" => $sidebar,
	"filter" => $filter,
);

$body = elgg_view_layout("content", $params);

echo elgg_view_page(elgg_echo("groups:all"), $body);
	

<?php

namespace AU\SubGroups;

$display_subgroups = elgg_get_plugin_setting('display_subgroups', PLUGIN_ID);

$db_prefix = elgg_get_config('dbprefix');
// all groups doesn't get link to self
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('groups'));

elgg_register_title_button();

$selected_tab = get_input('filter');

// default group options
$group_options = array(
	"type" => "group",
	"full_view" => false,
);

if ($display_subgroups != 'yes') {
	$group_options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU_SUBGROUPS_RELATIONSHIP . "' )");
}

$group_options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
$group_options['order_by'] = 'ge.name ASC';

switch ($selected_tab) {
	case "open":
		$group_options["metadata_name_value_pairs"] = array(
			"name" => "membership",
			"value" => ACCESS_PUBLIC
		);
		
		$dbprefix = elgg_get_config("dbprefix");

		$group_options["joins"] = array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid");
		$group_options["order_by"] = "ge.name ASC";

		break;
	case "closed":
		$group_options["metadata_name_value_pairs"] = array(
			"name" => "membership",
			"value" => ACCESS_PUBLIC,
			"operand" => "<>"
		);
		
		$dbprefix = elgg_get_config("dbprefix");

		$group_options["joins"] = array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid");
		$group_options["order_by"] = "ge.name ASC";

		break;

	case "alpha":
		$dbprefix = elgg_get_config("dbprefix");

		$group_options["joins"] = array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid");
		$group_options["order_by"] = "ge.name ASC";

		break;
}

if (!($content = elgg_list_entities_from_metadata($group_options))) {
	$content = elgg_echo("groups:none");
}

$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));

$sidebar = elgg_view('groups/sidebar/find');
$sidebar .= elgg_view('groups/sidebar/featured');

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'filter' => $filter,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page(elgg_echo('groups:all'), $body);

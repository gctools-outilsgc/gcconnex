<?php

$limit = (int) get_input("limit", 50);
if ($limit < 1) {
	$limit = 50;
}
$offset = (int) get_input("offset", 0);
if ($offset < 1) {
	$offset = 0;
}

$options = array(
	"type" => "group",
	"full_view" => false,
	"count" => true,
	"limit" => $limit,
	"offset" => $offset,
	"joins" => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
	"order_by" => "ge.name"
);

$group_count = elgg_get_entities($options);
if ($group_count < 1) {
	echo elgg_echo("groups:none");
	return;
}

unset($options["count"]);
$batch = new ElggBatch("elgg_get_entities", $options);

$delete_button = elgg_view("input/submit", array(
	"value" => elgg_echo("group_tools:delete_selected"),
	"class" => "elgg-button-submit float-alt mvs",
	"onclick" => "return confirm(elgg.echo('deleteconfirm:plural'));"
));

$form_data = $delete_button;

$form_data .= "<table class='elgg-table'>";

$form_data .= "<thead>";
$form_data .= "<tr>";
$form_data .= "<th class='center'>" . elgg_view("input/checkbox", array("name" => "checkall", "default" => false)) . "</th>";
$form_data .= "<th>" . elgg_echo("groups:group") . "</th>";
$form_data .= "<th class='center'>" . elgg_echo("groups:edit") . "</th>";
$form_data .= "<th class='center'>" . elgg_echo("groups:delete") . "</th>";
$form_data .= "</tr>";
$form_data .= "</thead>";

$form_data .= "<tbody>";

foreach ($batch as $group) {
	
	// brief view
	$icon = elgg_view_entity_icon($group, "tiny");
	$params = array(
		"entity" => $group,
		"metadata" => "",
		"subtitle" => $group->briefdescription,
	);
	$list_body = elgg_view("group/elements/summary", $params);
	$group_summary = elgg_view_image_block($icon, $list_body);
	
	$form_data .= "<tr>";
	$form_data .= "<td class='center'>" . elgg_view("input/checkbox", array(
		"name" => "group_guids[]",
		"value" => $group->getGUID(),
		"default" => false)) . "</td>";
	$form_data .= "<td>" . $group_summary . "</td>";
	$form_data .= "<td class='center'>" . elgg_view("output/url", array(
		"text" => elgg_view_icon("settings-alt"),
		"title" => elgg_echo("edit"),
		"href" => "groups/edit/" . $group->getGUID())) . "</td>";
	$form_data .= "<td class='center'>" . elgg_view("output/url", array(
		"text" => elgg_view_icon("delete-alt"),
		"title" => elgg_echo("delete"),
		"confirm" => elgg_echo("deleteconfirm"),
		"href" => "action/groups/delete?guid=" . $group->getGUID())) . "</td>";
	$form_data .= "</tr>";
}

$form_data .= "</tbody>";

$form_data .= "</table>";

$form_data .= $delete_button;

// pagination
$form_data .= elgg_view("navigation/pagination", array(
	"limit" => $limit,
	"offset" => $offset,
	"count" => $group_count
));

echo elgg_view("input/form", array(
	"id" => "group-tools-admin-bulk-delete",
	"action" => "action/group_tools/admin/bulk_delete",
	"body" => $form_data
));
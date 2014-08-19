<?php

$widget = $vars["entity"];
$group = $widget->getOwnerEntity();

$count = (int) $widget->wire_count;
$filter = $widget->filter;

$error = false;

if ($count < 1) {
	$count = 5;
}

$options = array(
	"type" => "object",
	"subtype" => "thewire",
	"limit" => $count,
	"container_guid" => $group->getGUID(),
	"pagination" => false,
	"full_view" => false
);

if (!empty($filter)) {
	$filters = string_to_tag_array($filter);
	$filters = array_map("sanitise_string", $filters);

	$options["joins"] = array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON oe.guid = e.guid");
	$options["wheres"] = array("(oe.description LIKE '%" . implode("%' OR oe.description LIKE '%", $filters) . "%')");
}

$list = elgg_list_entities($options);
if (empty($list)) {
	$error = true;
	$list = elgg_echo("thewire_tools:no_result");
}

if ($group->isMember()) {
	echo elgg_view_form("thewire/add");
}

echo $list;

if (empty($error)) {
	echo "<span class=\"elgg-widget-more\">";
	echo elgg_view("output/url", array("href" => "thewire/group/" . $widget->container_guid, "text" => elgg_echo("thewire:moreposts")));
	echo "</span>";
}

<?php

$widget = $vars["entity"];

// get widget settings
$count = (int) $widget->wire_count;
$filter = $widget->filter;

if ($count < 1) {
	$count = 8;
}

$options = array(
	"type" => "object",
	"subtype" => "thewire",
	"limit" => $count,
	"full_view" => false,
	"pagination" => false,
	"view_type_toggle" => false
);

if (!empty($filter)) {
	$filters = string_to_tag_array($filter);
	$filters = array_map("sanitise_string", $filters);
	
	$options["joins"] = array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON oe.guid = e.guid");
	$options["wheres"] = array("(oe.description LIKE '%" . implode("%' OR oe.description LIKE '%", $filters) . "%')");
}

$content = elgg_list_entities($options);
if (!empty($content)) {
	echo $content;
	echo "<span class='elgg-widget-more'>" . elgg_view("output/url", array("href" => "thewire/all","text" => elgg_echo("thewire:moreposts"))) . "</span>";
} else {
	echo elgg_echo("thewire_tools:no_result");
}

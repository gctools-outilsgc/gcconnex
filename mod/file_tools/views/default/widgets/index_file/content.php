<?php

$widget = elgg_extract('entity', $vars);

// get widget settings
$count = (int) $widget->file_count;
if ($count < 1) {
	$count = 8;
}

$files = elgg_list_entities([
	"type" => "object",
	"subtype" => "file",
	"limit" => $count,
	"full_view" => false,
	"pagination" => false,
]);

if (empty($files)) {
	echo elgg_echo("file:none");
	return;
}

echo $files;

echo elgg_format_element('div', ['class' => 'elgg-widget-more'], elgg_view("output/url", [
	"href" => "file/all",
	"text" => elgg_echo("file:more"),
	"is_trusted" => true,
]));

<?php

$widget = elgg_extract('entity', $vars);
$group = $widget->getOwnerEntity();

$number = (int) $widget->file_count;
if ($number < 1) {
	$number = 4;
}

//get the group's files
echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'file',
	'container_guid' => $group->getGUID(),
	'limit' => $number,
	'pagination' => false,
	'full_view' => false,
	'no_results' => elgg_echo('file:none'),
]);

echo elgg_format_element('div', ['class' => 'elgg-widget-more'], elgg_view('output/url', [
	'href' => "file/add/{$group->getGUID()}",
	'text' => elgg_echo('file:add'),
	'is_trusted' => true,
]));

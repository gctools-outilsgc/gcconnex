<?php

$widget = elgg_extract('entity', $vars);

// number of files to display
$num_display = sanitise_int($widget->num_display, false);
if (empty($num_display)) {
	$num_display = 4;
}

// show only featured files
$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

// listing options
$listing_options = [
	1 => elgg_echo('file:list'),
	2 => elgg_echo('file:gallery'),
];

echo elgg_view_input('select', [
	'label' => elgg_echo('file:num_files'),
	'name' => 'params[num_display]',
	'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20],
	'value' => $num_display,
]);

echo elgg_view_input('select', [
	'label' => elgg_echo('widget:file:edit:show_only_featured'),
	'name' => 'params[featured_only]',
	'options_values' => $noyes_options,
	'value' => $widget->featured_only,
]);

echo elgg_view_input('select', [
	'label' => elgg_echo('file:gallery_list'),
	'name' => 'params[gallery_list]',
	'options_values' => $listing_options,
	'value' => $widget->gallery_list,
]);

<?php

if (!file_tools_use_folder_structure()) {
	return;
}

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}
	
// build form
$sort_value = 'e.time_created';
if ($group->file_tools_sort) {
	$sort_value = $group->file_tools_sort;
} elseif ($site_sort_default = elgg_get_plugin_setting('sort', 'file_tools')) {
	$sort_value = $site_sort_default;
}

$form_body = '<div>';
$form_body .= elgg_echo('file_tools:settings:sort:default');
$form_body .= '&nbsp;' . elgg_view('input/select', [
	'name' => 'sort',
	'value' => $sort_value,
	'options_values' => [
		'e.time_created' => elgg_echo('file_tools:list:sort:time_created'),
		'oe.title' => elgg_echo('title'),
		'oe.description' => elgg_echo('description'),
		'simpletype' => elgg_echo('file_tools:list:sort:type'),
	],
]);

$sort_direction_value = 'asc';
if ($group->file_tools_sort_direction) {
	$sort_direction_value = $group->file_tools_sort_direction;
} elseif ($site_direction_sort_default = elgg_get_plugin_setting('sort_direction', 'file_tools')) {
	$sort_direction_value = $site_direction_sort_default;
}

$form_body .= '&nbsp;' . elgg_view('input/select', [
	'name' => 'sort_direction',
	'value' => $sort_direction_value,
	'options_values' => [
		'asc' => elgg_echo('file_tools:list:sort:asc'),
		'desc' => elgg_echo('file_tools:list:sort:desc'),
	],
]);
$form_body .= '</div>';

$form_body .= '<div class="elgg-foot">';
$form_body .= elgg_view('input/hidden', ['name' => 'guid', 'value' => $group->getGUID()]);
$form_body .= elgg_view('input/submit', ['value' => elgg_echo('save')]);
$form_body .= '</div>';

$title = elgg_echo('file_tools:settings:sort:default');
$body = elgg_view('input/form', [
	'action' => 'action/file_tools/groups/save_sort',
	'body' => $form_body,
]);

echo elgg_view_module('info', $title, $body);

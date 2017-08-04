<?php
	
// get plugin
$plugin = elgg_extract('entity', $vars);

// make default options
$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

// Default time view
$time_notation_options = [
	'date' => elgg_echo('file_tools:usersettings:time:date'),
	'days' => elgg_echo('file_tools:usersettings:time:days'),
];
	
// sorting
$sort_options = [
	'e.time_created' => elgg_echo('file_tools:list:sort:time_created'),
	'oe.title' => elgg_echo('title'),
	'oe.description' => elgg_echo('description'),
	'simpletype' => elgg_echo('file_tools:list:sort:type'),
];
	
$sort_direction = [
	'asc' => elgg_echo('file_tools:list:sort:asc'),
	'desc' => elgg_echo('file_tools:list:sort:desc'),
];

$list_length = (int) $plugin->list_length;
if ($list_length == 0) {
	$list_length = 50;
}
$list_length_options = [
	-1 => elgg_echo('file_tools:settings:list_length:unlimited'),
];
$list_length_options += array_combine(range(10, 200, 10), range(10, 200, 10));

// get settings
$allowed_extensions = file_tools_allowed_extensions();

// Allowed extensions
echo elgg_view_input('text', [
	'label' => elgg_echo('file_tools:settings:allowed_extensions'),
	'help' => elgg_echo('file_tools:settings:allowed_extensions:help'),
	'name' => 'params[allowed_extensions]',
	'value' => implode(',', $allowed_extensions),
]);

// Use folder structure
echo elgg_view_input('select', [
	'label' => elgg_echo('file_tools:settings:user_folder_structure'),
	'name' => 'params[user_folder_structure]',
	'value' => $plugin->user_folder_structure,
	'options_values' => $noyes_options,
]);

// default time notation
echo elgg_view_input('select', [
	'label' => elgg_echo('file_tools:usersettings:time:default'),
	'name' => 'params[file_tools_default_time_display]',
	'options_values' => $time_notation_options,
	'value' => $plugin->file_tools_default_time_display,
]);

// default sorting options
echo '<div>';
echo '<label>' . elgg_echo('file_tools:settings:sort:default') . '</label>';
echo '&nbsp;' . elgg_view('input/select', [
	'name' => 'params[sort]',
	'value' => $plugin->sort,
	'options_values' => $sort_options,
]);
echo '&nbsp;';
echo elgg_view('input/select', [
	'name' => 'params[sort_direction]',
	'value' => $plugin->sort_direction,
	'options_values' => $sort_direction,
]);
echo '</div>';

// limit folder listing
echo elgg_view_input('select', [
	'label' => elgg_echo('file_tools:settings:list_length'),
	'name' => 'params[list_length]',
	'value' => $list_length,
	'options_values' => $list_length_options,
]);

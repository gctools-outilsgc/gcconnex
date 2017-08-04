<?php

$plugin = elgg_extract('entity', $vars);

$options = [
	'date' => elgg_echo('file_tools:usersettings:time:date'),
	'days' => elgg_echo('file_tools:usersettings:time:days'),
];

$file_tools_time_display_value = $plugin->getUserSetting('file_tools_time_display', elgg_get_page_owner_guid());
if (empty($file_tools_time_display_value)) {
	$file_tools_time_display_value = elgg_get_plugin_setting('file_tools_default_time_display', 'file_tools');
}

echo elgg_view('output/longtext', [
	'value' => elgg_echo('file_tools:usersettings:time:description'),
]);

echo elgg_view_input('select', [
	'label' => elgg_echo('file_tools:usersettings:time'),
	'name' => 'params[file_tools_time_display]',
	'options_values' => $options,
	'value' => $file_tools_time_display_value,
]);

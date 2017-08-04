<?php

$folder_guid = (int) get_input('folder_guid');

$container_guid = elgg_extract('container_guid', $vars, elgg_get_page_owner_guid());
$current_folder	= (int) elgg_extract('folder', $vars, $folder_guid);
$type = elgg_extract('type', $vars);

unset($vars['folder']);
unset($vars['type']);
unset($vars['container_guid']);

$default_value = $current_folder;
if ($type == 'folder') {
	if (!empty($current_folder)) {
		$default_value = get_entity($current_folder)->parent_guid;
	}
}

$vars['value'] = elgg_extract('value', $vars, $default_value);

$folders = file_tools_get_folders($container_guid);
$options = [
	0 => elgg_echo('file_tools:input:folder_select:main')
];

if (!empty($folders)) {
	$options = $options + file_tools_build_select_options($folders, 1);
}

$vars['options_values'] = $options;

echo elgg_view('input/select', $vars);

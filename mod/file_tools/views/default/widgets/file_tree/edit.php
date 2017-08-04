<?php

$widget = elgg_extract('entity', $vars);

$folders = file_tools_get_folders($widget->owner_guid);
if (empty($folders)) {
	return;
}

$selected_folders = $widget->folder_guids;
if (!empty($selected_folders) && !is_array($selected_folders)) {
	$selected_folders = [$selected_folders];
} elseif (empty($selected_folders)) {
	$selected_folders = [];
}

// select folder(s) to display
echo elgg_echo('widgets:file_tree:edit:select');
echo '<div>';
echo elgg_view('input/hidden', [
	'name' => 'params[folder_guids][]',
	'value' => '',
]); // needed to be able to empty the list
echo file_tools_build_widget_options($folders, 'params[folder_guids][]', $selected_folders);
echo '</div>';

// display folder or folder content
echo elgg_view_input('checkbox', [
	'label' => elgg_echo('widgets:file_tree:edit:show_content'),
	'help' => elgg_echo('widgets:file_tree:edit:show_content:help'),
	'name' => 'params[show_content]',
	'value' => '1',
	'checked' => !empty($widget->show_content),
]);

// allow content to be ajax loaded
echo elgg_view_input('checkbox', [
	'label' => elgg_echo('widgets:file_tree:edit:toggle_contents'),
	'help' => elgg_echo('widgets:file_tree:edit:toggle_contents:help'),
	'name' => 'params[toggle_contents]',
	'value' => '1',
	'checked' => !empty($widget->toggle_contents),
]);

<?php

$folder = elgg_extract('entity', $vars);

echo elgg_format_element('div', [
	'id' => 'file_tools_breadcrumbs',
	'class' => 'clearfix',
], elgg_view_menu('file_tools_folder_breadcrumb', [
	'entity' => $folder,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]));

if ($folder) {
	echo elgg_view_entity($folder);
}

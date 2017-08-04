<?php

$folders = elgg_extract('folders', $vars);
$folder = elgg_extract('folder', $vars);

$selected_id = 'file_tools_list_tree_main';
if ($folder instanceof ElggObject) {
	$selected_id = $folder->getGUID();
}

$page_owner = elgg_get_page_owner_entity();
$site_url = elgg_get_site_url();

// load JS
elgg_load_css('jstree');
elgg_require_js('file_tools/tree');

$body = elgg_format_element('div', [
	'id' => 'file-tools-folder-tree',
	'class' => ['clearfix', 'hidden'],
], elgg_view_menu('file_tools_folder_sidebar_tree', [
	'container' => $page_owner,
	'sort_by' => 'priority',
]));

$user_guid = elgg_get_logged_in_user_guid();

if ($page_owner->canWriteToContainer($user_guid, 'object', FILE_TOOLS_SUBTYPE)) {
	$body .= elgg_format_element('div', ['class' => 'mtm'], elgg_view('input/button', [
		'value' => elgg_echo('file_tools:new:title'),
		'id' => 'file_tools_list_new_folder_toggle',
		'class' => 'elgg-button-action',
	]));
}

// output file tree
echo elgg_view_module('aside', '', $body, ['id' => 'file_tools_list_tree_container']);

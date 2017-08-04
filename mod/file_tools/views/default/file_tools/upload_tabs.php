<?php

$selected_tab = elgg_extract('upload_type', $vars, 'single');
$page_owner_guid = elgg_get_page_owner_guid();

$tabs = [];
$tabs[] = [
	'text' => elgg_echo('file_tools:upload:tabs:single'),
	'href' => 'file/add/' . $page_owner_guid,
	'link_id' => 'file-tools-single-form-link',
	'selected' => ($selected_tab == 'single') ? true : false,
];
$tabs[] = [
	'text' => elgg_echo('file_tools:upload:tabs:zip'),
	'href' => 'file/add/' . $page_owner_guid . '?upload_type=zip',
	'link_id' => 'file-tools-zip-form-link',
	'selected' => ($selected_tab == 'zip') ? true : false,
];

echo elgg_view('navigation/tabs', [
	'tabs' => $tabs,
	'id' => 'file-tools-upload-tabs',
]);

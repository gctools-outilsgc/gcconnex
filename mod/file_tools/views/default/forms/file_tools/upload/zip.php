<?php

$page_owner = elgg_get_page_owner_entity();

echo elgg_view('output/longtext', [
	'value' => elgg_echo('file_tools:upload:form:zip:info'),
]);


// Get post_max_size and upload_max_filesize
$post_max_size = elgg_get_ini_setting_in_bytes('post_max_size');
$upload_max_filesize = elgg_get_ini_setting_in_bytes('upload_max_filesize');

// Determine the correct value
$max_upload = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;

$upload_limit = elgg_echo('file:upload_limit', array(elgg_format_bytes($max_upload)));

echo elgg_view_input('file', [
	'label' => elgg_echo('file_tools:upload:form:choose'),
	'help' => $upload_limit,
	'name' => 'zip_file',
]);

if (file_tools_use_folder_structure()) {
	echo elgg_view_input('folder_select', [
		'label' => elgg_echo('file_tools:forms:edit:parent'),
		'name' => 'parent_guid',
		'container_guid' => $page_owner->getGUID(),
	]);
}

echo elgg_view_input('access', [
	'label' => elgg_echo('access'),
	'name' => 'access_id',
]);

echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', ['name' => 'container_guid', 'value' => $page_owner->getGUID()]);
echo elgg_view('input/submit', ['value' => elgg_echo('upload')]);
echo '</div>';

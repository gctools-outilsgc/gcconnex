<?php

elgg_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner)) {
	forward();
}

// build breadcrumb
elgg_push_breadcrumb(elgg_echo('file'), 'file/all');
if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb($page_owner->name, 'file/group/' . $page_owner->getGUID() . '/all');
} else {
	elgg_push_breadcrumb($page_owner->name, 'file/owner/' . $page_owner->username);
}
elgg_push_breadcrumb(elgg_echo('file:upload'));

elgg_require_js('file_tools/site');

// get data
$upload_type = get_input('upload_type', 'single');

// build page elements
$title_text = elgg_echo('file:upload');

// body
$form_vars = [
	'enctype' => 'multipart/form-data',
	'class' => 'hidden',
];
$body_vars = [];

$zip_vars = $form_vars;
$zip_vars['id'] = 'file-tools-zip-form';

$single_vars = $form_vars;
$single_vars['id'] = 'file-tools-single-form';

switch ($upload_type) {
	case 'zip':
		unset($zip_vars['class']);
		
		break;
	default:
		elgg_load_library('elgg:file');
		
		$body_vars = file_prepare_form_vars();
		
		unset($single_vars['class']);
		break;
}

// build different forms
$body = '<div id="file-tools-upload-wrapper">';
$body .= elgg_view_form('file/upload', $single_vars, $body_vars);
$body .= elgg_view_form('file_tools/upload/zip', $zip_vars);
$body .= '</div>';

$tabs = elgg_view('file_tools/upload_tabs', ['upload_type' => $upload_type]);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $body,
	'filter' => $tabs,
]);

// draw page
echo elgg_view_page($title_text, $page_data);

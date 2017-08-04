<?php

elgg_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (!($page_owner instanceof ElggUser) && !($page_owner instanceof ElggGroup)) {
	forward(REFERER);
}

// set page owner & context
elgg_set_context('file');

// get data
// build page elements
$title_text = elgg_echo('file_tools:new:title');

$form_vars = [
	'id' => 'file_tools_edit_form',
];
$body_vars = [
	'page_owner_entity' => $page_owner
];

$form = elgg_view_form('file_tools/folder/edit', $form_vars, $body_vars);

// draw page
if (elgg_is_xhr()) {
	
	$title = elgg_view_title($title_text);
	
	echo elgg_format_element('div', [
		'style' => 'width: 550px; height:550px;',
	], $title . $form);
	
	return;
}

// build page
$page_data = elgg_view_layout('one_sidebar', [
	'title' => $title_text,
	'content' => $form,
]);

// draw page
echo elgg_view_page($title_text, $page_data);

<?php

elgg_gatekeeper();

$folder_guid = get_input("folder_guid");
elgg_entity_gatekeeper($folder_guid, "object", FILE_TOOLS_SUBTYPE);

$folder = get_entity($folder_guid);
if (!$folder->canEdit()) {
	register_error(elgg_echo("limited_access"));
	forward(REFERER);
}
		
// set context and page_owner
elgg_set_context("file");
elgg_set_page_owner_guid($folder->getContainerGUID());

// build page elements
$title_text = elgg_echo("file_tools:edit:title");

$form_vars = array(
	"id" => "file_tools_edit_form"
);
$body_vars = array(
	"folder" => $folder,
	"page_owner_entity" => elgg_get_page_owner_entity()
);

$edit = elgg_view_form("file_tools/folder/edit", $form_vars, $body_vars);

// build page
$body = elgg_view_layout("one_sidebar", array(
	"title" => $title_text,
	"content" => $edit
));

echo elgg_view_page($title_text, $body);

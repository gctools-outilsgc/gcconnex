<?php

$folder = elgg_extract("folder", $vars);
$page_owner = elgg_extract("page_owner_entity", $vars);

$form_data = "";
if (!empty($folder)) {
	$title = $folder->title;
	$desc = $folder->description;

	if (!empty($folder->parent_guid)) {
		$parent = $folder->parent_guid;
	} else {
		$parent = 0;
	}

	$access_id = $folder->access_id;

	$form_data = elgg_view("input/hidden", array("name" => "guid", "value" => $folder->getGUID()));

	$submit_text = elgg_echo("update");
} else {
	$title = "";
	$desc = "";

	$parent = get_input("folder_guid", 0);

	if (!empty($parent) && ($parent_entity = get_entity($parent))) {
		$access_id = $parent_entity->access_id;
	} else {
		if ($page_owner instanceof ElggGroup) {
			$access_id = $page_owner->group_acl;
		} else {
			$access_id = ACCESS_DEFAULT;
		}
	}

	$submit_text = elgg_echo("save");
}

$form_data .= elgg_view("input/hidden", array("name" => "page_owner", "value" => $page_owner->getGUID()));

$form_data .= "<div>";
$form_data .= "<label for='title'>" . elgg_echo("file_tools:forms:edit:title") . "</label>";
$form_data .= elgg_view("input/text", array("name" => "title", "id" => "title", "value" => $title));
$form_data .= "</div>";

$form_data .= "<div>";
$form_data .= "<label for='description'>" . elgg_echo("file_tools:forms:edit:description") . "</label>";
$form_data .= elgg_view("input/longtext", array("name" => "description", "id" => "description", "value" => $desc));
$form_data .= "</div>";

$form_data .= "<div>";
$form_data .= "<label for='file_tools_parent_guid'>" . elgg_echo("file_tools:forms:edit:parent") . "</label>";
$form_data .= "<br />";
if (!empty($folder)) {
$form_data .= elgg_view("input/folder_select_move", array("name" => "file_tools_parent_guid", "id" => "file_tools_parent_guid", "folder" => $folder, "value" => $parent, "container_guid" => $page_owner->getGUID(), 'type' => 'folder'));
} else {
    $form_data .= elgg_view("input/folder_select", array("name" => "file_tools_parent_guid", "id" => "file_tools_parent_guid", "folder" => $folder, "value" => $parent, "container_guid" => $page_owner->getGUID(), 'type' => 'folder'));
}
$form_data .= "</div>";

// set context to influence access
$context = elgg_get_context();
elgg_set_context("file_tools");

$form_data .= "<div>";
$form_data .= "<label for='access_id'>" . elgg_echo("access") . "</label>";
$form_data .= "<br />";
$form_data .= elgg_view("input/access", array("name" => "access_id", "id" => "access_id", "value" => $access_id));
$form_data .= "</div>";

// restore context
elgg_set_context($context);

if (!empty($folder)) {
	$form_data .= "<div id='file_tools_edit_form_access_extra'>";
	$form_data .= "<div>" . elgg_view("input/checkboxes", array("options" => array(elgg_echo("file_tools:forms:edit:change_children_access") => "yes"), "value" => "yes", "name" => "change_children_access")) . "</div>";
	$form_data .= "<div>" . elgg_view("input/checkboxes", array("options" => array(elgg_echo("file_tools:forms:edit:change_files_access") => "yes"), "name" => "change_files_access")) . "</div>";
	$form_data .= "</div>";
}

$form_data .= "<div class='elgg-foot'>";
$form_data .= elgg_view("input/submit", array("value" => $submit_text));
$form_data .= "</div>";

echo $form_data;

elgg_unregister_menu_item('title2', 'new_folder');

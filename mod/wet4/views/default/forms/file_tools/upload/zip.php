<?php

$page_owner = elgg_get_page_owner_entity();

$form_body = "<div>" . elgg_echo("file_tools:upload:form:zip:info") . "</div>";

$form_body .= "<div>";
$form_body .= "<label for='zip_file'>" . elgg_echo("file_tools:upload:form:choose") . "</label><br />";
$form_body .= elgg_view("input/file", array("name" => "zip_file", "id" => "zip_file"));
$form_body .= "</div>";

if (file_tools_use_folder_structure()) {
	$form_body .= "<div>";
	$form_body .= "<label for='parent_guid'>" . elgg_echo("file_tools:forms:edit:parent") . "</label><br />";
	$form_body .= elgg_view("input/folder_select", array("name" => "parent_guid", "id" => "parent_guid", "container_guid" => $page_owner->getGUID()));
	$form_body .= "</div>";
}

$form_body .= "<div>";
$form_body .= "<label for='access_id2'>" . elgg_echo("access") . "</label><br />";
$form_body .= elgg_view("input/access", array("name" => "access_id", "id" => "access_id2"));
$form_body .= "</div>";

$form_body .= "<div class='elgg-foot'>";
$form_body .= elgg_view("input/hidden", array("name" => "container_guid", "value" => $page_owner->getGUID()));
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("upload"), 'class' => 'btn btn-primary mrgn-tp-md'));
$form_body .= "</div>";

echo $form_body;

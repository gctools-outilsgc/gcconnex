<?php

$page_owner = elgg_get_page_owner_entity();

$form_body = "<div class='mbm'>";
$form_body .= "<label>" . elgg_echo("file_tools:upload:form:googledoc:info") . "</label>";
$form_body .= elgg_view("input/text", array("name" => "googledoc_url"));
$form_body .= "</div>";

$form_body .= "<div class='mbm'>";
$form_body .= "<label>" . elgg_echo("tags") . "</label>";
$form_body .= elgg_view("input/tags", array('name' => 'tags'));
$form_body .= "</div>";

if (file_tools_use_folder_structure()) {
	$form_body .= "<div class='mbm'>";
	$form_body .= "<label>" . elgg_echo("file_tools:forms:edit:parent") . "</label>";
	$form_body .= elgg_view("input/folder_select", array("name" => "parent_guid", "container_guid" => $page_owner->getGUID()));
	$form_body .= "</div>";
}

$form_body .= "<div class='mbm'>";
$form_body .= "<label>" . elgg_echo("access") . "</label>";
$form_body .= elgg_view("input/access", array("name" => "access_id"));
$form_body .= "</div>";

$form_body .= "<div class='elgg-foot'>";
$form_body .= elgg_view("input/hidden", array("name" => "container_guid", "value" => $page_owner->getGUID()));
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("upload")));
$form_body .= "</div>";

echo $form_body;

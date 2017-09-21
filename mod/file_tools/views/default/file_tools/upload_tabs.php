<?php

	
$selected_tab = elgg_extract("upload_type", $vars, "single");
$page_owner_guid = elgg_get_page_owner_guid();

$tabs = array();
$tabs[] = array(
	"text" => elgg_echo("file_tools:upload:tabs:single"),
	"href" => "file/add/" . $page_owner_guid,
	"link_id" => "file-tools-single-form-link",
	"selected" => ($selected_tab == "single") ? true : false
);
$tabs[] = array(
	"text" => elgg_echo("file_tools:upload:tabs:multi"),
	"href" => "file/add/" . $page_owner_guid . "?upload_type=multi",
	"link_id" => "file-tools-multi-form-link",
	"selected" => ($selected_tab == "multi") ? true : false
);
$tabs[] = array(
	"text" => elgg_echo("file_tools:upload:tabs:zip"),
	"href" => "file/add/" . $page_owner_guid . "?upload_type=zip",
	"link_id" => "file-tools-zip-form-link",
	"selected" => ($selected_tab == "zip") ? true : false
);

if( elgg_get_plugin_setting('googledoc', 'file_tools') ){
	$tabs[] = array(
		"text" => elgg_echo("file_tools:upload:tabs:googledoc"),
		"href" => "file/add/" . $page_owner_guid . "?upload_type=googledoc",
		"link_id" => "file-tools-googledoc-form-link",
		"selected" => ($selected_tab == "googledoc") ? true : false
	);
}

echo elgg_view("navigation/tabs", array("tabs" => $tabs, "id" => "file-tools-upload-tabs"));
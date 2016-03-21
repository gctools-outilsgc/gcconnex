<?php

elgg_register_menu_item('file_options', array(
    'name' => 'single',
	"text" => elgg_echo("file_tools:upload:tabs:single"),
	//"href" => "file/add/" . $page_owner_guid,
	"href" => "#single",
	"link_id" => "file-tools-single-form-link",
	"selected" => ($selected_tab == "single") ? true : false,
    'data-toggle' => 'tab',
    'item_class' => 'active',
    'priority' => 0,
));
elgg_register_menu_item('file_options', array(
    'name' => 'multi',
	"text" => elgg_echo("file_tools:upload:tabs:multi"),
	//"href" => "file/add/" . $page_owner_guid . "?upload_type=multi",
	"href" => "#multi",
	"link_id" => "file-tools-multi-form-link",
	"selected" => ($selected_tab == "multi") ? true : false,
    'data-toggle' => 'tab',
    'priority' => 1,
));
elgg_register_menu_item('file_options', array(
    'name' => 'zip',
	"text" => elgg_echo("file_tools:upload:tabs:zip"),
	//"href" => "file/add/" . $page_owner_guid . "?upload_type=zip",
	"href" => "#zip",
	"link_id" => "file-tools-zip-form-link",
	"selected" => ($selected_tab == "zip") ? true : false,
    'data-toggle' => 'tab',
    'priority' => 2,
));

echo elgg_view_menu('file_options', array('class' => 'nav nav-tabs', 'sort_by' => 'priority'));
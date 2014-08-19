<?php

	$page_owner = elgg_get_page_owner_entity();
	
	// show sorting options
	$title = elgg_echo('file_tools:list:files:options:sort_title');
	
	// sort options
	$sort_value = 'e.time_created';
	if(isset($_SESSION["file_tools"]) && is_array($_SESSION["file_tools"]) && !empty($_SESSION["file_tools"]["sort"])){
		$sort_value = $_SESSION["file_tools"]["sort"];
	} else {
		if(elgg_instanceof($page_owner, "group") && !empty($page_owner->file_tools_sort)){
			$sort_value = $page_owner->file_tools_sort;
		} elseif($site_sort_default = elgg_get_plugin_setting("sort", "file_tools")){
			$sort_value = $site_sort_default;
		}
	}
	
	$body = elgg_view('input/dropdown', array('name' => 'file_sort',
													'value' => $sort_value,
													'options_values' => array(
																		'oe.title' 			=> elgg_echo('title'), 
																		'oe.description'	=> elgg_echo('description'), 
																		'e.time_created' 	=> elgg_echo('file_tools:list:sort:time_created'), 
																		'simpletype' 		=> elgg_echo('file_tools:list:sort:type'))));
	
	// sort direction
	$sort_direction_value = 'asc';
	if(isset($_SESSION["file_tools"]) && is_array($_SESSION["file_tools"]) && !empty($_SESSION["file_tools"]["sort_direction"])){
		$sort_direction_value = $_SESSION["file_tools"]["sort_direction"];
	} else {
		if(elgg_instanceof($page_owner, "group") && !empty($page_owner->file_tools_sort_direction)){
			$sort_direction_value = $page_owner->file_tools_sort_direction;
		} elseif($site_sort_direction_default = elgg_get_plugin_setting("sort_direction", "file_tools")){
			$sort_direction_value = $site_sort_direction_default;
		}
	}
	
	$body .= "<br />";
	$body .= elgg_view('input/dropdown', array('name' => 'file_sort_direction',
												'value' => $sort_direction_value,
													'options_values' => array(
																		'asc' 	=> elgg_echo('file_tools:list:sort:asc'), 
																		'desc'	=> elgg_echo('file_tools:list:sort:desc'))));
	// output sorting module
	//echo elgg_view_module("aside", $title, $body, array("id" => "file_tools_list_files_sort_options"));
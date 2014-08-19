<?php 
	
	// get plugin
	$settings = $vars["entity"];
	
	// make default options
	$noyes_options = array(
		"no" 	=> elgg_echo("option:no"),
		"yes" 	=> elgg_echo("option:yes")
	);
	
	// Default time view
	$time_notation_options = array(
		"date" 	=> elgg_echo("file_tools:usersettings:time:date"),
		"days" 	=> elgg_echo("file_tools:usersettings:time:days")
	);
		
	// sorting
	$sort_options =  array(
		"e.time_created" 	=> elgg_echo("file_tools:list:sort:time_created"),
		"oe.title" 			=> elgg_echo("title"), 
		"oe.description"	=> elgg_echo("description"),
		"simpletype" 		=> elgg_echo("file_tools:list:sort:type")
	);
		
	$sort_direction = array(
		"asc" 	=> elgg_echo("file_tools:list:sort:asc"),
		"desc"	=> elgg_echo("file_tools:list:sort:desc")
	);
	
	// get settings
	$allowed_extensions = file_tools_allowed_extensions();
	
	// Allowed extensions
	echo "<div>";
	echo "<label>" . elgg_echo("file_tools:settings:allowed_extensions") . "</label>";
	echo elgg_view("input/tags", array("name" => "params[allowed_extensions]", "value" => $allowed_extensions));
	echo "</div>";
	
	// Use folder structure
	echo "<div>";
	echo "<label>" . elgg_echo("file_tools:settings:user_folder_structure") . "</label>";
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[user_folder_structure]", "value" => $settings->user_folder_structure, "options_values" => $noyes_options));
	echo "</div>";
	
	// default time notation
	echo "<div>";
	echo "<label>" . elgg_echo("file_tools:usersettings:time:default") . "</label>";
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[file_tools_default_time_display]", "options_values" => $time_notation_options, "value" => $settings->file_tools_default_time_display));
	echo "</div>";
	
	// default sorting options
	echo "<div>";
	echo "<label>" . elgg_echo("file_tools:settings:sort:default") . "</label>";
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[sort]", "value" =>  $settings->sort, "options_values" => $sort_options));
	echo "&nbsp;";
	echo elgg_view("input/dropdown", array("name" => "params[sort_direction]", "value" =>  $settings->sort_direction, "options_values" => $sort_direction));
	echo "</div>"; 
	
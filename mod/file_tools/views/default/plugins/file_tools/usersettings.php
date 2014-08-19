<?php
	$plugin = $vars["entity"];
	
	$options = array(
		"date" => elgg_echo("file_tools:usersettings:time:date"),
		"days" => elgg_echo("file_tools:usersettings:time:days")
	);
	
	$file_tools_time_display_value = $plugin->getUserSetting("file_tools_time_display", elgg_get_page_owner_guid());
	if(empty($file_tools_time_display_value)) {
		$file_tools_time_display_value = elgg_get_plugin_setting("file_tools_default_time_display", "file_tools");
	}

	echo "<div>";
	echo elgg_echo("file_tools:usersettings:time:description");
	echo "</div>";
	
	echo "<div>";
	echo elgg_echo("file_tools:usersettings:time");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[file_tools_time_display]", "options_values" => $options, "value" => $file_tools_time_display_value));
	echo "</div>";
	
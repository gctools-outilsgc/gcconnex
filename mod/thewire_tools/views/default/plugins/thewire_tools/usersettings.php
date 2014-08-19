<?php 

	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	echo "<div>";
	echo elgg_echo("thewire_tools:usersettings:notify_mention");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[notify_mention]", "options_values" => $noyes_options, "value" => $plugin->getUserSetting("notify_mention")));
	echo "</div>";

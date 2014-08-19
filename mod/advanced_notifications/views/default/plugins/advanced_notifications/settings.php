<?php

	$plugin = elgg_extract("entity", $vars);
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	echo "<div>";
	echo elgg_echo("advanced_notifications:settings:replace_site_notifications");
	echo elgg_view("input/dropdown", array("name" => "params[replace_site_notifications]", "options_values" => $noyes_options, "value" => $plugin->replace_site_notifications, "class" => "mls"));
	echo "</div>";

	echo "<div>";
	echo elgg_echo("advanced_notifications:settings:no_mail_content");
	echo elgg_view("input/dropdown", array("name" => "params[no_mail_content]", "options_values" => $noyes_options, "value" => $plugin->no_mail_content, "class" => "mls"));
	echo "</div>";
	
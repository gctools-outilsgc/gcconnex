<?php 

	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);

	$site_email = elgg_get_site_entity()->email;
	
	// present settings
	echo "<div>";
	echo elgg_echo("html_email_handler:settings:notifications:description");
	echo "</div>";
	
	echo "<div>";
	echo elgg_echo("html_email_handler:settings:notifications");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[notifications]", "options_values" => $noyes_options, "value" => $plugin->notifications));
	echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:notifications:subtext") . "</div>";
	echo "</div>";
	 
	echo "<div>";
	echo elgg_echo("html_email_handler:settings:sendmail_options");
	echo elgg_view("input/text", array("name" => "params[sendmail_options]", "value" => $plugin->sendmail_options));
	echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:sendmail_options:description", array($site_email)) . "</div>";
	echo "</div>";
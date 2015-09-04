<?php
/**
 * widget settings for the discussions widget
 */
$widget = $vars["entity"];

$discussion_count = sanitise_int($widget->discussion_count, false);
if (empty($discussion_count)) {
	$discussion_count = 5;
}

if (elgg_in_context("dashboard")) {
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	echo "<div>";
	echo elgg_echo("widgets:discussion:settings:group_only");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[group_only]", "value" => $widget->group_only, "options_values" => $noyes_options));
	echo "</div>";
	
}

echo "<div>";
echo elgg_echo("widget:numbertodisplay");
echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[discussion_count]", "value" => $discussion_count, "options" => range(1, 10)));
echo "</div>";

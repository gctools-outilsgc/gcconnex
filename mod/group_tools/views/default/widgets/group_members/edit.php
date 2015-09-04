<?php
/**
 * settings for the group members widget
 */
$widget = $vars["entity"];

$count = (int) $widget->num_display;
if ($count < 1) {
	$count = 5;
}

echo "<div>";
echo elgg_echo("widget:numbertodisplay");
echo elgg_view("input/text", array("name" => "params[num_display]", "value" => $count, "size" => "4", "maxlength" => "3"));
echo "</div>";

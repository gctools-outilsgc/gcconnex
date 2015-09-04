<?php
/**
 * settings for the discussions widget
 */

$topic_count = sanitise_int($vars["entity"]->topic_count, false);
if (empty($topic_count)) {
	$topic_count = 4;
}

echo "<div>";
echo elgg_echo("widget:numbertodisplay");
echo elgg_view("input/dropdown", array("name" => "params[topic_count]", "options" => range(1, 10), "value" => $topic_count));
echo "</div>";

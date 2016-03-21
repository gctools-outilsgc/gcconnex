<?php

$widget = $vars["entity"];

$like_type = $widget->like_type;
$interval = $widget->interval;
if (empty($interval)) {
	$interval = 0;
}

$limit = $widget->limit;
if (empty($limit)) {
	$limit = 10;
}

$intervals = array(
	"7" => elgg_echo("widgets:likes:settings:interval:week"),
	"30" => elgg_echo("widgets:likes:settings:interval:month"),
	"90" => elgg_echo("widgets:likes:settings:interval:3month"),
	"180" => elgg_echo("widgets:likes:settings:interval:halfyear"),
	"365" => elgg_echo("widgets:likes:settings:interval:year"),
	"0" => elgg_echo("widgets:likes:settings:interval:unlimited")
);

$like_types = array();

// things i like; shows things user liked (only on dashboard / profile)
if (elgg_in_context("dashboard") || elgg_in_context("profile")) {
	$like_types["user_likes"] = elgg_echo("widgets:likes:settings:like_type:user_likes");
}

// most liked items; shows most liked items owned by user, or in group, or on site (so all contexts)
$like_types["most_liked"] = elgg_echo("widgets:likes:settings:like_type:most_liked");

// recently liked; shows recently liked items owned by user, or in group, or on site (so all contexts)
$like_types["recently_liked"] = elgg_echo("widgets:likes:settings:like_type:recently_liked");

echo "<div>";
echo elgg_echo("widgets:likes:settings:like_type") . ":<br />";
echo elgg_view("input/dropdown", array("name" => "params[like_type]", "options_values" => $like_types, "value" => $like_type));
echo "</div>";

echo "<div>";
echo elgg_echo("widgets:likes:settings:interval") . ":<br />";
echo elgg_view("input/dropdown", array("name" => "params[interval]", "options_values" => $intervals, "value" => $interval));
echo "</div>";

echo "<div>";
echo elgg_echo("widget:numbertodisplay") . ":<br />";
echo elgg_view("input/dropdown", array("name" => "params[limit]", "options" => range(1,10), "value" => $limit));
echo "</div>";

<?php
/**
 * widget settings for the discussions widget
 */
$widget = $vars["entity"];
$widgetId = $widget->getGUID();
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
	echo '<label for="discuss-'.$widgetId.'">'.elgg_echo("widgets:discussion:settings:group_only").'</label>';
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[group_only]", "value" => $widget->group_only, "options_values" => $noyes_options, 'id'=>'discuss-'.$widgetId,));
	echo "</div>";
	
}

echo "<div>";
echo '<label for="discuss-num-'.$widgetId.'">'.elgg_echo("widget:numbertodisplay").'</label>';
echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[discussion_count]", "value" => $discussion_count, "options" => range(1, 10), 'id'=>'discuss-num-'.$widgetId,));
echo "</div>";

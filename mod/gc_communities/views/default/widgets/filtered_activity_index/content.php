<?php

/**
 * Community page widgets
 */

$widget = $vars['entity'];

$widget->title = (get_current_language() == "fr") ? $widget->widget_title_fr : $widget->widget_title_en;

$widget_groups = $widget->widget_groups;
$num_items = $widget->num_items;
if (!isset($num_items)) {
	$num_items = 10;
}

$widget_datas = elgg_list_river(array("limit" => $num_items, "object_guids" => $widget_groups));

echo $widget_datas;

<?php
/**
 * Edit the widget
 */

$widget = $vars["entity"];
$widgetId = $widget->getGUID();
$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 10;
}

// filter activity
// get filter options
$filter_contents = array("0" => elgg_echo("all"));
$registered_entities = elgg_get_config("registered_entities");
if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $ar) {
		if ($type == "user") {
			continue;
		} else {
			if (count($registered_entities[$type])) {
				foreach ($registered_entities[$type] as $subtype) {
					$keyname = "item:" . $type . ":" . $subtype;
					$filter_contents["{$type},{$subtype}"] = elgg_echo($keyname);
				}
			} else {
				$keyname = "item:" . $type;
				$filter_contents["{$type},"] = elgg_echo($keyname);
			}
		}
	}
}

$filter_selector = elgg_view("input/dropdown", array("name" => "params[activity_filter]", "value" => $widget->activity_filter, "options_values" => $filter_contents, 'id'=>'params[activity_filter]-'.$widgetId));

if ($widget->context != "groups") {
	//the user of the widget
	$owner = $widget->getOwnerEntity();
	
	// get all groups
	$options = array(
		"type" => "group",
		"limit" => false,
		"joins" => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
		"order_by" => "ge.name ASC"
	);
	
	if (elgg_instanceof($owner, "user")) {
		$options["relationship"] = "member";
		$options["relationship_guid"] = $owner->getGUID();
	}
	
	$batch = new ElggBatch("elgg_get_entities_from_relationship", $options);
	$batch->rewind(); // needed so the next call succeeds
	if ($batch->valid()) {
		
		// get groups
		$group_options_values = array();
		foreach ($batch as $group) {
			$group_options_values[$group->name] = $group->getGUID();
		}
		
		// make options
		echo "<div>";
		echo '<label for="1-'.$widgetId.'">'.elgg_echo("widgets:group_river_widget:edit:num_display").'</label>';
		echo " " . elgg_view("input/dropdown", array("options" => range(5, 25, 5), "value" => $num_display, "name" => "params[num_display]", 'id'=>'1-'.$widgetId));
		echo "</div>";
		
		echo "<div>";
		echo '<label for="params[activity_filter]-'.$widgetId.'">'.elgg_echo("filter") . "</label><br />";
		echo $filter_selector;
		echo "</div>";

		echo "<div>";
		echo '<label for="2-'.$widgetId.'">'.elgg_echo("widgets:group_river_widget:edit:group").'</label>';
		echo elgg_view("input/checkboxes", array("name" => "params[group_guid]", "value" => $widget->group_guid, "options" => $group_options_values, 'id' => '2-'.$widgetId));
		echo "</div>";
	} else {
		echo elgg_echo("widgets:group_river_widget:edit:no_groups");
	}
} else {
	echo "<div>";
	echo '<label for="3-'.$widgetId.'">'.elgg_echo("widgets:group_river_widget:edit:num_display").'</label>';
	echo " " . elgg_view("input/dropdown", array("options" => range(5, 25, 5), "value" => $num_display, "name" => "params[num_display]", 'id' => '3-'.$widgetId,));
	echo "</div>";
	
	echo "<div>";
	echo '<label for="params[activity_filter]-'.$widgetId.'">'.elgg_echo("filter") . "</label><br />";
	echo $filter_selector;
	echo "</div>";
}

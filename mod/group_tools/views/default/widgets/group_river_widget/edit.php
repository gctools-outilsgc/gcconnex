<?php
	/**
	 * Edit the widget
	 *
	 */

	$widget = $vars["entity"];
	
	$num_display = (int) $widget->num_display;
	if($num_display < 1){
		$num_display = 10;
	}
	
	// filter activity
	// get filter options
	$filter_contents = array("0" => elgg_echo("all"));
	$registered_entities = elgg_get_config("registered_entities");
	if (!empty($registered_entities)) {
		foreach ($registered_entities as $type => $ar) {
			if($type == "user"){
				continue;
			} else {
				if (count($registered_entities[$type])) {
					foreach ($registered_entities[$type] as $subtype) {
						$keyname = 'item:' . $type . ':' . $subtype;
						$filter_contents["{$type},{$subtype}"] = elgg_echo($keyname);
					}
				} else {
					$keyname = 'item:' . $type;
					$filter_contents["{$type},"] = elgg_echo($keyname);
				}
			}
		}
	}
	
	$filter_selector = elgg_view("input/dropdown", array("name" => "params[activity_filter]", "value" => $widget->activity_filter, "options_values" => $filter_contents));
	
	if ($widget->context != "groups") {
	    //the user of the widget
		$owner = $widget->getOwnerEntity();
	      
		// get all groups
		$options = array(
			"type" => "group",
			"limit" => false
		);
		
		if (elgg_instanceof($owner, "user")) {
			$options["relationship"] = "member";
			$options["relationship_guid"] = $owner->getGUID();
		}
		
	    if($groups = elgg_get_entities_from_relationship($options)){
	    	
			// get groups
	    	$group_options_values = array();
			foreach($groups as $group){
				$group_options_values[$group->name] = $group->getGUID();
			}
			
			natcasesort($group_options_values);
			
			// make options
			echo "<div>";
			echo elgg_echo('widgets:group_river_widget:edit:num_display');
			echo " " . elgg_view("input/dropdown", array("options" => range(5, 25, 5), "value" => $num_display, "name" => "params[num_display]"));
			echo "</div>";
			
			echo "<div>";
			echo elgg_echo("filter") . "<br />";
			echo $filter_selector;
			echo "</div>";
	
			echo "<div>";
			echo elgg_echo('widgets:group_river_widget:edit:group');
			echo elgg_view("input/checkboxes", array("name" => "params[group_guid]", "value" => $widget->group_guid, "options" => $group_options_values));
			echo "</div>";
		} else {
			echo elgg_echo("widgets:group_river_widget:edit:no_groups");
	    }
	} else {
		echo "<div>";
		echo elgg_echo('widgets:group_river_widget:edit:num_display');
		echo " " . elgg_view("input/dropdown", array("options" => range(5, 25, 5), "value" => $num_display, "name" => "params[num_display]"));
		echo "</div>";
		
		echo "<div>";
		echo elgg_echo("filter") . "<br />";
		echo $filter_selector;
		echo "</div>";
	}
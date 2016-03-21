<?php

$widget_guid = (int) get_input("widget_guid");
$multi_dashboard_guid = (int) get_input("multi_dashboard_guid");

if (!empty($widget_guid)) {
	if (($widget = get_entity($widget_guid)) && elgg_instanceof($widget, "object", "widget", "ElggWidget")) {
		// remove widget from any other multi dashboard
		remove_entity_relationships($widget->getGUID(), MultiDashboard::WIDGET_RELATIONSHIP);
		
		// check if we dropped on a multi dashboard
		if (!empty($multi_dashboard_guid)) {
			if (($dashboard = get_entity($multi_dashboard_guid)) && elgg_instanceof($dashboard, "object", MultiDashboard::SUBTYPE, "MultiDashboard")) {
				// we need to drop the widget on the first column, last position
				$pos = 10;
				if ($widgets = $dashboard->getWidgets()) {
					if (isset($widgets[1])) {
						$max_pos = max(array_keys($widgets[1]));
						
						if ($max_pos >= $pos) {
							$pos = $max_pos + 10;
						}
					}
				}
				
				$widget->column = 1;
				$widget->order = $pos;
				
				$widget->save();
				
				// add the widget to the dashboard
				$widget->addRelationship($dashboard->getGUID(), MultiDashboard::WIDGET_RELATIONSHIP);
			} else {
				register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($multi_dashboard_guid, "MultiDashboard")));
			}
		}
		
		system_message(elgg_echo("widget_manager:actions:multi_dashboard:drop:success"));
	} else {
		register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($widget_guid, "ElggWidget")));
	}
} else {
	register_error(elgg_echo("InvalidParameterException:MissingParameter"));
}

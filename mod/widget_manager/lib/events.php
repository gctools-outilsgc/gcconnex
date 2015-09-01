<?php

/**
 * Events for widget manager
 */

/**
 * Sets the widget manager tool option. This is needed because in some situation the tooloption is not available.
 *
 * @param string $event       name of the system event
 * @param string $object_type type of the event
 * @param mixed  $object      object related to the event
 *
 * @return void
 */
function widget_manager_create_group_event_handler($event, $object_type, $object) {
	if ($object instanceof ElggGroup) {
		if (elgg_get_plugin_setting("group_option_default_enabled", "widget_manager") == "yes") {
			$object->widget_manager_enable = "yes";
		}
	}
}

/**
 * Sets the fixed parent guid to default widgets to be used when cloning, so relationship can stay intact.
 *
 * @param string $event       name of the system event
 * @param string $object_type type of the event
 * @param mixed  $object      object related to the event
 *
 * @return void
 */
function widget_manager_update_widget($event, $object_type, $object) {
	if (($object instanceof ElggWidget) && in_array($event, array("create", "update", "delete"))) {
		if (stristr($_SERVER["HTTP_REFERER"], "/admin/appearance/default_widgets")) {
			// on create set a parent guid
			if ($event == "create") {
				$object->fixed_parent_guid = $object->guid;
			}
			
			// update time stamp
			$context = $object->context;
			if (empty($context)) {
				// only situation is on create probably, as context is metadata and saved after creation of the object, this is the fallback
				$context = get_input("context", false);
			}
			
			if ($context) {
				elgg_set_plugin_setting($context . "_fixed_ts", time(), "widget_manager");
			}
		}
	}
}

/**
 * Performs action when a widget is created
 *
 * @param string $event       name of the system event
 * @param string $object_type type of the event
 * @param mixed  $object      object related to the event
 *
 * @return void
 */
function widget_manager_create_object_handler($event, $object_type, $object) {

	if (elgg_instanceof($object, "object", "widget", "ElggWidget")) {
		$owner = $object->getOwnerEntity();
		// Updates access for privately created widgets in a group or on site
		if ((int) $object->access_id === ACCESS_PRIVATE) {
			$old_ia = elgg_set_ignore_access();
			if ($owner instanceof ElggGroup) {
				$object->access_id = $owner->group_acl;
				$object->save();
			} elseif ($owner instanceof ElggSite) {
				$object->access_id = ACCESS_PUBLIC;
				$object->save();
			}
			elgg_set_ignore_access($old_ia);
		}
		// Adds a relation between a widget and a multidashboard object
		$dashboard_guid = get_input("multi_dashboard_guid");
		if ($dashboard_guid && widget_manager_multi_dashboard_enabled()) {
			$dashboard = get_entity($dashboard_guid);
			if (elgg_instanceof($dashboard, "object", MultiDashboard::SUBTYPE, "MultiDashboard")) {
				add_entity_relationship($object->getGUID(), MultiDashboard::WIDGET_RELATIONSHIP, $dashboard->getGUID());
			}
		}
	}
}

/**
 * Sets the widget manager tool option. This is needed because in some situation the tool option is not available.
 *
 * And add/remove tool enabled widgets
 *
 * @param string $event       name of the system event
 * @param string $object_type type of the event
 * @param mixed  $object      object related to the event
 *
 * @return void
 */
function widget_manager_update_group_event_handler($event, $object_type, $object) {
	
	if (!($object instanceof ElggGroup)) {
		return;
	}
	
	$plugin_settings = elgg_get_plugin_setting("group_enable", "widget_manager");
	// make widget management mandatory
	if ($plugin_settings == "forced") {
		$object->widget_manager_enable = "yes";
	}
	
	// add/remove tool enabled widgets
	if (($plugin_settings == "forced") || (($plugin_settings == "yes") && ($object->widget_manager_enable == "yes"))) {
		
		$result = array(
			"enable" => array(),
			"disable" => array()
		);
		$params = array(
			"entity" => $object
		);
		$result = elgg_trigger_plugin_hook("group_tool_widgets", "widget_manager", $params, $result);
		
		if (empty($result) || !is_array($result)) {
			return;
		}
		
		$current_widgets = elgg_get_widgets($object->getGUID(), "groups");
		
		// disable widgets
		$disable_widget_handlers = elgg_extract("disable", $result);
		if (!empty($disable_widget_handlers) && is_array($disable_widget_handlers)) {
				
			if (!empty($current_widgets) && is_array($current_widgets)) {
				foreach ($current_widgets as $column => $widgets) {
					if (!empty($widgets) && is_array($widgets)) {
						foreach ($widgets as $order => $widget) {
							// check if a widget should be removed
							if (in_array($widget->handler, $disable_widget_handlers)) {
								// yes, so remove the widget
								$widget->delete();
								
								unset($current_widgets[$column][$order]);
							}
						}
					}
				}
			}
		}
		
		// enable widgets
		$column_counts = array();
		$enable_widget_handlers = elgg_extract("enable", $result);
		if (!empty($enable_widget_handlers) || is_array($enable_widget_handlers)) {
			
			// ignore access restrictions
			// because if a group is created with a visibility of only group members
			// the group owner is not yet added to the acl and thus can't edit the newly created widgets
			$ia = elgg_set_ignore_access(true);
			
			if (!empty($current_widgets) && is_array($current_widgets)) {
				foreach ($current_widgets as $column => $widgets) {
					// count for later balancing
					$column_counts[$column] = count($widgets);
					
					if (!empty($widgets) && is_array($widgets)) {
						foreach ($widgets as $order => $widget) {
							// check if a widget which sould be enabled isn't already enabled
							$enable_index = array_search($widget->handler, $enable_widget_handlers);
							if ($enable_index !== false) {
								// already enabled, do add duplicate
								unset($enable_widget_handlers[$enable_index]);
							}
						}
					}
				}
			}
			
			// add new widgets
			if (!empty($enable_widget_handlers)) {
				foreach ($enable_widget_handlers as $handler) {
					$widget_guid = elgg_create_widget($object->getGUID(), $handler, "groups", $object->access_id);
					if (!empty($widget_guid)) {
						$widget = get_entity($widget_guid);
						
						if ($column_counts[1] <= $column_counts[2]) {
							// move to the end of the first column
							$widget->move(1, 9000);
							
							$column_counts[1]++;
						} else {
							// move to the end of the second
							$widget->move(2, 9000);
							
							$column_counts[2]++;
						}
					}
				}
			}
			
			// restore access restrictions
			elgg_set_ignore_access($ia);
		}
	}
}

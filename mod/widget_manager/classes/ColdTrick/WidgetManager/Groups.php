<?php

namespace ColdTrick\WidgetManager;

class Groups {
	
	/**
	 * Sets the widget manager tool option. This is needed because in some situation the tooloption is not available.
	 *
	 * @param string $event       name of the system event
	 * @param string $object_type type of the event
	 * @param mixed  $object      object related to the event
	 *
	 * @return void
	 */
	public static function setGroupToolOption($event, $object_type, $object) {
	
		if (!elgg_instanceof($object, 'group')) {
			return;
		}
	
		if (elgg_get_plugin_setting('group_option_default_enabled', 'widget_manager') !== 'yes') {
			return;
		}
	
		$object->widget_manager_enable = 'yes';
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
	public static function updateGroupWidgets($event, $object_type, $object) {
	
		if (!($object instanceof \ElggGroup)) {
			return;
		}
	
		$plugin_settings = elgg_get_plugin_setting('group_enable', 'widget_manager');
		// make widget management mandatory
		if ($plugin_settings == 'forced') {
			$object->widget_manager_enable = 'yes';
		}
	
		// add/remove tool enabled widgets
		if (($plugin_settings == 'forced') || (($plugin_settings == 'yes') && ($object->widget_manager_enable == 'yes'))) {
	
			$result = ['enable' => [], 'disable' => []];
			$params = ['entity' => $object];
			$result = elgg_trigger_plugin_hook('group_tool_widgets', 'widget_manager', $params, $result);
	
			if (empty($result) || !is_array($result)) {
				return;
			}
	
			$current_widgets = elgg_get_widgets($object->getGUID(), 'groups');
	
			// disable widgets
			$disable_widget_handlers = elgg_extract('disable', $result);
			if (!empty($disable_widget_handlers) && is_array($disable_widget_handlers)) {
	
				if (!empty($current_widgets) && is_array($current_widgets)) {
					foreach ($current_widgets as $column => $widgets) {
						if (!is_array($widgets) || empty($widgets)) {
							continue;
						}
							
						foreach ($widgets as $order => $widget) {
							// check if a widget should be removed
							if (!in_array($widget->handler, $disable_widget_handlers)) {
								continue;
							}
	
							// yes, so remove the widget
							$widget->delete();
	
							unset($current_widgets[$column][$order]);
						}
					}
				}
			}
	
			// enable widgets
			$column_counts = [];
			$enable_widget_handlers = elgg_extract('enable', $result);
			if (!empty($enable_widget_handlers) || is_array($enable_widget_handlers)) {
					
				// ignore access restrictions
				// because if a group is created with a visibility of only group members
				// the group owner is not yet added to the acl and thus can't edit the newly created widgets
				$ia = elgg_set_ignore_access(true);
					
				if (!empty($current_widgets) && is_array($current_widgets)) {
					foreach ($current_widgets as $column => $widgets) {
						// count for later balancing
						$column_counts[$column] = count($widgets);
							
						if (empty($widgets) || !is_array($widgets)) {
							continue;
						}
							
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
					
				// add new widgets
				if (!empty($enable_widget_handlers)) {
					foreach ($enable_widget_handlers as $handler) {
						$widget_guid = elgg_create_widget($object->getGUID(), $handler, 'groups', $object->access_id);
						if (empty($widget_guid)) {
							continue;
						}
							
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
					
				// restore access restrictions
				elgg_set_ignore_access($ia);
			}
		}
	}
}
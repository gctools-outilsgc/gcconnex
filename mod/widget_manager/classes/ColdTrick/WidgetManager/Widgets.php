<?php

namespace ColdTrick\WidgetManager;

use Elgg\WidgetDefinition;
class Widgets {
	
	/**
	 * Updates widget access for private widgets in group or site
	 *
	 * @param string $event       name of the system event
	 * @param string $object_type type of the event
	 * @param mixed  $object      object related to the event
	 *
	 * @return void
	 */
	public static function fixPrivateAccess($event, $object_type, $object) {
	
		if (!elgg_instanceof($object, 'object', 'widget', 'ElggWidget')) {
			return;
		}

		if ((int) $object->access_id !== ACCESS_PRIVATE) {
			return;
		}

		$owner = $object->getOwnerEntity();
		
		// Updates access for privately created widgets in a group or on site
		$old_ia = elgg_set_ignore_access();
		if ($owner instanceof \ElggGroup) {
			$object->access_id = $owner->group_acl;
			$object->save();
		} elseif ($owner instanceof \ElggSite) {
			$object->access_id = ACCESS_PUBLIC;
			$object->save();
		}
		elgg_set_ignore_access($old_ia);
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
	public static function createFixedParentMetadata($event, $object_type, $object) {
		if (!($object instanceof \ElggWidget) || !in_array($event, ['create', 'update', 'delete'])) {
			return;
		}
	
		if (!stristr($_SERVER['HTTP_REFERER'], '/admin/appearance/default_widgets')) {
			return;
		}
	
		// on create set a parent guid
		if ($event == 'create') {
			$object->fixed_parent_guid = $object->guid;
		}
	
		// update time stamp
		$context = $object->context;
		if (empty($context)) {
			// only situation is on create probably, as context is metadata and saved after creation of the object, this is the fallback
			$context = get_input('context', false);
		}
	
		if ($context) {
			elgg_set_plugin_setting($context . '_fixed_ts', time(), 'widget_manager');
		}
	}
	
	/**
	 * Adds index widget handlers as allowed handlers to the extra context handlers
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return void
	 */
	public static function addExtraContextsWidgets($hook_name, $entity_type, $return_value, $params) {
		$context = elgg_extract('context', $params);
		if (!widget_manager_is_extra_context($context)) {
			return;
		}
		
		foreach ($return_value as $id => $widget_definition) {
			if (!in_array('index', $widget_definition->context)) {
				continue;
			}
			
			if (!in_array($context, $widget_definition->context)) {
				$widget_definition->context[] = $context;
			}
			
			$return_value[$id] = $widget_definition;
		}
		
		return $return_value;
	}
	
	/**
	 * Changes widgets registered for the all context to be explictly registered for 'profile' and 'dashboard'
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return void
	 */
	public static function fixAllContext($hook_name, $entity_type, $return_value, $params) {
		foreach ($return_value as $id => $widget_definition) {
			if (!in_array('all', $widget_definition->context)) {
				continue;
			}
			
			if (!in_array('profile', $widget_definition->context)) {
				$widget_definition->context[] = 'profile';
			}
			
			if (!in_array('dashboard', $widget_definition->context)) {
				$widget_definition->context[] = 'dashboard';
			}
			
			$return_value[$id] = $widget_definition;
		}
		
		return $return_value;
	}
	
	/**
	 * Applies the saved widgets config
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return void
	 */
	public static function applyWidgetsConfig($hook_name, $entity_type, $return_value, $params) {
		foreach ($return_value as $id => $widget_definition) {
			$widget_config = widget_manager_get_widget_setting($widget_definition->id, 'all');
			if (empty($widget_config)) {
				continue;
			}
			
			if (!isset($widget_definition->originals)) {
				$widget_definition->originals = [
					'multiple' => $widget_definition->multiple,
					'context' => $widget_definition->context,
				];
			}
			
			// fix multiple
			if (isset($widget_config['multiple'])) {
				$widget_definition->multiple = (bool) elgg_extract('multiple', $widget_config);
			}
			
			// fix contexts
			$contexts = elgg_extract('contexts', $widget_config);
			if (!empty($contexts)) {
				foreach ($contexts as $context => $context_config) {
					if (!isset($context_config['enabled'])) {
						continue;
					}
					
					$enabled = elgg_extract('enabled', $context_config);
					$existing_key = array_search($context, $widget_definition->context);
					if ($existing_key !== false) {
						// already existing in default contexts
						if (!$enabled) {
							// remove if disabled in config
							unset($widget_definition->context[$existing_key]);
						}
					} elseif ($enabled) {
						// add if not existing
						$widget_definition->context[] = $context;
					}
				}
				$return_value[$id] = $widget_definition;
			}
		}
		
		return $return_value;
	}
}
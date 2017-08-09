<?php

namespace ColdTrick\WidgetManager;

class Context {

	/**
	 * Add extra widget contexts that have advanced widget options available
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return array
	 */
	public static function addExtraContextsToAdvancedContexts($hook_name, $entity_type, $return_value, $params) {
		if (!is_array($return_value)) {
			$return_value = [];
		}
	
		$setting = strtolower(elgg_get_plugin_setting('extra_contexts', 'widget_manager'));
		if (empty($setting)) {
			return $return_value;
		}
		
		$widget = elgg_extract('entity', $params);
		if (empty($widget)) {
			return $return_value;
		}
		
		$contexts = string_to_tag_array($setting);
		if (empty($contexts)) {
			return $return_value;
		}
		
		$widget_context = $widget->context;
		if (in_array($widget_context, $contexts)) {
			$return_value[] = $widget_context;
		}
		
		return $return_value;
	}
	
	/**
	 * Register new widget contexts for use on custom widget pages
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return string
	 */
	public static function addExtraContextsAsAvailableWidgetsContext($hook_name, $entity_type, $return_value, $params) {
		if (empty($return_value)) {
			return;
		}
	
		$setting = strtolower(elgg_get_plugin_setting('extra_contexts', 'widget_manager'));
		if (empty($setting)) {
			return;
		}
			
		$contexts = string_to_tag_array($setting);
		if ($contexts && in_array($return_value, $contexts)) {
			return 'index';
		}
	}
}
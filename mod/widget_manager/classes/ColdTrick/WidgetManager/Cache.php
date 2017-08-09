<?php

namespace ColdTrick\WidgetManager;

class Cache {
	
	/**
	 * Listen to the cache flush event to invalidate cache of widgets content
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied param
	 *
	 * @return void
	 */
	public static function resetWidgetsCache($event, $type, $object) {
		
		$ia = elgg_set_ignore_access(true);
		$batch = new \ElggBatch('elgg_get_entities_from_private_settings', [
			'type' => 'object',
			'subtype' => 'widget',
			'limit' => false,
			'private_setting_name' => 'widget_manager_cached_data',
		]);
		
		$batch->setIncrementOffset(false);
		
		foreach ($batch as $entity) {
			$entity->removePrivateSetting('widget_manager_cached_data');
		}
		
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Unsets the cached data for cacheable widgets
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return bool
	 */
	public static function clearWidgetCacheOnSettingsSave($hook_name, $entity_type, $return_value, $params) {

		$widget = elgg_extract('widget', $params);
		if (!elgg_instanceof($widget, 'object', 'widget')) {
			return;
		}
	
		if (widget_manager_is_cacheable_widget($widget)) {
			$widget->widget_manager_cached_data = null;
		}
	}
}
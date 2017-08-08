<?php

namespace ColdTrick\TheWireTools;

class Widgets {
	
	/**
	 * Add or remove widgets based on the group tool option
	 *
	 * @param string $hook_name   'group_tool_widgets'
	 * @param string $entity_type 'widget_manager'
	 * @param array  $return      current enable/disable widget handlers
	 * @param array  $params      supplied params
	 *
	 * @return array
	 */
	public static function groupToolBasedWidgets($hook_name, $entity_type, $return, $params) {
	
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		if (!is_array($return)) {
			$return = [];
		}

		if (!isset($return['enable'])) {
			$return['enable'] = [];
		}
		if (!isset($return['disable'])) {
			$return['disable'] = [];
		}

		// check different group tools for which we supply widgets
		if ($entity->thewire_enable !== 'no') {
			$return['enable'][] = 'thewire_groups';
		} else {
			$return['disable'][] = 'thewire_groups';
		}
	
		return $return;
	}
	
	/**
	 * returns the correct widget title
	 *
	 * @param string $hook_name   'widget_url'
	 * @param string $entity_type 'widget_manager'
	 * @param string $return      the current widget url
	 * @param array  $params      supplied params
	 *
	 * @return string the url for the widget
	 */
	public static function widgetTitleURL($hook_name, $entity_type, $return, $params) {
	
		$widget = elgg_extract('entity', $params);
		if (!($widget instanceof \ElggWidget)) {
			return;
		}
		
		switch ($widget->handler) {
			case 'thewire':
				$return = "thewire/owner/{$widget->getOwnerEntity()->username}";
				break;
			case 'index_thewire':
			case 'thewire_post':
				$return = 'thewire/all';
				break;
			case 'thewire_groups':
				$return = "thewire/group/{$widget->getOwnerGUID()}";
				break;
		}
	
		return $return;
	}
	
	/**
	 * Unregisters a widget handler in case of group
	 *
	 * @param string $hook        hook name
	 * @param string $entity_type hook type
	 * @param array  $returnvalue current return value
	 * @param array  $params      parameters
	 *
	 * @return array
	 */
	public static function registerHandlers($hook, $entity_type, $returnvalue, $params) {
		
		$container = elgg_extract('container', $params);
		if (!($container instanceof \ElggGroup)) {
			return;
		}
		
		if ($container->thewire_enable !== 'no') {
			return;
		}
		
		/* @var $widget \Elgg\WidgetDefinition */
		foreach ($returnvalue as $index => $widget) {
			if ($widget->id !== 'thewire_groups') {
				continue;
			}
			unset($returnvalue[$index]);
			break;
		}
		
		return $returnvalue;
	}
}

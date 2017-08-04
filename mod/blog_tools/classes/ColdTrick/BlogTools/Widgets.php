<?php

namespace ColdTrick\BlogTools;

/**
 * Widget releated functions
 *
 * @package    ColdTrick
 * @subpackage BlogTools
 */
class Widgets {
	
	/**
	 * Support widget urls for Widget Manager
	 *
	 * @param string $hook         'widget_url'
	 * @param string $type         'widget_manager'
	 * @param string $return_value the current widget url
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function widgetUrl($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			return;
		}
		
		$widget = elgg_extract('entity', $params);
		if (!($widget instanceof \ElggWidget)) {
			return;
		}
		
		switch ($widget->handler) {
			case 'index_blog':
				$return_value = 'blog/all';
				break;
			case 'blog':
				$owner = $widget->getOwnerEntity();
				if ($owner instanceof \ElggUser) {
					$return_value = "blog/owner/{$owner->username}";
				} elseif ($owner instanceof \ElggGroup) {
					$return_value = "blog/group/{$owner->getGUID()}/all";
				}
				break;
		}
		
		return $return_value;
	}
	
	/**
	 * Add or remove widgets based on the group tool option
	 *
	 * @param string $hook         'group_tool_widgets'
	 * @param string $type         'widget_manager'
	 * @param array  $return_value current enable/disable widget handlers
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function groupTools($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		if (!is_array($return_value)) {
			// someone has other ideas
			return;
		}
		
		// check different group tools for which we supply widgets
		if ($entity->blog_enable == 'yes') {
			$return_value['enable'][] = 'blog';
		} else {
			$return_value['disable'][] = 'blog';
		}
		
		return $return_value;
	}
}

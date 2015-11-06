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
	 * @return string
	 */
	public static function widgetUrl($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			return $return_value;
		}
		
		if (empty($params) || !is_array($params)) {
			return $return_value;
		}
		
		$widget = elgg_extract("entity", $params);
		if (empty($widget) || !elgg_instanceof($widget, "object", "widget")) {
			return $return_value;
		}
		
		switch ($widget->handler) {
			case "index_blog":
				$return_value = "blog/all";
				break;
			case "blog":
				$owner = $widget->getOwnerEntity();
				if (elgg_instanceof($owner, "user")) {
					$return_value = "blog/owner/" . $owner->username;
				} elseif (elgg_instanceof($owner, "group")) {
					$return_value = "blog/group/" . $owner->getGUID() . "/all";
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
	 * @return array
	 */
	public static function groupTools($hook, $type, $return_value, $params) {
		
		if (empty($params) || is_array($params)) {
			return $return_value;
		}
		
		$entity = elgg_extract("entity", $params);
		if (empty($entity) || !elgg_instanceof($entity, "group")) {
			return $return_value;
		}
		
		if (!is_array($return_value)) {
			$return_value = array();
		}

		if (!isset($return_value["enable"])) {
			$return_value["enable"] = array();
		}
		if (!isset($return_value["disable"])) {
			$return_value["disable"] = array();
		}

		// check different group tools for which we supply widgets
		if ($entity->blog_enable == "yes") {
			$return_value["enable"][] = "blog";
		} else {
			$return_value["disable"][] = "blog";
		}
		
		return $return_value;
	}
}
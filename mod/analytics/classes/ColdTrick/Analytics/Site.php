<?php

namespace ColdTrick\Analytics;

class Site {
	
	/**
	 * Add URLs to the allowed pages when in walled garden
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return array
	 */
	public static function publicPages($hook, $type, $return_value, $params) {
		
		$return_value[] = 'analytics/ajax_success';
		
		return $return_value;
	}
}

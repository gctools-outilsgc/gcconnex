<?php

namespace ColdTrick\SimpleSAML;

class WalledGarden {
	
	/**
	 * Extend the allowed pages of your community if it is in walled garden mode.
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return array
	 */
	public static function publicPages($hook, $type, $return_value, $params) {
		
		// get virtual directory path to simplesamlphp installation
		static $simplesamlphp_directoy;
		if (!isset($simplesamlphp_directoy)) {
			$simplesamlphp_directoy = false;
		
			$setting = elgg_get_plugin_setting('simplesamlphp_directory', 'simplesaml');
			if (!empty($setting)) {
				$simplesamlphp_directoy = $setting;
			}
		}
		
		// add simplesaml to the public pages
		$return_value[] = 'saml/.*';
		$return_value[] = 'action/simplesaml/.*';
		
		if ($simplesamlphp_directoy) {
			$return_value[] = $simplesamlphp_directoy . '/.*';
		}
		
		return $return_value;
	}
}
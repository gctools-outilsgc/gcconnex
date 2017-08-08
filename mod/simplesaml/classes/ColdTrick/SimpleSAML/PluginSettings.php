<?php

namespace ColdTrick\SimpleSAML;

class PluginSettings {
	
	/**
	 * Change the value of a plugin setting before it is saved.
	 *
	 * This is used to save an array as JSON in a plugin setting. This because arrays can't be saved in plugin settings.
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function saveSetting($hook, $type, $return_value, $params) {
		
		$plugin = elgg_extract('plugin', $params);
		$setting_name = elgg_extract('name', $params);
	
		if (!($plugin instanceof \ElggPlugin)) {
			return;
		}
		
		if ($plugin->getID() !== 'simplesaml') {
			return;
		}
		
		$pattern = '/^(?:idp_)[\S]+(?:_attributes)$/';
		if (preg_match($pattern, $setting_name)) {
			return json_encode($return_value);
		}
	}
}

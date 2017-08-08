<?php

namespace ColdTrick\SimpleSAML;

class WidgetManager {
	
	/**
	 * Add widget title link if Widget Manager is enabled.
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function widgetURL($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			// url already set
			return;
		}
		
		if (elgg_is_logged_in()) {
			// already logged in
			return;
		}
		
		$widget = elgg_extract('entity', $params);
		if (!($widget instanceof \ElggWidget)) {
			return;
		}
		
		if ($widget->handler !== 'simplesaml') {
			return;
		}
		
		$samlsource = $widget->samlsource;
		if (empty($samlsource) || ($samlsource === 'all')) {
			return;
		}
		
		if (!simplesaml_is_enabled_source($samlsource)) {
			return;
		}
		
		return "/saml/login/{$samlsource}";
	}
}

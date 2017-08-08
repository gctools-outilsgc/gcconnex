<?php

namespace ColdTrick\SimpleSAML;

class Logout {
	
	/**
	 * Hook on the logout action to make sure we can logout on SimpleSAML
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function action($hook, $type, $return_value, $params) {
		global $SIMPLESAML_SOURCE;
		
		$login_source = simplesaml_get_from_session('saml_login_source');
		if (!isset($login_source)) {
			return;
		}
		
		// store session data because session is destroyed
		$SIMPLESAML_SOURCE = $login_source;
	
		// after session is destroyed forward to saml logout
		elgg_register_plugin_hook_handler('forward', 'system', '\ColdTrick\SimpleSAML\Logout::forward');
	}
	
	/**
	 * Hook on the forward function to make sure we can logout on SimpleSAML
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the tpe of the hook
	 * @param bool   $return_value the current url to forward to
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function forward($hook, $type, $return_value, $params) {
		global $SIMPLESAML_SOURCE;
		
		if (elgg_is_logged_in() || empty($SIMPLESAML_SOURCE)) {
			return;
		}
		
		// do we have a logout source
		try {
			$source = new \SimpleSAML_Auth_Simple($SIMPLESAML_SOURCE);
	
			// logout of the external source
			$source->logout(elgg_get_site_url());
		} catch (Exception $e) {
			// do nothing
		}
	}
}

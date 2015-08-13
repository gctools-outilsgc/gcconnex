<?php
/**
 * All plugin hook handlers can be found in this file
 */

/**
 * Extend the allowed pages of your community if it is in walled garden mode.
 *
 * @param string $hook         'public_pages' is the hook name
 * @param string $type         'walled_garden' is the type if this hook
 * @param array  $return_value the default return value
 * @param array  $params       an array with parameter to help extending the result
 *
 * @return array an array with all the allowed pages
 */
function simplesaml_walled_garden_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	// get virtual directory path to simplesamlphp installation
	static $simplesamlphp_directoy;
	if (!isset($simplesamlphp_directoy)) {
		$simplesamlphp_directoy = false;
		
		$setting = elgg_get_plugin_setting("simplesamlphp_directory", "simplesaml");
		if (!empty($setting)) {
			$simplesamlphp_directoy = $setting;
		}
	}
	
	// add simplesaml to the public pages
	$result[] = "saml/.*";
	$result[] = "action/simplesaml/.*";
	
	if ($simplesamlphp_directoy) {
		$result[] = $simplesamlphp_directoy . "/.*";
	}

	return $result;
}

/**
 * Add widget title link if Widget Manager is enabled.
 *
 * @param string $hook         'widget_url' is the hook name
 * @param string $type         'widget_manager' is the type if this hook
 * @param array  $return_value the default return value
 * @param array  $params       an array with parameter to help extending the result
 *
 * @return string an url to be put in the widget title
 */
function simplesaml_widget_url_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	if (!empty($params) && is_array($params)) {
		$widget = elgg_extract("entity", $params);
		if (!empty($widget)) {
			if ($widget->handler == "simplesaml") {
				$samlsource = $widget->samlsource;
				
				if (!empty($samlsource) && ($samlsource !== "all")) {
					if (simplesaml_is_enabled_source($samlsource)) {
						$result = "/saml/login/" . $samlsource;
					}
				}
			}
		}
	}

	return $result;
}

/**
 * Change the value of a plugin setting before it is saved.
 *
 * This is used to save an array as JSON in a plugin setting. This because arrays can't be saved in plugin settings.
 *
 * @param string $hook         'setting' is the hook name
 * @param string $type         'plugin' is the type if this hook
 * @param array  $return_value the default return value
 * @param array  $params       an array with parameter to help extending the result
 *
 * @return string the alternate plugin setting value
 */
function simplesaml_plugin_setting_save_hook($hook, $type, $return_value, $params) {
	$result = $return_value;

	if (!empty($params) && is_array($params)) {
		$plugin = elgg_extract("plugin", $params);
		$setting_name = elgg_extract("name", $params);
		
		if (!empty($plugin) && elgg_instanceof($plugin, "object", "plugin")) {
			if ($plugin->getID() == "simplesaml") {
				$pattern = '/^(idp_){1}[\S]+(_attributes){1}$/';
				
				if (preg_match($pattern, $setting_name)) {
					$result = json_encode($result);
				}
			}
		}
	}
	
	return $result;
}

/**
 * Hook on the logout action to make sure we can logout on SimpleSAML
 *
 * @param string $hook         'action'
 * @param string $type         'logout'
 * @param bool   $return_value return false to stop the action from executing
 * @param array  $params       supplied params
 *
 * @return void
 */
function simplesaml_logout_action_hook($hook, $type, $return_value, $params) {
	global $SIMPLESAML_SESSION_BACKUP;
	global $SIMPLESAML_SOURCE;

	if (isset($_SESSION["SimpleSAMLphp_SESSION"])) {
		// store session data because session is destroyed
		$SIMPLESAML_SESSION_BACKUP = $_SESSION["SimpleSAMLphp_SESSION"];
		$SIMPLESAML_SOURCE = $_SESSION["saml_login_source"];

		// after session is destroyed forward to saml logout
		elgg_register_plugin_hook_handler("forward", "system", "simplesaml_forward_hook");
	}
}

/**
 * Hook on the forward function to make sure we can logout on SimpleSAML
 *
 * @param string $hook         'forward'
 * @param string $type         'system'
 * @param bool   $return_value the current url to forward to
 * @param array  $params       supplied params
 *
 * @return void
 */
function simplesaml_forward_hook($hook, $type, $return_value, $params) {
	global $SIMPLESAML_SESSION_BACKUP;
	global $SIMPLESAML_SOURCE;
	
	if (!elgg_is_logged_in()) {
		if (!empty($SIMPLESAML_SESSION_BACKUP) && !empty($SIMPLESAML_SOURCE)) {
			$_SESSION["SimpleSAMLphp_SESSION"] = $SIMPLESAML_SESSION_BACKUP;
	
			// do we have a logout source
			try {
				$source = new SimpleSAML_Auth_Simple($SIMPLESAML_SOURCE);
	
				// logout of the external source
				$source->logout(elgg_get_site_url());
			} catch (Exception $e) {
				// do nothing
			}
		}
	}
}
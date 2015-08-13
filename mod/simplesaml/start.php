<?php
/**
 * This file is included when the plugin gets initialized
 */
$css_url = 'mod/simplesaml/vendors/special.css';
elgg_register_css('special-saml', $css_url, 1);

elgg_register_event_handler("plugins_boot", "system", "simplesaml_plugins_boot");

/**
 * Called on the 'plugins_boot' 'system' event
 *
 * @return void
 */
function simplesaml_plugins_boot() {
	
	$path = elgg_get_plugin_setting("simplesamlphp_path", "simplesaml");
	if (!empty($path)) {
		
		if (file_exists($path . "/lib/_autoload.php")) {
			// register library
			elgg_register_library("simplesamlphp", $path . "/lib/_autoload.php");
			
			elgg_register_event_handler("init", "system", "simplesaml_init");
		}
	}
}

/**
 * Called on the 'init' 'system' event
 *
 * @return void
 */
function simplesaml_init() {
	// load libraries
	elgg_load_library("simplesamlphp");
	
	require_once(dirname(__FILE__) . "/lib/events.php");
	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");
	
	// check for force authentication
	elgg_extend_view("page/default", "simplesaml/force_authentication", 200);
	elgg_extend_view("page/walled_garden", "simplesaml/force_authentication", 200);
	
	// extend CSS/JS
	elgg_extend_view("js/admin", "js/simplesaml/admin");
	
	// allow login
	elgg_extend_view("forms/login", "simplesaml/login");
	
	// register page_handler for nice URL's
	elgg_register_page_handler("saml", "simplesaml_page_handler");
	
	// register widgets
	elgg_register_widget_type("simplesaml", elgg_echo("login"), elgg_echo("simplesaml:widget:description"), "index", true);
	
	// register events
	elgg_register_event_handler("login", "user", "simplesaml_login_event_handler");
	
	// register plugin hooks
	elgg_register_plugin_hook_handler("public_pages", "walled_garden", "simplesaml_walled_garden_hook");
	elgg_register_plugin_hook_handler("widget_url", "widget_manager", "simplesaml_widget_url_hook");
	elgg_register_plugin_hook_handler("setting", "plugin", "simplesaml_plugin_setting_save_hook");
	elgg_register_plugin_hook_handler("action", "logout", "simplesaml_logout_action_hook");
	
	// register actions
	elgg_register_action("simplesaml/register", dirname(__FILE__) . "/actions/register.php", "public");
	elgg_register_action("simplesaml/unlink", dirname(__FILE__) . "/actions/unlink.php");
}

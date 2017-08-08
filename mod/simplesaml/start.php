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
	
	$path = elgg_get_plugin_setting('simplesamlphp_path', 'simplesaml');
	if (empty($path)) {
		return;
	}
	
	if (!file_exists("{$path}/lib/_autoload.php")) {
		return;
	}
	
	// register library
	elgg_register_library('simplesamlphp', "{$path}/lib/_autoload.php");
	
	elgg_register_event_handler('init', 'system', 'simplesaml_init');
}

/**
 * Called on the 'init' 'system' event
 *
 * @return void
 */
function simplesaml_init() {
	// load libraries
	elgg_load_library('simplesamlphp');
	
	require_once(dirname(__FILE__) . '/lib/functions.php');
	
	// check for force authentication
	elgg_extend_view('page/default', 'simplesaml/force_authentication', 200);
	elgg_extend_view('page/walled_garden', 'simplesaml/force_authentication', 200);
	
	// allow login
	elgg_extend_view('forms/login', 'simplesaml/login');
	
	// register page_handler for nice URL's
	elgg_register_page_handler('saml', '\ColdTrick\SimpleSAML\PageHandler::saml');
	
	// register widgets
	elgg_register_widget_type('simplesaml', elgg_echo('login'), elgg_echo('simplesaml:widget:description'), ['index'], true);
	
	// register events
	elgg_register_event_handler('login:after', 'user', '\ColdTrick\SimpleSAML\Login::loginEvent');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', '\ColdTrick\SimpleSAML\WalledGarden::publicPages');
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\SimpleSAML\WidgetManager::widgetURL');
	elgg_register_plugin_hook_handler('setting', 'plugin', '\ColdTrick\SimpleSAML\PluginSettings::saveSetting');
	elgg_register_plugin_hook_handler('action', 'logout', '\ColdTrick\SimpleSAML\Logout::action');
	
	// register actions
	elgg_register_action('simplesaml/register', dirname(__FILE__) . '/actions/register.php', 'public');
	elgg_register_action('simplesaml/unlink', dirname(__FILE__) . '/actions/unlink.php');
}

<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");
require_once(dirname(__FILE__) . "/vendor/autoload.php");

// register default Elgg events
elgg_register_event_handler("init", "system", "html_email_handler_init");
elgg_register_event_handler("pagesetup", "system", "html_email_handler_pagesetup");

/**
 * Gets called during system initialization
 *
 * @return void
 */
function html_email_handler_init() {
	
	// register page_handler for nice URL's
	elgg_register_page_handler("html_email_handler", "html_email_handler_page_handler");
	
	// plugin hooks
	elgg_register_plugin_hook_handler("cron", "daily", "html_email_handler_daily_cron_hook");
	// Handler that takes care of sending emails as HTML
	elgg_register_plugin_hook_handler("email", "system", "html_email_handler_email_hook");
	
}

/**
 * Gets called during the pagesetup fase of the system
 *
 * @return void
 */
function html_email_handler_pagesetup() {
	
	// add a menu item to the Theming preview
	elgg_register_menu_item("theme_sandbox", array(
		"name" => "html_email_handler",
		"text" => elgg_echo("html_email_handler:theme_preview:menu"),
		"href" => "html_email_handler/test",
		"target" => "_blank"
	));
}

/**
 * The page handler for html_email_handler
 *
 * @param array $page the page elements
 *
 * @return bool
 */
function html_email_handler_page_handler($page) {
	$result = false;

	switch ($page[0]) {
		case "test":
			$result = true;
			include(dirname(__FILE__) . "/pages/test.php");
			break;
	}

	return $result;
}

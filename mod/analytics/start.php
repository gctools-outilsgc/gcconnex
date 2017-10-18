<?php
/**
* Analytics startup file
*
* @package analytics
* @author ColdTrick IT Solutions
* @link http://www.coldtrick.com/
*/

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default elgg event
elgg_register_event_handler('init', 'system', 'analytics_init');

/**
 * Gets called during system initialization
 *
 * @return void
 */
function analytics_init() {
	// load Google Analytics JS
	elgg_extend_view('page/elements/head', 'analytics/head/google', 999);
	elgg_extend_view('page/elements/head', 'analytics/head/piwik', 999);
	
	// extend the page footer
	elgg_extend_view('page/elements/foot', 'analytics/footer', 999);
	
	// register page handler
	elgg_register_page_handler('analytics', '\ColdTrick\Analytics\PageHandler::analytics');
	
	// register tracking events
	elgg_register_event_handler('all', 'object', '\ColdTrick\Analytics\Tracker::events');
	elgg_register_event_handler('all', 'group', '\ColdTrick\Analytics\Tracker::events');
	elgg_register_event_handler('all', 'user', '\ColdTrick\Analytics\Tracker::events');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('action', 'all', '\ColdTrick\Analytics\Tracker::actions');
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', '\ColdTrick\Analytics\Site::publicPages');
	
}

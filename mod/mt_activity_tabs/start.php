<?php

namespace AU\ActivityTabs;

const PLUGIN_ID = 'mt_activity_tabs';
const PLUGIN_VERSION = 20151017;

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/events.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

/*
 * Plugin Init
 */

function init() {
	// add our own css
	elgg_extend_view('css/elgg', 'css/activity_tabs');

	elgg_register_page_handler('activity_tabs', __NAMESPACe__ . '\\activity_tabs_pagehandler');
	

	// default menu items are registered with relative paths
	// need to change it due to different page handlers
	elgg_register_plugin_hook_handler('register', 'menu:filter', __NAMESPACE__ . '\\filtermenu_hook');

	// set user activity link on menu:user_hover dropdown
	$user_activity = elgg_get_plugin_setting('user_activity', 'mt_activity_tabs');

	if ($user_activity != 'no') {
		elgg_register_plugin_hook_handler('register', 'menu:user_hover', __NAMESPACE__ . '\\user_hover_hook');
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', __NAMESPACE__ . '\\user_hover_hook');
	}
	
	elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\pagesetup');
	elgg_register_event_handler('upgrade', 'system', __NAMESPACE__ . '\\upgrades');
}

//
// page handler function
function activity_tabs_pagehandler($page) {

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	
	$filter_context = $page[0] . '_' . $page[1];

	// set guid
	if ($page[0] == 'user') {
		$guid = get_user_by_username($page[1])->guid;
	} else {
		$guid = $page[1];
	}
	set_input('filter_context', $filter_context);
	
	$content = elgg_view('resources/activity_tabs/activity_tabs', array(
		'guid' => $guid,
		'page_type' => $page[0]
	));

	if ($content) {
		echo $content;
		return true;
	}

	return false;
}

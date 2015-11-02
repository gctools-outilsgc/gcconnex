<?php
/**
 * Activity
 * 
 * @package Activity
 */

function activity_init () {
	elgg_register_library('elgg:activity', elgg_get_plugins_path() . 'activity/lib/activity.php');
	
	$actionspath = elgg_get_plugins_path() . 'activity/actions/activity';
	elgg_register_action('activity/blog/save', "$actionspath/blog/save.php");
	
	// Replace the default page handler
	elgg_unregister_page_handler('activity');
	elgg_register_page_handler('activity', 'activity_page_handler');
}

function activity_page_handler ($page) {
	global $CONFIG;

	elgg_load_library('elgg:activity');

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	// make a URL segment available in page handler script
	$page_type = elgg_extract(0, $page, 'all');
	$page_type = preg_replace('[\W]', '', $page_type);
	if ($page_type == 'owner') {
		$page_type = 'mine';
	}
	set_input('page_type', $page_type);

	echo activity_view_page();
	return true;
}

elgg_register_event_handler('init', 'system', 'activity_init');

<?php
/*
 * GC Mobile API start.php
 */

elgg_register_event_handler('init', 'system', 'gc_mobile_api_init');

function gc_mobile_api_init()
{
	elgg_unregister_plugin_hook_handler('output:before', 'page', '_elgg_views_send_header_x_frame_options');

	include elgg_get_plugins_path() . "gc_mobile_api/inc/functions.php";

	$models = array('blog', 'discussion', 'doc', 'event', 'file', 'group', 'like', 'login', 'members', 'message', 'opportunity', 'register', 'user', 'wire', 'bookmark', 'test');
	foreach ($models as $model) {
		include elgg_get_plugins_path() . "gc_mobile_api/models/$model.php";
	}
}

<?php
/*
 * GC Invitation API start.php
 */

elgg_register_event_handler('init', 'system', 'gc_invite_api_init');

function gc_invite_api_init()
{
	elgg_unregister_plugin_hook_handler('output:before', 'page', '_elgg_views_send_header_x_frame_options');
	include elgg_get_plugins_path() . 'gc_invite_api/actions/invite.php';
}

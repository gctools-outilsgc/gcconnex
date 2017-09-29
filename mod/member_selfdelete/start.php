<?php

namespace Beck24\MemberSelfDelete;

const PLUGIN_ID = 'member_selfdelete';

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/events.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {

	// prevent people from seeing the profile of disabled users
	elgg_extend_view('profile/details', 'member_selfdelete/pre_userdetails', 0);

	elgg_register_page_handler('selfdelete', __NAMESPACE__ . '\\selfdelete_page_handler');

	elgg_register_action("selfdelete", __DIR__ . "/actions/delete.php");
	elgg_register_action('selfdelete/feedback/delete', __DIR__ . '/actions/feedback/delete.php', 'admin');

	elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\pagesetup');

	elgg_register_plugin_hook_handler('register', 'menu:user_hover', __NAMESPACE__ . '\\hover_menu', 1000);
	elgg_register_plugin_hook_handler('email', 'system', __NAMESPACE__ . '\\email_system', 0);
}

function selfdelete_page_handler($page) {
	if (!include(elgg_get_plugins_path() . "member_selfdelete/pages/form.php")) {
		return FALSE;
	}
	return TRUE;
}

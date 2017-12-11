<?php

namespace Beck24\MemberSelfDelete;

const PLUGIN_ID = 'member_selfdelete';

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/events.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {

	// prevent people from seeing the profile of disabled users
	elgg_extend_view('profile/details', 'member_selfdelete/pre_userdetails', 0);

	elgg_extend_view('forms/account/settings','member_selfdelete/deactivate_settings');

	elgg_register_page_handler('selfdelete', __NAMESPACE__ . '\\selfdelete_page_handler');
	elgg_register_page_handler('gcreactivate',__NAMESPACE__ . '\\gcreactivate_page_handler');

	elgg_register_action("selfdelete", __DIR__ . "/actions/delete.php");
	elgg_register_action('selfdelete/feedback/delete', __DIR__ . '/actions/feedback/delete.php', 'admin');

	elgg_register_action('selfdelete/reactivate_toggle', __DIR__ .'/actions/reactivate_toggle.php');
    elgg_register_action('selfdelete/changegroupowner', __DIR__ . '/actions/changegroupowner.php');
	elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\pagesetup');

	elgg_register_plugin_hook_handler('register', 'menu:user_hover', __NAMESPACE__ . '\\hover_menu', 1000);
	elgg_register_plugin_hook_handler('email', 'system', __NAMESPACE__ . '\\email_system', 0);

	elgg_register_event_handler("create", "friendrequest", "friend_request_deactivated_user");

	elgg_register_event_handler('login:before', 'user', 'gc_deactivated_login', 501);
}

function selfdelete_page_handler($page) {
	if (!include(elgg_get_plugins_path() . "member_selfdelete/pages/form.php")) {
		return FALSE;
	}
	return TRUE;
}
function gcreactivate_page_handler($page) {
	if (!include(elgg_get_plugins_path() . "member_selfdelete/pages/reactivate.php")) {
		return FALSE;
	}
	return TRUE;
}

function friend_request_deactivated_user($event, $object_type, $object){
		$user = get_user($object->guid_two);
		if($user->gcdeactivated = true){
			system_message('this user is also deactivated');
		}
		system_message('is this even doing anything?');
}
function gc_deactivated_login($event, $type, $user){
	if(($user instanceof ElggUser) && $user->gcdeactivate == true){
		return FALSE;
		throw new LoginException(elgg_echo('uservalidationbyemail:login:fail'));
	
	}
	//return TRUE;
	throw new LoginException(elgg_echo('uservalidationbyemail:login:fail'));
	return FALSE;

}

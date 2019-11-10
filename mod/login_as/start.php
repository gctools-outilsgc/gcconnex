<?php
/**
 * Provides an entry in the user hover menu for admins to login as the user.
 */

elgg_register_event_handler('init', 'system', 'login_as_init');

/**
 * Init
 */
function login_as_init() {

	// user hover menu and topbar links.
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'login_as_user_hover_menu');
	elgg_register_event_handler('pagesetup', 'system', 'login_as_add_topbar_link');
	elgg_extend_view('css/elgg', 'login_as/css');

	$action_path = dirname(__FILE__) . '/actions/';
	elgg_register_action('login_as', $action_path . 'login_as.php', 'admin');
	elgg_register_action('logout_as', $action_path . 'logout_as.php');
}

/**
 * Add Login As to user hover menu for admins
 *
 * @param string $hook
 * @param string $type
 * @param array  $menu
 * @param array  $params
 */
function login_as_user_hover_menu($hook, $type, $menu, $params) {
	$user = $params['entity'];
	$logged_in_user = elgg_get_logged_in_user_entity();

	// Don't show menu on self.
	if ($logged_in_user == $user) {
		return $menu;
	}

	$url = "action/login_as?user_guid=$user->guid";
	$menu[] = ElggMenuItem::factory(array(
		'name' => 'login_as',
		'text' => elgg_echo('login_as:login_as'),
		'href' => $url,
		'is_action' => true,
		'section' => 'admin'
	));

	return $menu;
}

/**
 * Add a menu item to the topbar menu for logging out of an account
 */
function login_as_add_topbar_link() {
	$session = elgg_get_session();

	$original_user_guid = $session->get('login_as_original_user_guid');

	// short circuit view if not logged in as someone else.
	if (!$original_user_guid) {
		return;
	}

	$title = elgg_echo('login_as:return_to_user', array(
		elgg_get_logged_in_user_entity()->username,
		get_entity($original_user_guid)->username
	));

	$html = elgg_view('login_as/topbar_return', array('user_guid' => $original_user_guid));
	elgg_register_menu_item('topbar', array(
		'name' => 'login_as_return',
		'text' => $html,
		'href' => 'action/logout_as',
		'is_action' => true,
		'title' => $title,
		'link_class' => 'login-as-topbar',
		'priority' => 700,
	));
}

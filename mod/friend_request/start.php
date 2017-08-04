<?php
/**
 * The main plugin file for Friend Request
 */

// load library files
require_once(dirname(__FILE__) . '/lib/functions.php');

// default event handlers
elgg_register_event_handler('init', 'system', 'friend_request_init');

/**
 * Gets called during system initialization
 *
 * @return void
 */
function friend_request_init() {
	// extend css
	elgg_extend_view('css/elgg', 'css/friend_request/site');
	
	// Page handlers
	// unregister friendsof
	elgg_register_page_handler('friendsof', '\ColdTrick\FriendRequest\PageHandler::friendsofForward');
	
	// This will let users view their friend requests
	elgg_register_page_handler('friend_request', '\ColdTrick\FriendRequest\PageHandler::friendRequest');
	
	// Events
	// unregister default elgg friend handler
	elgg_unregister_event_handler('create', 'relationship', '_elgg_send_friend_notification');
	// Handle our add action event
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\FriendRequest\Relationships::createFriendRequest');
	
	// Plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:topbar', '\ColdTrick\FriendRequest\TopbarMenu::register');
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\FriendRequest\PageMenu::registerCleanup');
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\FriendRequest\PageMenu::register');
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', '\ColdTrick\FriendRequest\Users::registerUserHoverMenu');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\FriendRequest\Users::registerEntityMenu');
	
	// Actions
	// This overwrites the original friend requesting stuff.
	elgg_register_action('friends/add', dirname(__FILE__) . '/actions/friends/add.php');
	// We need to override the friend remove action to remove the relationship we created
	elgg_register_action('friends/remove', dirname(__FILE__) . '/actions/friends/removefriend.php');
	
	// friend request actions
	elgg_register_action('friend_request/approve', dirname(__FILE__) . '/actions/approve.php');
	elgg_register_action('friend_request/decline', dirname(__FILE__) . '/actions/decline.php');
	elgg_register_action('friend_request/revoke', dirname(__FILE__) . '/actions/revoke.php');
	
}
	
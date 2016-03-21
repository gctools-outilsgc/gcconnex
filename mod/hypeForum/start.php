<?php

/* hypeForum
 *
 * Forum functionality for Elgg
 * @package hypeJunction
 * @subpackage hypeForum
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 * @copyright Copyright (c) 2011-2013, Ismayil Khayredinov
 */

define('HYPEFORUM_RELEASE', 1372438394);

define('HYPEFORUM_CATEGORIES', elgg_get_plugin_setting('categories', 'hypeForum'));
define('HYPEFORUM_CATEGORIES_TOP', elgg_get_plugin_setting('categories_top', 'hypeForum'));
define('HYPEFORUM_SUBFORUMS', elgg_get_plugin_setting('subforums', 'hypeForum'));
define('HYPEFORUM_STICKY', elgg_get_plugin_setting('forum_sticky', 'hypeForum'));
define('HYPEFORUM_FORUM_COVER', elgg_get_plugin_setting('forum_cover', 'hypeForum'));
define('HYPEFORUM_FORUM_TOPIC_COVER', elgg_get_plugin_setting('forum_topic_cover', 'hypeForum'));
define('HYPEFORUM_FORUM_TOPIC_ICON', elgg_get_plugin_setting('forum_topic_icon', 'hypeForum'));
define('HYPEFORUM_FORUM_RIVER', elgg_get_plugin_setting('forum_forum_river', 'hypeForum'));
define('HYPEFORUM_TOPIC_RIVER', elgg_get_plugin_setting('forum_topic_river', 'hypeForum'));
define('HYPEFORUM_POST_RIVER', elgg_get_plugin_setting('forum_post_river', 'hypeForum'));
define('HYPEFORUM_BOOKMARKS', elgg_get_plugin_setting('forum_bookmarks', 'hypeForum'));
define('HYPEFORUM_SUBSCRIPTIONS', elgg_get_plugin_setting('forum_subscriptions', 'hypeForum'));
define('HYPEFORUM_GROUP_FORUMS', elgg_get_plugin_setting('forum_group_forums', 'hypeForum'));
define('HYPEFORUM_USER_SIGNATURE', elgg_get_plugin_setting('forum_user_signature', 'hypeForum'));

elgg_register_event_handler('init', 'system', 'hj_forum_init');

function hj_forum_init() {
	$plugin = 'hypeForum';

	// Make sure hypeFramework is active and precedes hypeForum in the plugin list
	if (!is_callable('hj_framework_path_shortcuts')) {
		register_error(elgg_echo('framework:error:plugin_order', array($plugin)));
		disable_plugin($plugin);
		forward('admin/plugins');
	}

	// Run upgrade scripts
	hj_framework_check_release($plugin, HYPEFORUM_RELEASE);

	$shortcuts = hj_framework_path_shortcuts($plugin);

	// Helper Classes
	elgg_register_classes($shortcuts['classes']);

	// Libraries
	$libraries = array(
		'base',
		'forms',
		'page_handlers',
		'actions',
		'assets',
		'views',
		'menus',
		'hooks'
	);

	foreach ($libraries as $lib) {
		$path = "{$shortcuts['lib']}{$lib}.php";
		if (file_exists($path)) {
			elgg_register_library("forum:library:$lib", $path);
			elgg_load_library("forum:library:$lib");
		}
	}

	// Search
	elgg_register_entity_type('object', 'hjforum');
	elgg_register_entity_type('object', 'hjforumtopic');
	elgg_register_entity_type('object', 'hjforumpost');

	if (HYPEFORUM_GROUP_FORUMS) {
		// Add group option
		add_group_tool_option('forums', elgg_echo('hj:forum:groupoption:enableforum'), false);
		elgg_extend_view('groups/tool_latest', 'framework/forum/group_module');
	}

	// Notification
	//register_notification_object('object', 'hjforumtopic', elgg_echo('hj:forum:newforumtopic'));
	//register_notification_object('object', 'hjforumpost', elgg_echo('hj:forum:newforumpost'));
	//elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'hj_forum_notify_message');
	
}
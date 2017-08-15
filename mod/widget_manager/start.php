<?php

define('ACCESS_LOGGED_OUT', -5);

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'widget_manager_init');
elgg_register_event_handler('init', 'system', 'widget_manager_init_group');

/**
 * Used to perform initialization of the widget manager features.
 *
 * @return void
 */
function widget_manager_init() {
	
	$base_dir = dirname(__FILE__);
	
	// check valid WidgetManagerWidget class
	if (get_subtype_class('object', 'widget') == 'ElggWidget') {
		update_subtype('object', 'widget', 'WidgetManagerWidget');
	}
	
	elgg_register_plugin_hook_handler('widget_settings', 'all', '\ColdTrick\WidgetManager\Cache::clearWidgetCacheOnSettingsSave');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('access:collections:write', 'all', 'widget_manager_write_access_hook', 999);
	elgg_register_plugin_hook_handler('access:collections:read', 'user', 'widget_manager_read_access_hook');
	
	elgg_register_plugin_hook_handler('register', 'menu:widget', '\ColdTrick\WidgetManager\Menus::addFixDefaultWidgetMenuItem');
	elgg_register_plugin_hook_handler('prepare', 'menu:widget', '\ColdTrick\WidgetManager\Menus::prepareWidgetEditDeleteMenuItems');
	
	elgg_register_plugin_hook_handler('advanced_context', 'widget_manager', '\ColdTrick\WidgetManager\Context::addExtraContextsToAdvancedContexts');
	elgg_register_plugin_hook_handler('available_widgets_context', 'widget_manager', '\ColdTrick\WidgetManager\Context::addExtraContextsAsAvailableWidgetsContext');
	
	elgg_register_plugin_hook_handler('permissions_check', 'widget_layout', 'widget_manager_widget_layout_permissions_check');
	
	elgg_register_plugin_hook_handler('handlers', 'widgets', '\ColdTrick\WidgetManager\Widgets::addExtraContextsWidgets', 9980);
	elgg_register_plugin_hook_handler('handlers', 'widgets', '\ColdTrick\WidgetManager\Widgets::fixAllContext', 9990);
	elgg_register_plugin_hook_handler('handlers', 'widgets', '\ColdTrick\WidgetManager\Widgets::applyWidgetsConfig', 9999);
	
	// extend CSS
	elgg_extend_view('css/elgg', 'css/widget_manager/site.css');
	elgg_extend_view('css/elgg', 'css/widget_manager/global.css');
	
	elgg_extend_view('css/admin', 'css/widget_manager/admin.css');
	elgg_extend_view('css/admin', 'css/widget_manager/global.css');
	
	elgg_extend_view('js/elgg', 'js/widget_manager/site.js');
	
	// register a widget title url handler
	// core widgets
	elgg_register_plugin_hook_handler('entity:url', 'object', 'widget_manager_widgets_url');

	// index page
	elgg_register_plugin_hook_handler('route', 'all', '\ColdTrick\WidgetManager\Router::routeIndex');
			
	// add extra widget pages
	$extra_contexts = elgg_get_plugin_setting('extra_contexts', 'widget_manager');
	if ($extra_contexts) {
		$contexts = string_to_tag_array($extra_contexts);
		if ($contexts) {
			foreach ($contexts as $context) {
				elgg_register_page_handler($context, '\ColdTrick\WidgetManager\PageHandlers::extraContexts');
			}
		}
	}
		
	elgg_register_plugin_hook_handler('action', 'plugins/settings/save', 'widget_manager_plugins_settings_save_hook_handler');
	elgg_register_plugin_hook_handler('action', 'widgets/add', 'widget_manager_widgets_action_hook_handler');
	elgg_register_plugin_hook_handler('action', 'widgets/move', 'widget_manager_widgets_action_hook_handler');
	
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'widget_manager_permissions_check_object_hook_handler');

	elgg_register_plugin_hook_handler('view_vars', 'admin/appearance/default_widgets', '\ColdTrick\WidgetManager\DefaultWidgets::defaultWidgetsViewVars');
	elgg_register_plugin_hook_handler('view_vars', 'page/layouts/widgets', '\ColdTrick\WidgetManager\Layouts::checkFixedWidgets');

	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\WidgetManager\Menus::registerAdminPageMenu');
	
	elgg_register_event_handler('create', 'object', '\ColdTrick\WidgetManager\Widgets::fixPrivateAccess');

	elgg_register_event_handler('cache:flush', 'system', '\ColdTrick\WidgetManager\Cache::resetWidgetsCache');
	
	elgg_register_event_handler('all', 'object', '\ColdTrick\WidgetManager\Widgets::createFixedParentMetadata', 1000); // is only a fallback

	elgg_register_ajax_view('page/layouts/widgets/add_panel');
	elgg_register_ajax_view('widget_manager/widgets/settings');
	elgg_register_ajax_view('widgets/user_search/content');
	
	// register actions
	elgg_register_action('widget_manager/manage_widgets', $base_dir . '/actions/manage_widgets.php', 'admin');
	elgg_register_action('widget_manager/widgets/toggle_fix', $base_dir . '/actions/widgets/toggle_fix.php', 'admin');
	elgg_register_action('widget_manager/force_tool_widgets', $base_dir . '/actions/force_tool_widgets.php', 'admin');
	elgg_register_action('widget_manager/widgets/toggle_collapse', $base_dir . '/actions/widgets/toggle_collapse.php');
}

/**
 * Used to perform initialization of the group widgets features.
 *
 * @return void
 */
function widget_manager_init_group() {
	if (!elgg_is_active_plugin('groups')) {
		return;
	}
	
	$group_enable = elgg_get_plugin_setting('group_enable', 'widget_manager');
	if (!in_array($group_enable, ['yes', 'forced'])) {
		return;
	}
	
	$base_dir = dirname(__FILE__);

	elgg_extend_view('groups/edit', 'widget_manager/forms/groups_widget_access');
	elgg_register_action('widget_manager/groups/update_widget_access', $base_dir . '/actions/groups/update_widget_access.php');
		
	// cleanup widgets in group context
	elgg_extend_view('page/layouts/widgets/add_panel', 'widget_manager/group_tool_widgets', 400);
		
	if ($group_enable == 'yes') {
		// add the widget manager tool option
		$group_option_enabled = false;
		if (elgg_get_plugin_setting('group_option_default_enabled', 'widget_manager') == 'yes') {
			$group_option_enabled = true;
		}

		if (elgg_get_plugin_setting('group_option_admin_only', 'widget_manager') != 'yes') {
			// add the tool option for group admins
			add_group_tool_option('widget_manager', elgg_echo('widget_manager:groups:enable_widget_manager'), $group_option_enabled);
		} elseif (elgg_is_admin_logged_in()) {
			add_group_tool_option('widget_manager', elgg_echo('widget_manager:groups:enable_widget_manager'), $group_option_enabled);
		} elseif ($group_option_enabled) {
			// register event to make sure newly created groups have the group option enabled
			elgg_register_event_handler('create', 'group', '\ColdTrick\WidgetManager\Groups::setGroupToolOption');
		}
	}
		
	// register event to make sure all groups have the group option enabled if forces
	// and configure tool enabled widgets
	elgg_register_event_handler('update', 'group', '\ColdTrick\WidgetManager\Groups::updateGroupWidgets');
		
	// make default widget management available
	elgg_register_plugin_hook_handler('get_list', 'default_widgets', '\ColdTrick\WidgetManager\DefaultWidgets::addGroupsContextToDefaultWidgets');
}

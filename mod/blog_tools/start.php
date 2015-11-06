<?php
/**
 * The main file for this plugin
 */

require_once(dirname(__FILE__) . "/lib/functions.php");

// register default elgg events
elgg_register_event_handler("init", "system", "blog_tools_init");

/**
 * This function gets called during the system initialization
 *
 * @return void
 */
function blog_tools_init() {
	
	// extend css
	elgg_extend_view("css/elgg", "css/blog_tools/site");
	elgg_extend_view("js/elgg", "js/blog_tools/site");
	
	// extra blog views
	elgg_extend_view("object/blog", "blog_tools/full/navigation");
	elgg_extend_view("object/blog", "blog_tools/full/owner");
	elgg_extend_view("object/blog", "blog_tools/full/related");
	elgg_extend_view("blog/sidebar", "blog_tools/full/related");
		
	// register event handlers
	elgg_register_event_handler("delete", "object", array("\ColdTrick\BlogTools\DeleteHandler", "cleanupBlogIcon"));
	
	// register plugin hook handlers
	elgg_register_plugin_hook_handler("entity:url", "object", array("\ColdTrick\BlogTools\Widgets", "widgetUrl"));
	elgg_register_plugin_hook_handler("cron", "daily", array("\ColdTrick\BlogTools\Cron", "daily"));
	elgg_register_plugin_hook_handler("entity:icon:url", "object", array("\ColdTrick\BlogTools\EntityIcon", "blogIcon"));
	elgg_register_plugin_hook_handler("route", "blog", array("\ColdTrick\BlogTools\Router", "blog"));
	elgg_register_plugin_hook_handler("register", "menu:entity", array("\ColdTrick\BlogTools\EntityMenu", "register"));
	elgg_register_plugin_hook_handler("group_tool_widgets", "widget_manager", array("\ColdTrick\BlogTools\Widgets", "groupTools"));
	elgg_register_plugin_hook_handler("permissions_check:comment", "object", array("\ColdTrick\BlogTools\Access", "blogCanComment"));
	
	// extend editmenu
	elgg_extend_view("editmenu", "blog_tools/editmenu");
	
	// add featured filter menu item
	elgg_register_menu_item("filter", ElggMenuItem::factory(array(
		"name" => "featured",
		"text" => elgg_echo("blog_tools:menu:filter:featured"),
		"context" => "blog",
		"href" => "blog/featured",
		"priority" => 600
	)));
	
	// register index widget
	elgg_register_widget_type("index_blog", elgg_echo("blog"), elgg_echo("blog_tools:widgets:index_blog:description"), array("index"), true);
	elgg_register_widget_type("blog", elgg_echo("blog"), elgg_echo("blog:widget:description"), array("profile", "dashboard", "groups"));
	
	// overrule blog actions
	elgg_register_action("blog/save", dirname(__FILE__) . "/actions/blog/save.php");
	elgg_register_action("blog/auto_save_revision", dirname(__FILE__) . "/actions/blog/auto_save_revision.php");
	
	// register actions
	elgg_register_action("blog_tools/toggle_metadata", dirname(__FILE__) . "/actions/toggle_metadata.php", "admin");
	
}

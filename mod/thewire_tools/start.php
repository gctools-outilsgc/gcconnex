<?php
/**
 * Start file for the plugin, is loaded when all active plugins are loaded
 *
 * @package thewire_tools
 */

require_once(dirname(__FILE__) . "/lib/events.php");
require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");

// register default Elgg events
elgg_register_event_handler("init", "system", "thewire_tools_init");
elgg_register_event_handler("pagesetup", "system", "thewire_tools_pagesetup");

/**
 * This function is called during the "init" event
 *
 * @return void
 */
function thewire_tools_init() {
	
	elgg_extend_view("js/elgg", "thewire_tools/js/site");
	elgg_extend_view("css/elgg", "thewire_tools/css/site");
		
	// overrule url handler
	elgg_register_entity_url_handler("thewire_tools_url_handler", "object", "thewire");
		
	if (thewire_tools_groups_enabled()) {
		// add widget (for Widget Manager only)
		elgg_register_widget_type("thewire_groups", elgg_echo("widgets:thewire_groups:title"), elgg_echo("widgets:thewire_groups:description"), "groups", true);
		
		// add group tool option
		add_group_tool_option("thewire", elgg_echo("thewire_tools:groups:tool_option"), true);
		
		// add a menu item to the owner block
		elgg_register_plugin_hook_handler("register", "menu:owner_block", "thewire_tools_owner_block_menu");
	}
	
	// adds wire post form to the wire widget
	elgg_extend_view("widgets/thewire/content", "thewire_tools/thewire_post", 400);
	elgg_extend_view("widgets/index_thewire/content", "thewire_tools/thewire_post", 400);
	elgg_extend_view("core/river/filter", "thewire_tools/activity_post", 400);
	elgg_extend_view("page/layouts/content", "thewire_tools/group_activity", 400);
	
	// add some extra widgets (for Widget Manager only)
	elgg_register_widget_type("index_thewire", elgg_echo("widgets:index_thewire:title"), elgg_echo("widgets:index_thewire:description"), "index", true);
	elgg_register_widget_type("thewire_post", elgg_echo("widgets:thewire_post:title"), elgg_echo("widgets:thewire_post:description"), "index,dashboard", false);
	
	// register events
	elgg_register_event_handler("create", "object", "thewire_tools_create_object_event_handler", 100);
	
	// register hooks
	elgg_register_plugin_hook_handler("route", "thewire", "thewire_tools_route_thewire");
	elgg_register_plugin_hook_handler("access:collections:write", "all", "thewire_tools_access_write_hook", 999);
	elgg_register_plugin_hook_handler("forward", "all", "thewire_tools_forward_hook");
	
	elgg_register_plugin_hook_handler("widget_url", "widget_manager", "thewire_tools_widget_title_url");
	
	elgg_register_plugin_hook_handler("register", "menu:entity", "thewire_tools_register_entity_menu_items");
	elgg_register_plugin_hook_handler("register", "menu:river", "thewire_tools_register_river_menu_items");
	
	// upgrade function
	run_function_once("thewire_tools_runonce");
	
	// overrule default save action
	elgg_unregister_action("thewire/add");
	elgg_register_action("thewire/add", dirname(__FILE__) . "/actions/thewire/add.php");
}

/**
 * This function is called during the "pagesetup" event
 *
 * @return void
 */
function thewire_tools_pagesetup() {
	$page_owner = elgg_get_page_owner_entity();
	
	if (!empty($page_owner) && elgg_instanceof($page_owner, "group")) {
		// cleanup group widget
		if ($page_owner->thewire_enable == "no") {
			elgg_unregister_widget_type("thewire_groups");
		}
	} else {
		
		if ($user = elgg_get_logged_in_user_entity()) {
			elgg_register_menu_item("page", array(
				"name" => "mentions",
				"href" => "thewire/search/@" . $user->username,
				"text" => elgg_echo("thewire_tools:menu:mentions"),
				"context" => "thewire"
			));
		}
		
		elgg_register_menu_item("page", array(
			"name" => "search",
			"href" => "thewire/search",
			"text" => elgg_echo("search"),
			"context" => "thewire"
		));
	}
}

/**
 * Custom URL handler for thewire objects
 *
 * @param ElggEntity $entity the entity to make the URL for
 *
 * @return string the URL
 */
function thewire_tools_url_handler(ElggEntity $entity) {
	if ($entity->getContainerEntity() instanceof ElggGroup) {
		$entity_url = elgg_get_site_url() . "thewire/group/" . $entity->getContainer();
	} else {
		$entity_url = elgg_get_site_url() . "thewire/owner/" . $entity->getOwnerEntity()->username;
	}
	
	return $entity_url;
}

/**
 * Runonce to convert the pre Elgg 1.8 wire tools conversations to the new wire_threads
 *
 * @return void
 */
function thewire_tools_runonce() {
	$conversation_id = add_metastring("conversation");
	$wire_thread_id = add_metastring("wire_thread");
	$subtype_id = get_subtype_id("object", "thewire");
	
	$query = "UPDATE " . elgg_get_config("dbprefix") . "metadata SET name_id = " . $wire_thread_id;
	$query .= " WHERE name_id = " . $conversation_id . " AND entity_guid IN";
	$query .= " (SELECT guid FROM " . elgg_get_config("dbprefix") . "entities WHERE type = 'object' AND subtype = " . $subtype_id . ")";

	update_data($query);
}

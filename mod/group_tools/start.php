<?php

	// define for default group access
	define("GROUP_TOOLS_GROUP_ACCESS_DEFAULT", -10);

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/events.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");

	function group_tools_init(){
		
		// extend css & js
		elgg_extend_view("css/elgg", "css/group_tools/site");
		elgg_extend_view("js/elgg", "js/group_tools/site");
		elgg_extend_view("js/admin", "js/group_tools/admin");
		
		elgg_register_simplecache_view("css/group_tools/autocomplete");
		elgg_register_css("group_tools.autocomplete", elgg_get_simplecache_url("css", "group_tools/autocomplete"));
		
		// extend groups page handler
		elgg_register_plugin_hook_handler("route", "groups", "group_tools_route_groups_handler");
		
		// hook on title menu
		elgg_register_plugin_hook_handler("register", "menu:title", "group_tools_menu_title_handler");
		elgg_register_plugin_hook_handler("register", "menu:user_hover", "group_tools_menu_user_hover_handler");
		elgg_register_plugin_hook_handler("register", "menu:entity", "group_tools_menu_entity_handler");
		
		if(elgg_get_plugin_setting("multiple_admin", "group_tools") == "yes"){
			// add group tool option
			add_group_tool_option("group_multiple_admin_allow", elgg_echo("group_tools:multiple_admin:group_tool_option"), false);
			
			// register permissions check hook
			elgg_register_plugin_hook_handler("permissions_check", "group", "group_tools_multiple_admin_can_edit_hook");
			
			// register on group leave
			elgg_register_event_handler("leave", "group", "group_tools_multiple_admin_group_leave");
            
			//notify admin on membership request
			elgg_register_event_handler('create', 'membership_request', 'group_tools_membership_request');
		}
		
		// register group activity widget
		// 2012-05-03: restored limited functionality of group activity widget, will be fully restored if Elgg fixes widget settings
		elgg_register_widget_type("group_river_widget", elgg_echo("widgets:group_river_widget:title"), elgg_echo("widgets:group_river_widget:description"), "dashboard,profile,index,groups", true);
		
		// register group members widget
		elgg_register_widget_type("group_members", elgg_echo("widgets:group_members:title"), elgg_echo("widgets:group_members:description"), "groups", false);
		
		// register groups invitations widget
		elgg_register_widget_type("group_invitations", elgg_echo("widgets:group_invitations:title"), elgg_echo("widgets:group_invitations:description"), "index,dashboard", false);
		
		// register featured groups widget
		elgg_register_widget_type("featured_groups", elgg_echo("groups:featured"), elgg_echo("widgets:featured_groups:description"), "index");
		
		// register index groups widget
		elgg_register_widget_type("index_groups", elgg_echo("groups"), elgg_echo("widgets:index_groups:description"), "index", true);
		
		// quick start discussion
		elgg_register_widget_type("start_discussion", elgg_echo("group_tools:widgets:start_discussion:title"), elgg_echo("group_tools:widgets:start_discussion:description"), "index,dashboard,groups");
		
		// group invitation
		elgg_register_action("groups/invite", dirname(__FILE__) . "/actions/groups/invite.php");
		
		// manage auto join for groups
		elgg_extend_view("groups/edit", "group_tools/forms/special_states", 350);
		elgg_register_event_handler("create", "member_of_site", "group_tools_join_site_handler");
		
		// show group edit as tabbed
		elgg_extend_view("groups/edit", "group_tools/group_edit_tabbed", 1);
		elgg_extend_view("groups/edit", "group_tools/group_edit_tabbed_js", 999999999);
		
		// show group profile widgets - edit form
		elgg_extend_view("groups/edit", "group_tools/forms/profile_widgets", 400);
		
		// cleanup group side menu
		elgg_extend_view("groups/edit", "group_tools/forms/cleanup", 450);
		
		// group default access
		elgg_extend_view("groups/edit", "group_tools/forms/default_access");
		
		// group notifications
		elgg_extend_view("groups/edit", "group_tools/forms/notifications", 375);
		
		// allow group members to invite new members
		elgg_extend_view("groups/edit", "group_tools/forms/invite_members", 475);
		
		// show group status in owner block
		elgg_extend_view("page/elements/owner_block/extend", "group_tools/owner_block");
		// show group status in stats (on group profile)
		elgg_extend_view("groups/profile/summary", "group_tools/group_stats");
		
		if(elgg_is_active_plugin("blog")){
			elgg_register_widget_type('group_news', elgg_echo('widgets:group_news:title'), elgg_echo('widgets:group_news:description'), "profile,index,dashboard", true);
			elgg_extend_view("css/elgg", "widgets/group_news/css");
			elgg_extend_view("js/elgg", "widgets/group_news/js");
		}
		
		if(elgg_is_admin_logged_in()){
			run_function_once("group_tools_version_1_3");
		}
		
		// register index widget to show latest discussions
		elgg_register_widget_type("discussion", elgg_echo("discussion:latest"), elgg_echo("widgets:discussion:description"), "index,dashboard", true);
		elgg_register_widget_type("group_forum_topics", elgg_echo("discussion:group"), elgg_echo("widgets:group_forum_topics:description"), "groups");
		
		// register events
		elgg_register_event_handler("join", "group", "group_tools_join_group_event");
		
		// register plugin hooks
		elgg_register_plugin_hook_handler("widget_url", "widget_manager", "group_tools_widget_url_handler");
		elgg_register_plugin_hook_handler("access:default", "user", "group_tools_access_default_handler");
		elgg_register_plugin_hook_handler("access:collections:write", "user", "group_tools_access_write_handler");
		
		// actions
		elgg_register_action("group_tools/admin_transfer", dirname(__FILE__) . "/actions/admin_transfer.php");
		elgg_register_action("group_tools/toggle_admin", dirname(__FILE__) . "/actions/toggle_admin.php");
		elgg_register_action("group_tools/mail", dirname(__FILE__) . "/actions/mail.php");
		elgg_register_action("group_tools/profile_widgets", dirname(__FILE__) . "/actions/profile_widgets.php");
		elgg_register_action("group_tools/cleanup", dirname(__FILE__) . "/actions/cleanup.php");
		elgg_register_action("group_tools/default_access", dirname(__FILE__) . "/actions/default_access.php");
		elgg_register_action("group_tools/invite_members", dirname(__FILE__) . "/actions/invite_members.php");
		
		elgg_register_action("group_tools/toggle_special_state", dirname(__FILE__) . "/actions/admin/toggle_special_state.php", "admin");
		elgg_register_action("group_tools/fix_auto_join", dirname(__FILE__) . "/actions/admin/fix_auto_join.php", "admin");
		elgg_register_action("group_tools/notifications", dirname(__FILE__) . "/actions/admin/notifications.php", "admin");
		elgg_register_action("group_tools/fix_acl", dirname(__FILE__) . "/actions/admin/fix_acl.php", "admin");
		
		elgg_register_action("groups/email_invitation", dirname(__FILE__) . "/actions/groups/email_invitation.php");
		elgg_register_action("groups/decline_email_invitation", dirname(__FILE__) . "/actions/groups/decline_email_invitation.php");

		elgg_register_action("group_tools/order_groups", dirname(__FILE__) . "/actions/order_groups.php", "admin");
		
		elgg_register_action("discussion/toggle_status", dirname(__FILE__) . "/actions/discussion/toggle_status.php");
	}
	
	function group_tools_ready(){
		// unregister dashboard widget group_activity
		elgg_unregister_widget_type("group_activity");
	}
	
	function group_tools_pagesetup(){
		
		$user = elgg_get_logged_in_user_entity();
		$page_owner = elgg_get_page_owner_entity();
		
		if(elgg_in_context("groups") && ($page_owner instanceof ElggGroup)){
			if($page_owner->forum_enable == "no"){
				// unset if not enabled for this plugin
				elgg_unregister_widget_type("group_forum_topics");
			}
			
			if(!empty($user)){
				// check for admin transfer
				$admin_transfer = elgg_get_plugin_setting("admin_transfer", "group_tools");
				
				if(($admin_transfer == "admin") && $user->isAdmin()){
					elgg_extend_view("groups/edit", "group_tools/forms/admin_transfer", 400);
				} elseif(($admin_transfer == "owner") && (($page_owner->getOwnerGUID() == $user->getGUID()) || $user->isAdmin())){
					elgg_extend_view("groups/edit", "group_tools/forms/admin_transfer", 400);
				}
				
				// check multiple admin
				if(elgg_get_plugin_setting("multiple_admin", "group_tools") == "yes"){
					// extend group members sidebar list
					elgg_extend_view("groups/sidebar/members", "group_tools/group_admins", 400);
					
					// remove group tool options for group admins
					if(($page_owner->getOwnerGUID() != $user->getGUID()) && !$user->isAdmin()){
						remove_group_tool_option("group_multiple_admin_allow");
					}
				}
				
				// invitation management
				if($page_owner->canEdit()){
					$request_options = array(
						"type" => "user",
						"relationship" => "membership_request",
						"relationship_guid" => $page_owner->getGUID(),
						"inverse_relationship" => true,
						"count" => true
					);
					
					$invite_options = array(
						"type" => "user",
						"relationship" => "invited",
						"relationship_guid" => $page_owner->getGUID(),
						"count" => true
					);
					
					$postfix = "";
					if($requests = elgg_get_entities_from_relationship($request_options)){
						$postfix = " [" . $requests . "]";
					} elseif($invited = elgg_get_entities_from_relationship($invite_options)){
						$postfix = " [" . $invited . "]";
					}
					
					if(!$page_owner->isPublicMembership() || !empty($requests)){
						elgg_register_menu_item('page', array(
							'name' => 'membership_requests',
							'text' => elgg_echo('groups:membershiprequests') . $postfix,
							'href' => "groups/requests/" . $page_owner->getGUID(),
						));
					} elseif(!empty($invited)){
						elgg_register_menu_item('page', array(
							'name' => 'membership_requests',
							'text' => elgg_echo('group_tools:menu:invitations') . $postfix,
							'href' => "groups/requests/" . $page_owner->getGUID(),
						));
					}
				}
				
				// group mail options
				if ($page_owner->canEdit() && (elgg_get_plugin_setting("mail", "group_tools") == "yes")) {
					elgg_register_menu_item('page', array(
						'name' => 'mail',
						'text' => elgg_echo('group_tools:menu:mail'),
						'href' => "groups/mail/" . $page_owner->getGUID(),
					));
				}
			}
		}
		
		if($page_owner instanceof ElggGroup){
			if(!$page_owner->isPublicMembership()){
				if(elgg_get_plugin_setting("search_index", "group_tools") != "yes"){
					// closed groups should be indexed by search engines
					elgg_extend_view("page/elements/head", "metatags/noindex");
				}
			}
			
			// cleanup sidebar
			elgg_extend_view("page/elements/sidebar", "group_tools/sidebar/cleanup");
		}
		
	}
	
	function group_tools_version_1_3(){
		$dbprefix = elgg_get_config("dbprefix");
		
		$query = "SELECT ac.id AS acl_id, ac.owner_guid AS group_guid, er.guid_one AS user_guid
			FROM {$dbprefix}access_collections ac
			JOIN {$dbprefix}entities e ON e.guid = ac.owner_guid
			JOIN {$dbprefix}entity_relationships er ON ac.owner_guid = er.guid_two
			WHERE e.type = 'group'
			AND er.relationship = 'member'
			AND er.guid_one NOT IN
			(
			SELECT acm.user_guid
			FROM {$dbprefix}access_collections ac2
			JOIN {$dbprefix}access_collection_membership acm ON ac2.id = acm.access_collection_id
			WHERE ac2.owner_guid = ac.owner_guid
			)";
		
		if($data = get_data($query)){
			foreach($data as $row){
				add_user_to_access_collection($row->user_guid, $row->acl_id);
			}
		}
	}
	
	// default elgg event handlers
	elgg_register_event_handler("init", "system", "group_tools_init");
	elgg_register_event_handler("ready", "system", "group_tools_ready");
	elgg_register_event_handler("pagesetup", "system", "group_tools_pagesetup", 550);

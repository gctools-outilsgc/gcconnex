<?php

/**
* Group Tools
*
* Start file for this plugin
* 
* @author ColdTrick IT Solutions
*/	

// define for default group access
define('GROUP_TOOLS_GROUP_ACCESS_DEFAULT', -10);

require_once(dirname(__FILE__) . '/lib/functions.php');

// default elgg event handlers
elgg_register_event_handler('init', 'system', 'group_tools_init');

/**
 * called when the Elgg system get initialized
 *
 * @return void
 */
function group_tools_init() {
	
	// extend css & js
	elgg_extend_view('elgg.css', 'css/group_tools/site.css');
	elgg_extend_view('admin.css', 'css/group_tools/admin.css');
	elgg_extend_view('js/elgg', 'js/group_tools/site.js');
	
	// extend page handlers
	elgg_register_plugin_hook_handler('route', 'groups', '\ColdTrick\GroupTools\Router::groups');
	elgg_register_plugin_hook_handler('route', 'livesearch', '\ColdTrick\GroupTools\Router::livesearch');
	
	// admin menu item
	elgg_register_admin_menu_item('administer', 'tool_presets', 'groups');
	elgg_register_admin_menu_item('administer', 'bulk_delete', 'groups');
	elgg_register_admin_menu_item('administer', 'auto_join', 'groups');
	
	// hook on title menu
	elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\GroupTools\TitleMenu::groupMembership');
	elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\GroupTools\TitleMenu::groupInvite');
	elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\GroupTools\TitleMenu::exportGroupMembers');
	elgg_register_plugin_hook_handler('register', 'menu:title', '\ColdTrick\GroupTools\TitleMenu::pendingApproval', 9999);
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', '\ColdTrick\GroupTools\GroupAdmins::assignGroupAdmin');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\GroupTools\GroupAdmins::assignGroupAdmin', 501);
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\GroupTools\EntityMenu::relatedGroup');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\GroupTools\EntityMenu::showMemberCount');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\GroupTools\EntityMenu::showGroupHiddenIndicator');
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\GroupTools\EntityMenu::removeUserFromGroup', 501);
	elgg_register_plugin_hook_handler('register', 'menu:membershiprequest', '\ColdTrick\GroupTools\Membership::membershiprequestMenu');
	elgg_register_plugin_hook_handler('register', 'menu:emailinvitation', '\ColdTrick\GroupTools\Membership::emailinvitationMenu');
	elgg_register_plugin_hook_handler('register', 'menu:group:membershiprequests', '\ColdTrick\GroupTools\Membership::groupMembershiprequests');
	elgg_register_plugin_hook_handler('register', 'menu:group:membershiprequest', '\ColdTrick\GroupTools\Membership::groupMembershiprequest');
	elgg_register_plugin_hook_handler('register', 'menu:group:invitation', '\ColdTrick\GroupTools\Membership::groupInvitation');
	elgg_register_plugin_hook_handler('register', 'menu:group:email_invitation', '\ColdTrick\GroupTools\Membership::groupEmailInvitation');
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\GroupTools\Membership::groupProfileSidebar');
	elgg_register_plugin_hook_handler('register', 'menu:filter', '\ColdTrick\GroupTools\GroupSortMenu::addTabs');
	elgg_register_plugin_hook_handler('register', 'menu:filter', '\ColdTrick\GroupTools\GroupSortMenu::addSorting');
	elgg_register_plugin_hook_handler('register', 'menu:filter', '\ColdTrick\GroupTools\GroupSortMenu::cleanupTabs', 900);
	elgg_register_plugin_hook_handler('register', 'menu:groups:my_status', '\ColdTrick\GroupTools\MyStatus::registerJoinStatus');
	elgg_register_plugin_hook_handler('prepare', 'menu:filter', '\ColdTrick\GroupTools\GroupSortMenu::setSelected');
	
	// group admins
	if (group_tools_multiple_admin_enabled()) {
		// add group tool option
		add_group_tool_option('group_multiple_admin_allow', elgg_echo('group_tools:multiple_admin:group_tool_option'), false);
		
		// extend group members sidebar list
		elgg_extend_view('groups/sidebar/members', 'group_tools/group_admins', 400);
		
		// cleanup for group admins
		elgg_extend_view('groups/edit/tools', 'group_tools/extends/groups/edit/tools/group_admins', 400);
	}
	
	// notify admin on membership request
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\GroupTools\GroupAdmins::membershipRequest');
	// register on group leave
	elgg_register_event_handler('leave', 'group', '\ColdTrick\GroupTools\GroupAdmins::groupLeave');
	// register permissions check hook
	elgg_register_plugin_hook_handler('permissions_check', 'group', '\ColdTrick\GroupTools\GroupAdmins::permissionsCheck');
	
	// register group activity widget
	// 2012-05-03: restored limited functionality of group activity widget, will be fully restored if Elgg fixes widget settings
	elgg_register_widget_type('group_river_widget', elgg_echo('widgets:group_river_widget:title'), elgg_echo('widgets:group_river_widget:description'), ['dashboard', 'profile', 'index', 'groups'], true);
	// unregister dashboard widget group_activity, because our version is better ;)
	elgg_unregister_widget_type('group_activity');
	
	// register group members widget
	elgg_register_widget_type('group_members', elgg_echo('widgets:group_members:title'), elgg_echo('widgets:group_members:description'), ['groups'], false);
	
	// register groups invitations widget
	elgg_register_widget_type('group_invitations', elgg_echo('widgets:group_invitations:title'), elgg_echo('widgets:group_invitations:description'), ['index', 'dashboard'], false);
	
	// register featured groups widget
	elgg_register_widget_type('featured_groups', elgg_echo('groups:featured'), elgg_echo('widgets:featured_groups:description'), ['index']);
	
	// register index groups widget
	elgg_register_widget_type('index_groups', elgg_echo('groups'), elgg_echo('widgets:index_groups:description'), ['index'], true);
	
	// group invitation
	elgg_register_action('groups/invite', dirname(__FILE__) . '/actions/groups/invite.php');
	
	// manage auto join for groups
	elgg_register_ajax_view('forms/group_tools/admin/auto_join/default');
	elgg_register_ajax_view('forms/group_tools/admin/auto_join/additional');
	elgg_register_ajax_view('group_tools/elements/auto_join_match_pattern');
	
	elgg_extend_view('groups/edit', 'group_tools/forms/special_states', 350);
	
	elgg_register_event_handler('create', 'user', '\ColdTrick\GroupTools\Membership::autoJoinGroups');
	elgg_register_event_handler('login', 'user', '\ColdTrick\GroupTools\Membership::autoJoinGroupsLogin');
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\GroupTools\Membership::siteJoinEmailInvitedGroups');
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\GroupTools\Membership::siteJoinGroupInviteCode');
	elgg_register_event_handler('create', 'relationship', '\ColdTrick\GroupTools\Membership::siteJoinDomainBasedGroups');
	
	elgg_register_plugin_hook_handler('cron', 'fiveminute', '\ColdTrick\GroupTools\Membership::autoJoinGroupsCron');
	
	// group admin approve
	elgg_extend_view('groups/edit', 'group_tools/extends/groups/edit/admin_approve', 1);
	elgg_extend_view('groups/profile/layout', 'group_tools/extends/groups/edit/admin_approve', 1);
	elgg_register_admin_menu_item('administer', 'admin_approval', 'groups');
	
	elgg_register_notification_event('group', null, ['admin_approval']);
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\GroupTools\Notifications::adminApprovalSubs');
	elgg_register_plugin_hook_handler('prepare', 'notification:admin_approval:group:', '\ColdTrick\GroupTools\Notifications::prepareAdminApprovalMessage');
	
	// show group edit as tabbed
	elgg_extend_view('groups/edit', 'group_tools/group_edit_tabbed', 10);
	
	// cleanup group side menu
	elgg_extend_view('page/elements/sidebar', 'group_tools/sidebar/featured');
	elgg_extend_view('groups/edit', 'group_tools/forms/cleanup', 450);
	elgg_register_plugin_hook_handler('view_vars', 'groups/sidebar/members', '\ColdTrick\GroupTools\Cleanup::hideSidebarMembers');
	elgg_register_plugin_hook_handler('view_vars', 'groups/sidebar/my_status', '\ColdTrick\GroupTools\Cleanup::hideMyStatus');
	elgg_register_plugin_hook_handler('view_vars', 'groups/sidebar/search', '\ColdTrick\GroupTools\Cleanup::hideSearchbox');
	elgg_register_plugin_hook_handler('prepare', 'menu:extras', '\ColdTrick\GroupTools\Cleanup::hideExtrasMenu');
	elgg_register_plugin_hook_handler('prepare', 'menu:title', '\ColdTrick\GroupTools\Cleanup::hideMembershipActions');
	elgg_register_plugin_hook_handler('prepare', 'menu:groups:my_status', '\ColdTrick\GroupTools\Cleanup::hideMembershipActions');
	elgg_register_plugin_hook_handler('prepare', 'menu:owner_block', '\ColdTrick\GroupTools\Cleanup::hideOwnerBlockMenu');
	
	// group notifications
	elgg_extend_view('groups/edit', 'group_tools/forms/notifications', 375);
	
	// allow group members to invite new members
	elgg_extend_view('groups/edit', 'group_tools/forms/invite_members', 475);
	
	// configure a group welcome message
	elgg_extend_view('groups/edit', 'group_tools/forms/welcome_message');
	
	// configure domain based group join
	elgg_extend_view('groups/edit', 'group_tools/forms/domain_based');
	
	// show group status in owner block
	elgg_extend_view('page/elements/owner_block/extend', 'group_tools/owner_block');
	// show group status in stats (on group profile)
	elgg_extend_view('groups/profile/summary', 'group_tools/group_stats');
	
	if (elgg_is_active_plugin('blog')) {
		elgg_register_widget_type('group_news', elgg_echo('widgets:group_news:title'), elgg_echo('widgets:group_news:description'), ['profile', 'index', 'dashboard'], true);
		elgg_extend_view('css/elgg', 'css/group_tools/group_news.css');
	}
	
	// related groups
	add_group_tool_option('related_groups', elgg_echo('groups_tools:related_groups:tool_option'), false);
	elgg_extend_view('groups/tool_latest', 'group_tools/modules/related_groups');
	elgg_register_widget_type('group_related', elgg_echo('groups_tools:related_groups:widget:title'), elgg_echo('groups_tools:related_groups:widget:description'), ['groups']);
	
	// registration
	elgg_extend_view('register/extend', 'group_tools/register_extend');
	
	// theme sandbox
	elgg_extend_view('theme_sandbox/forms', 'group_tools/theme_sandbox/grouppicker');
	
	// closed groups shouldn't be indexed by search engines
	elgg_register_plugin_hook_handler('head', 'page', '\ColdTrick\GroupTools\PageLayout::noIndexClosedGroups');
	
	// group invitations
	elgg_extend_view('groups/invitationrequests', 'group_tools/invitationrequests/emailinvitations');
	elgg_extend_view('groups/invitationrequests', 'group_tools/invitationrequests/membershiprequests');
	elgg_extend_view('groups/invitationrequests', 'group_tools/invitationrequests/emailinviteform');
	
	// group join motivation
	elgg_register_ajax_view('group_tools/forms/motivation');
	
	// register events
	elgg_register_event_handler('join', 'group', '\ColdTrick\GroupTools\Membership::groupJoin');
	elgg_register_event_handler('delete', 'relationship', 'ColdTrick\GroupTools\Membership::deleteRequest');
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\GroupTools\Upgrade::setGroupMailClassHandler');
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\GroupTools\Upgrade::migrateListingSettings');
	
	// group mail option
	elgg_register_plugin_hook_handler('register', 'menu:page', '\ColdTrick\GroupTools\GroupMail::pageMenu');
	elgg_register_notification_event('object', GroupMail::SUBTYPE, ['enqueue']);
	elgg_register_plugin_hook_handler('prepare', 'notification:enqueue:object:' . GroupMail::SUBTYPE, '\ColdTrick\GroupTools\GroupMail::prepareNotification');
	elgg_register_plugin_hook_handler('get', 'subscriptions', '\ColdTrick\GroupTools\GroupMail::getSubscribers');
	elgg_register_plugin_hook_handler('send:after', 'notifications', '\ColdTrick\GroupTools\GroupMail::cleanup');
	
	if (group_tools_group_mail_members_enabled()) {
		add_group_tool_option('mail_members', elgg_echo('group_tools:tools:mail_members'), false);
	}
	
	// cyu - index closed group too
	if ($page_owner instanceof ElggGroup) {
		
		// cleanup sidebar
		elgg_extend_view("page/elements/sidebar", "group_tools/sidebar/cleanup");
	}
	// stale groups
	elgg_extend_view('groups/profile/summary', 'group_tools/extends/groups/profile/stale_message');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\GroupTools\WidgetManager::widgetURL');
	elgg_register_plugin_hook_handler('default', 'access', '\ColdTrick\GroupTools\Access::setGroupDefaultAccess');
	elgg_register_plugin_hook_handler('default', 'access', '\ColdTrick\GroupTools\Access::validateGroupDefaultAccess', 999999);
	elgg_register_plugin_hook_handler('access:collections:write', 'user', '\ColdTrick\GroupTools\Access::defaultAccessOptions');
	elgg_register_plugin_hook_handler('action', 'groups/join', '\ColdTrick\GroupTools\Membership::groupJoinAction');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', '\ColdTrick\GroupTools\OwnerBlockMenu::relatedGroups');
	elgg_register_plugin_hook_handler('route', 'register', '\ColdTrick\GroupTools\Router::allowRegistration');
	elgg_register_plugin_hook_handler('action', 'register', '\ColdTrick\GroupTools\Router::allowRegistration');
	elgg_register_plugin_hook_handler('group_tool_widgets', 'widget_manager', '\ColdTrick\GroupTools\WidgetManager::groupToolWidgets');
	
	elgg_register_plugin_hook_handler('get_exportable_values', 'csv_exporter', '\ColdTrick\GroupTools\CSVExporter::addGroupAdminsToGroups');
	elgg_register_plugin_hook_handler('get_exportable_values', 'csv_exporter', '\ColdTrick\GroupTools\CSVExporter::addGroupAdminsToUsers');
	elgg_register_plugin_hook_handler('get_exportable_values', 'csv_exporter', '\ColdTrick\GroupTools\CSVExporter::addStaleInfo');
	elgg_register_plugin_hook_handler('export_value', 'csv_exporter', '\ColdTrick\GroupTools\CSVExporter::exportGroupAdminsForGroups');
	elgg_register_plugin_hook_handler('export_value', 'csv_exporter', '\ColdTrick\GroupTools\CSVExporter::exportGroupAdminsForUsers');
	elgg_register_plugin_hook_handler('export_value', 'csv_exporter', '\ColdTrick\GroupTools\CSVExporter::exportStaleInfo');
	
	elgg_register_plugin_hook_handler('cron', 'daily', '\ColdTrick\GroupTools\Cron::notifyStaleGroupOwners');
	
	// actions
	elgg_register_action('group_tools/toggle_admin', dirname(__FILE__) . '/actions/toggle_admin.php');
	elgg_register_action('group_tools/mail', dirname(__FILE__) . '/actions/mail.php');
	elgg_register_action('group_tools/cleanup', dirname(__FILE__) . '/actions/cleanup.php');
	elgg_register_action('group_tools/invite_members', dirname(__FILE__) . '/actions/invite_members.php');
	elgg_register_action('group_tools/welcome_message', dirname(__FILE__) . '/actions/welcome_message.php');
	elgg_register_action('group_tools/domain_based', dirname(__FILE__) . '/actions/domain_based.php');
	elgg_register_action('group_tools/related_groups', dirname(__FILE__) . '/actions/related_groups.php');
	elgg_register_action('group_tools/remove_related_groups', dirname(__FILE__) . '/actions/remove_related_groups.php');
	elgg_register_action('group_tools/member_export', dirname(__FILE__) . '/actions/member_export.php');
	elgg_register_action('group_tools/toggle_notifications', dirname(__FILE__) . '/actions/toggle_notifications.php');
	elgg_register_action('group_tools/join_motivation', dirname(__FILE__) . '/actions/membership/join_motivation.php');
	elgg_register_action('group_tools/mark_not_stale', dirname(__FILE__) . '/actions/mark_not_stale.php');
	
	elgg_register_action('group_tools/toggle_special_state', dirname(__FILE__) . '/actions/admin/toggle_special_state.php', 'admin');
	elgg_register_action('group_tools/notifications', dirname(__FILE__) . '/actions/admin/notifications.php', 'admin');
	elgg_register_action('group_tools/fix_acl', dirname(__FILE__) . '/actions/admin/fix_acl.php', 'admin');
	elgg_register_action('group_tools/group_tool_presets', dirname(__FILE__) . '/actions/admin/group_tool_presets.php', 'admin');
	elgg_register_action('group_tools/admin/bulk_delete', dirname(__FILE__) . '/actions/admin/bulk_delete.php', 'admin');
	elgg_register_action('group_tools/admin/approve', dirname(__FILE__) . '/actions/admin/approve.php', 'admin');
	elgg_register_action('group_tools/admin/decline', dirname(__FILE__) . '/actions/admin/decline.php', 'admin');
	elgg_register_action('group_tools/admin/auto_join/default', dirname(__FILE__) . '/actions/admin/auto_join/default.php', 'admin');
	elgg_register_action('group_tools/admin/auto_join/additional', dirname(__FILE__) . '/actions/admin/auto_join/additional.php', 'admin');
	elgg_register_action('group_tools/admin/auto_join/delete', dirname(__FILE__) . '/actions/admin/auto_join/delete.php', 'admin');
	
	elgg_register_action('group_tools/email_invitation', dirname(__FILE__) . '/actions/membership/email_invitation.php');
	elgg_register_action('groups/decline_email_invitation', dirname(__FILE__) . '/actions/groups/decline_email_invitation.php');
	elgg_register_action('group_tools/revoke_email_invitation', dirname(__FILE__) . '/actions/groups/revoke_email_invitation.php');
	elgg_register_action('groups/edit', dirname(__FILE__) . '/actions/groups/edit.php');
	
	elgg_register_action('group_tools/order_groups', dirname(__FILE__) . '/actions/order_groups.php', 'admin');
}

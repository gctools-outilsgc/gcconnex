<?php

namespace ColdTrick\GroupTools;

class Membership {
	
	/**
	 * Auto notification plugin settings
	 *
	 * @var string[]
	 */
	protected static $AUTO_NOTIFICATIONS;
	
	/**
	 * Show notification settings on group join
	 *
	 * @var bool
	 */
	protected static $NOTIFICATIONS_TOGGLE;
	
	/**
	 * Load the plugin settings for notification settings on group join
	 *
	 * @return void
	 */
	protected static function loadAutoNotifications() {
		
		if (isset(self::$AUTO_NOTIFICATIONS)) {
			return;
		}
		
		self::$AUTO_NOTIFICATIONS = [];
		
		$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethods();
		if (empty($NOTIFICATION_HANDLERS) || !is_array($NOTIFICATION_HANDLERS)) {
			return;
		}
		
		if (elgg_get_plugin_setting('auto_notification', 'group_tools') === 'yes') { // Backwards compatibility
			self::$AUTO_NOTIFICATIONS = ['email', 'site'];
		}
		
		foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
			$plugin_setting = (int) elgg_get_plugin_setting("auto_notification_{$method}", 'group_tools');
			if (empty($plugin_setting)) {
				continue;
			}
			
			self::$AUTO_NOTIFICATIONS[] = $method;
		}
		
		self::$AUTO_NOTIFICATIONS = array_unique(self::$AUTO_NOTIFICATIONS);
	}
	
	/**
	 * Listen to the delete of a membership request
	 *
	 * @param stirng            $event        the name of the event
	 * @param stirng            $type         the type of the event
	 * @param \ElggRelationship $relationship the relationship
	 *
	 * @return void
	 */
	public static function deleteRequest($event, $type, $relationship) {
		
		if (!($relationship instanceof \ElggRelationship)) {
			return;
		}
		
		if ($relationship->relationship !== 'membership_request') {
			// not a membership request
			return;
		}
		
		$action_pattern = '/action\/groups\/killrequest/i';
		if (!preg_match($action_pattern, current_page_url())) {
			// not in the action, so do nothing
			return;
		}
		
		$group = get_entity($relationship->guid_two);
		$user = get_user($relationship->guid_one);
		
		if (empty($user) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		if ($user->getGUID() === elgg_get_logged_in_user_guid()) {
			// user kills own request
			return;
		}
		
		$reason = get_input('reason');
		if (empty($reason)) {
			$body = elgg_echo('group_tools:notify:membership:declined:message', [
				$user->name,
				$group->name,
				$group->getURL(),
			]);
		} else {
			$body = elgg_echo('group_tools:notify:membership:declined:message:reason', [
				$user->name,
				$group->name,
				$reason,
				$group->getURL(),
			]);
		}
		
		$subject = elgg_echo('group_tools:notify:membership:declined:subject', [
			$group->name,
		]);
		
		$params = [
			'object' => $group,
			'action' => 'delete',
		];
		notify_user($user->getGUID(), $group->getGUID(), $subject, $body, $params);
	}
	
	/**
	 * Listen to the group join event
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param array  $params supplied params
	 *
	 * @return void
	 */
	public static function groupJoin($event, $type, $params) {
		
		$user = elgg_extract('user', $params);
		$group = elgg_extract('group', $params);
		
		if (!($user instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		// set notification settings
		self::setGroupNotificationSettings($user, $group);
		
		// allow user to change notification settings
		self::notificationsToggle($user, $group);
		
		// cleanup invites and membershiprequests
		self::cleanupGroupInvites($user, $group);
		
		// welcome message
		self::sendWelcomeMessage($user, $group);
	}
	
	/**
	 * Set the user's notification settings for the group
	 *
	 * @param \ElggUser  $user  user to set settings for
	 * @param \ElggGroup $group group to set settings for
	 *
	 * @return void
	 */
	protected static function setGroupNotificationSettings(\ElggUser $user, \ElggGroup $group) {
		
		if (!($user instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		// load notification settings
		self::loadAutoNotifications();
		
		if (empty(self::$AUTO_NOTIFICATIONS)) {
			return;
		}
		
		// subscribe the user to the group
		$NOTIFICATION_HANDLERS = _elgg_services()->notifications->getMethodsAsDeprecatedGlobal();
		foreach ($NOTIFICATION_HANDLERS as $method => $dummy) {
			if (!in_array($method, self::$AUTO_NOTIFICATIONS)) {
				continue;
			}
	
			elgg_add_subscription($user->getGUID(), $method, $group->getGUID());
		}
	}
	
	/**
	 * Allow a user to change the group notification settings when joined to a group
	 *
	 * @param \ElggUser  $user  the user joining
	 * @param \ElggGroup $group the group joined
	 *
	 * @return void
	 */
	protected static function notificationsToggle(\ElggUser $user, \ElggGroup $group) {
		static $register_once;
		
		if (!($user instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		if (!isset(self::$NOTIFICATIONS_TOGGLE)) {
			self::$NOTIFICATIONS_TOGGLE = false;
			
			$plugin_settings = elgg_get_plugin_setting('notification_toggle', 'group_tools');
			if ($plugin_settings === 'yes' && elgg_is_active_plugin('notifications')) {
				self::$NOTIFICATIONS_TOGGLE = true;
			}
		}
		
		if (!self::$NOTIFICATIONS_TOGGLE) {
			return;
		}
		
		$logged_in_user = elgg_get_logged_in_user_entity();
		if (!empty($logged_in_user) && ($logged_in_user->getGUID() === $user->getGUID())) {
			// user joined group on own action (join public group, accept invite, etc)
			$notifications_enabled = self::notificationsEnabledForGroup($user, $group);
			
			$link_text = elgg_echo('group_tools:notifications:toggle:site:disabled:link');
			$text_key = 'group_tools:notifications:toggle:site:disabled';
			if ($notifications_enabled) {
				$link_text = elgg_echo('group_tools:notifications:toggle:site:enabled:link');
				$text_key = 'group_tools:notifications:toggle:site:enabled';
			}
			
			$link = elgg_view('output/url', [
				'text' => $link_text,
				'href' => "action/group_tools/toggle_notifications?group_guid={$group->getGUID()}",
				'is_action' => true,
			]);
			
			system_message(elgg_echo($text_key, [$link]));
		} else {
			// user was joined by other means (group admin accepted request, added user, etc)
			if (!empty($register_once)) {
				return;
			}
			
			$register_once = true;
			
			elgg_register_plugin_hook_handler('invite_notification', 'group_tools', '\ColdTrick\GroupTools\Membership::notificationAddedGroup');
			elgg_register_plugin_hook_handler('email', 'system', '\ColdTrick\GroupTools\Membership::notificationEmail', 400);
		}
	}
	
	/**
	 * Cleanup group invitations and membershiprequests
	 *
	 * @param \ElggUser  $user  the user to cleanup for
	 * @param \ElggGroup $group the group to cleanup on
	 *
	 * @return void
	 */
	protected static function cleanupGroupInvites(\ElggUser $user, \ElggGroup $group) {
		
		if (!($user instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		// cleanup invites
		remove_entity_relationship($group->getGUID(), 'invited', $user->getGUID());
		
		// and requests
		remove_entity_relationship($user->getGUID(), 'membership_request', $group->getGUID());
		
		// cleanup email invitations
		$options = [
			'annotation_name' => 'email_invitation',
			'annotation_value' => group_tools_generate_email_invite_code($group->getGUID(), $user->email),
			'limit' => false,
		];
		
		if (elgg_is_logged_in()) {
			elgg_delete_annotations($options);
		} elseif ($annotations = elgg_get_annotations($options)) {
			group_tools_delete_annotations($annotations);
		}
		
		// join motivation
		$options = [
			'annotation_name' => 'join_motivation',
			'guid' => $group->getGUID(),
			'annotation_owner_guid' => $user->getGUID(),
			'limit' => false,
		];
		elgg_delete_annotations($options);
	}
	
	/**
	 * Send a welcome message to the new user of the group
	 *
	 * @param \ElggUser  $recipient the new user
	 * @param \ElggGroup $group     the group
	 *
	 * @return void
	 */
	protected static function sendWelcomeMessage(\ElggUser $recipient, \ElggGroup $group) {
		
		if (!($recipient instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		// get welcome messgae
		$welcome_message = $group->getPrivateSetting('group_tools:welcome_message');
		$check_message = trim(strip_tags($welcome_message));
		if (empty($check_message)) {
			return;
		}
		
		// replace the place holders
		$welcome_message = str_ireplace('[name]', $recipient->name, $welcome_message);
		$welcome_message = str_ireplace('[group_name]', $group->name, $welcome_message);
		$welcome_message = str_ireplace('[group_url]', $group->getURL(), $welcome_message);
			
		// subject
		$subject = elgg_echo('group_tools:welcome_message:subject', [$group->name]);
			
		// notify the user
		notify_user($recipient->getGUID(), $group->getGUID(), $subject, $welcome_message);
	}
	
	/**
	 * Validate that the relationship is a site membership relationship
	 *
	 * @param \ElggRelationship $relationship the relationship to check
	 *
	 * @return bool
	 */
	protected static function validateSiteJoinRelationship($relationship) {
		
		if (!($relationship instanceof \ElggRelationship) || ($relationship->relationship !== 'member_of_site')) {
			return false;
		}
		
		$user_guid = (int) $relationship->guid_one;
		$user = get_user($user_guid);
		if (empty($user)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Listen to the create user
	 *
	 * @param string    $event the name of the event
	 * @param string    $type  the type of the event
	 * @param \ElggUser $user  supplied param
	 *
	 * @return void
	 */
	public static function autoJoinGroups($event, $type, $user) {
		
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// mark the user to check for auto joins when we have more information
		$user->group_tools_check_auto_joins = true;
		
		// restore access settings
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Handle the auto join groups for users
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function autoJoinGroupsCron($hook, $type, $return_value, $params) {
		
		$time = (int) elgg_extract('time', $params, time());
		
		$batch = new \ElggBatch('elgg_get_entities_from_metadata', [
			'type' => 'user',
			'limit' => false,
			'metadata_name_value_pairs' => [
				'group_tools_check_auto_joins' => true,
			],
			'created_time_upper' => ($time), // 5 minute delay
		]);
		$batch->setIncrementOffset(false);
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		$auto_join = false;
		/* @var $user \ElggUser */
		foreach ($batch as $user) {
			
			// prep helper class
			if (empty($auto_join)) {
				$auto_join = new AutoJoin($user);
			} else {
				$auto_join->setUser($user);
			}
			
			// remove user flag
			unset($user->group_tools_check_auto_joins);
			
			// get groups
			$group_guids = $auto_join->getGroupGUIDs();
			if (empty($group_guids)) {
				continue;
			}
			
			foreach ($group_guids as $group_guid) {
				$group = get_entity($group_guid);
				if (!($group instanceof \ElggGroup)) {
					continue;
				}
				
				$group->join($user);
			}
		}
		
		// retore access
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Check if a user needs to join auto groups (on login)
	 *
	 * @param string    $event the name of the event
	 * @param string    $type  the type of the event
	 * @param \ElggUser $user  the user
	 *
	 * @return void
	 */
	public static function autoJoinGroupsLogin($event, $type, $user) {
		
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		if (!isset($user->group_tools_check_auto_joins)) {
			// user is already proccessed
			return;
		}
		
		// prep helper class
		$auto_join = new AutoJoin($user);
		
		// remove user flag
		unset($user->group_tools_check_auto_joins);
		
		// get groups
		$group_guids = $auto_join->getGroupGUIDs();
		if (empty($group_guids)) {
			return;
		}
		
		foreach ($group_guids as $group_guid) {
			$group = get_entity($group_guid);
			if (!($group instanceof \ElggGroup)) {
				continue;
			}
			
			$group->join($user);
		}
	}
	
	/**
	 * Listen to the create member_of_site relationship event to handle new users
	 *
	 * @param string            $event        the name of the event
	 * @param string            $type         the type of the event
	 * @param \ElggRelationship $relationship supplied param
	 *
	 * @return void
	 */
	public static function siteJoinEmailInvitedGroups($event, $type, $relationship) {
		
		if (!self::validateSiteJoinRelationship($relationship)) {
			return;
		}
		
		$user_guid = (int) $relationship->guid_one;
		$site_guid = (int) $relationship->guid_two;
		
		$user = get_user($user_guid);
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// auto detect email invited groups
		$groups = group_tools_get_invited_groups_by_email($user->email, $site_guid);
		if (empty($groups)) {
			// restore access settings
			elgg_set_ignore_access($ia);
			
			return;
		}
			
		foreach ($groups as $group) {
			// join the group
			$group->join($user);
		}
		
		// restore access settings
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Listen to the create member_of_site relationship event to handle new users
	 *
	 * @param string            $event        the name of the event
	 * @param string            $type         the type of the event
	 * @param \ElggRelationship $relationship supplied param
	 *
	 * @return void
	 */
	public static function siteJoinGroupInviteCode($event, $type, $relationship) {
		
		if (!self::validateSiteJoinRelationship($relationship)) {
			return;
		}
		
		$user_guid = (int) $relationship->guid_one;
		
		$user = get_user($user_guid);
		
		// check for manual email invited groups
		$group_invitecode = get_input('group_invitecode');
		if (empty($group_invitecode)) {
			return;
		}
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		$group = group_tools_check_group_email_invitation($group_invitecode);
		if (empty($group)) {
			// restore access settings
			elgg_set_ignore_access($ia);
			
			return;
		}
		
		// join the group
		$group->join($user);
		
		// cleanup the invite code
		$group_invitecode = sanitise_string($group_invitecode);
		
		elgg_delete_annotations([
			'guid' => $group->getGUID(),
			'annotation_name' => 'email_invitation',
			'wheres' => [
				"(v.string = '{$group_invitecode}' OR v.string LIKE '{$group_invitecode}|%')",
			],
			'annotation_owner_guid' => $group->getGUID(),
			'limit' => 1,
		]);
		
		// restore access settings
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Listen to the create member_of_site relationship event to handle new users
	 *
	 * @param string            $event        the name of the event
	 * @param string            $type         the type of the event
	 * @param \ElggRelationship $relationship supplied param
	 *
	 * @return void
	 */
	public static function siteJoinDomainBasedGroups($event, $type, $relationship) {
		
		if (!self::validateSiteJoinRelationship($relationship)) {
			return;
		}
		
		$user_guid = (int) $relationship->guid_one;
		$site_guid = (int) $relationship->guid_two;
		
		$user = get_user($user_guid);
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// find domain based groups
		$groups = group_tools_get_domain_based_groups($user, $site_guid);
		if (empty($groups)) {
			// restore access settings
			elgg_set_ignore_access($ia);
			
			return;
		}
		
		foreach ($groups as $group) {
			// join the group
			$group->join($user);
		}
		
		// restore access settings
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Register a plugin hook, only during the group/join action
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param null   $params       supplied params
	 *
	 * @return void
	 */
	public static function groupJoinAction($hook, $type, $return_value, $params) {
		
		// hacky way around a short comming of Elgg core to allow users to join a group
		if (!group_tools_domain_based_groups_enabled()) {
			return;
		}
		
		elgg_register_plugin_hook_handler('permissions_check', 'group', '\ColdTrick\GroupTools\Membership::groupJoinPermission');
	}
	
	/**
	 * A hook on the ->canEdit() of a group. This is done to allow e-mail domain users to join a group
	 *
	 * Note: this is a very hacky way arround a short comming of Elgg core
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param null   $params       supplied params
	 *
	 * @return void|true
	 */
	public static function groupJoinPermission($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			// already allowed
			return;
		}
		
		if (!group_tools_domain_based_groups_enabled()) {
			return;
		}
		
		// domain based groups are enabled, lets check if this user is allowed to join based on that
		$group = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!($group instanceof \ElggGroup) || !($user instanceof \ElggUser)) {
			return;
		}
		
		if (!group_tools_check_domain_based_group($group, $user)) {
			return;
		}
		
		return true;
	}
	
	/**
	 * add menu items to the membershiprequest listing
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function membershiprequestMenu($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('user', $params);
		$group = elgg_extract('entity', $params);
		
		if (!($user instanceof \ElggUser) || !$user->canEdit()) {
			return;
		}
		
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'killrequest',
			'text' => elgg_echo('revoke'),
			'confirm' => elgg_echo('group_tools:group:invitations:request:revoke:confirm'),
			'href' => "action/groups/killrequest?user_guid={$user->getGUID()}&group_guid={$group->getGUID()}",
			'is_action' => true,
			'link_class' => 'elgg-button elgg-button-delete',
		]);
		
		return $return_value;
	}
	
	/**
	 * add menu items to the emailinvitation listing
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function emailinvitationMenu($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('user', $params);
		$group = elgg_extract('entity', $params);
		
		if (!($user instanceof \ElggUser) || !$user->canEdit()) {
			return;
		}
		
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		$invitecode = group_tools_generate_email_invite_code($group->getGUID(), $user->email);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'accept',
			'text' => elgg_echo('accept'),
			'href' => "action/groups/email_invitation?invitecode={$invitecode}",
			'link_class' => 'elgg-button elgg-button-submit',
			'is_action' => true,
		]);
			
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'decline',
			'text' => elgg_echo('delete'),
			'href' => "action/groups/decline_email_invitation?invitecode={$invitecode}",
			'confirm' => elgg_echo('groups:invite:remove:check'),
			'is_action' => true,
			'link_class' => 'elgg-button elgg-button-delete mlm',
		]);
		
		return $return_value;
	}
	
	/**
	 * add menu items to the group memberships page
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupMembershiprequests($hook, $type, $return_value, $params) {
		
		$group = elgg_extract('entity', $params);
		if (!($group instanceof \ElggGroup) || !$group->canEdit()) {
			return;
		}
		
		// add default membership request
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'membershipreq',
			'text' => elgg_echo('group_tools:groups:membershipreq:requests'),
			'href' => "groups/requests/{$group->getGUID()}",
			'is_trusted' => true,
			'priority' => 100,
		]);
		// invited users
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'invites',
			'text' => elgg_echo('group_tools:groups:membershipreq:invitations'),
			'href' => "groups/requests/{$group->getGUID()}/invites",
			'is_trusted' => true,
			'priority' => 200,
		]);
		// invited emails
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'email_invites',
			'text' => elgg_echo('group_tools:groups:membershipreq:email_invitations'),
			'href' => "groups/requests/{$group->getGUID()}/email_invites",
			'is_trusted' => true,
			'priority' => 300,
		]);
		
		return $return_value;
	}
	
	/**
	 * add menu items to the membershiprequest for group admins
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupMembershiprequest($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('entity', $params);
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		$group = elgg_extract('group', $params);
		if (!($group instanceof \ElggGroup) || !$group->canEdit()) {
			return;
		}
		
		// show motivation button
		$motivation = $group->getAnnotations([
			'annotation_name' => 'join_motivation',
			'count' => true,
			'annotation_owner_guid' => $user->getGUID(),
		]);
		if (!empty($motivation)) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'toggle_motivation',
				'text' => elgg_echo('group_tools:join_motivation:toggle'),
				'href' => "#group-tools-group-membershiprequest-motivation-{$user->getGUID()}",
				'rel' => 'toggle',
				'link_class' => 'elgg-button elgg-button-action mrm',
				'priority' => 10,
			]);
		}
		
		// accept button
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'accept',
			'href' => "action/groups/addtogroup?user_guid={$user->getGUID()}&group_guid={$group->getGUID()}",
			'text' => elgg_echo('accept'),
			'link_class' => 'elgg-button elgg-button-submit group-tools-accept-request',
			'rel' => $user->getGUID(),
			'is_action' => true,
		]);
		
		// decline button
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'decline',
			'href' => '#',
			'text' => elgg_echo('decline'),
			'link_class' => 'elgg-button elgg-button-delete mlm elgg-lightbox',
			'rel' => $user->getGUID(),
			'data-colorbox-opts' => json_encode([
				'inline' => true,
				'href' => "#group-kill-request-{$user->getGUID()}",
				'width' => '600px',
				'closeButton' => false,
			]),
		]);
		
		return $return_value;
	}
	
	/**
	 * add menu items to the user invitation for group admins
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupInvitation($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('entity', $params);
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		$group = elgg_extract('group', $params);
		if (!($group instanceof \ElggGroup) || !$group->canEdit()) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'revoke',
			'href' => "action/groups/killinvitation?user_guid={$user->getGUID()}&group_guid={$group->getGUID()}",
			'confirm' => elgg_echo('group_tools:groups:membershipreq:invitations:revoke:confirm'),
			'text' => elgg_echo('revoke'),
			'link_class' => 'elgg-button elgg-button-delete mlm',
		]);
		
		return $return_value;
	}
	
	/**
	 * add menu items to the email invitation for group admins
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupEmailInvitation($hook, $type, $return_value, $params) {
		
		$annotation = elgg_extract('annotation', $params);
		if (!($annotation instanceof \ElggAnnotation)) {
			return;
		}
		
		$group = elgg_extract('group', $params);
		if (!($group instanceof \ElggGroup) || !$group->canEdit()) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'revoke',
			'href' => "action/group_tools/revoke_email_invitation?annotation_id={$annotation->id}&group_guid={$group->getGUID()}",
			'confirm' => elgg_echo('group_tools:groups:membershipreq:invitations:revoke:confirm'),
			'text' => elgg_echo('revoke'),
			'link_class' => 'elgg-button elgg-button-delete mlm',
		]);
		
		return $return_value;
	}
	
	/**
	 * add menu item to the page menu on the gruop profile page
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupProfileSidebar($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('group_profile')) {
			return;
		}
		
		$group = elgg_get_page_owner_entity();
		if (!($group instanceof \ElggGroup) || !$group->canEdit()) {
			return;
		}
		
		$requests_found = false;
		foreach ($return_value as $menu_item) {
			if ($menu_item->getName() === 'membership_requests') {
				$requests_found = true;
				break;
			}
		}
		
		if ($requests_found) {
			return;
		}
		
		// add link to the manage invitations page
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'membership_requests',
			'text' => elgg_echo('group_tools:menu:invitations'),
			'href' => "groups/requests/{$group->getGUID()}/invites",
		]);
		
		return $return_value;
	}
	
	/**
	 * Add a link to the notifications page so a user can change the group notification settings
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function notificationAddedGroup($hook, $type, $return_value, $params) {
		
		$group = elgg_extract('group', $params);
		$user = elgg_extract('invitee', $params);
		if (!($user instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return;
		}
		
		$notifications_enabled = self::notificationsEnabledForGroup($user, $group);
		$additional_msg = self::generateEmailNotificationText($user, $notifications_enabled);
		
		$return_value .= PHP_EOL . PHP_EOL . $additional_msg;
		
		return $return_value;
	}
	
	/**
	 * add menu item to the page menu on the gruop profile page
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function notificationEmail($hook, $type, $return_value, $params) {
		
		if (!is_array($return_value)) {
			// someone already send the email
			return;
		}
		
		$mail_params = elgg_extract('params', $return_value);
		if (!is_array($mail_params)) {
			return;
		}
		
		$action = elgg_extract('action', $mail_params);
		$group = elgg_extract('object', $mail_params);
		if (($action !== 'add_membership') || !($group instanceof \ElggGroup)) {
			return;
		}
		
		$notification = elgg_extract('notification', $mail_params);
		if (!($notification instanceof \Elgg\Notifications\Notification)) {
			return;
		}
		
		$user = $notification->getRecipient();
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		$notifications_enabled = self::notificationsEnabledForGroup($user, $group);
		$additional_msg = self::generateEmailNotificationText($user, $notifications_enabled);
		
		$return_value['body'] .= PHP_EOL . PHP_EOL . $additional_msg;
		
		return $return_value;
	}
	
	/**
	 * Check if the user is receiving notifications from the group
	 *
	 * @param \ElggUser  $user  the user to check
	 * @param \ElggGroup $group the group to check for
	 *
	 * @return bool
	 */
	public static function notificationsEnabledForGroup(\ElggUser $user, \ElggGroup $group) {
		
		if (!($user instanceof \ElggUser) || !($group instanceof \ElggGroup)) {
			return false;
		}
		
		$subscriptions = elgg_get_subscriptions_for_container($group->getGUID());
		if (!is_array($subscriptions)) {
			return false;
		}
		
		if (!empty($subscriptions[$user->getGUID()])) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Generate text to append to an email notification with a link to the group notification settings
	 *
	 * @param \ElggUser $user    the user to generate for
	 * @param bool      $enabled notifications enabled or not
	 *
	 * @return string
	 */
	protected static function generateEmailNotificationText(\ElggUser $user, $enabled) {
		$enabled = (bool) $enabled;
		
		if (!($user instanceof \ElggUser)) {
			return '';
		}
		
		$notifications_url = elgg_normalize_url("notifications/group/{$user->username}");
		if ($enabled) {
			return elgg_echo('group_tools:notifications:toggle:email:enabled', [$notifications_url], $user->language);
		}
		
		return elgg_echo('group_tools:notifications:toggle:email:disabled', [$notifications_url], $user->language);
	}
}

<?php

namespace ColdTrick\GroupTools;

class TitleMenu {
	
	/**
	 * Change the name/function of the group join button
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupMembership($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('groups')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		$user = elgg_get_logged_in_user_entity();
		
		if (!($page_owner instanceof \ElggGroup) || !($user instanceof \ElggUser)) {
			return;
		}
		
		if (empty($return_value) || !is_array($return_value)) {
			return;
		}
		
		foreach ($return_value as $menu_item) {
			// group join button?
			if ($menu_item->getName() !== 'groups:joinrequest') {
				continue;
			}
			
			if (check_entity_relationship($user->getGUID(), 'membership_request', $page_owner->getGUID())) {
				// user already requested to join this group
				$menu_item->setText(elgg_echo('group_tools:joinrequest:already'));
				$menu_item->setTooltip(elgg_echo('group_tools:joinrequest:already:tooltip'));
				$menu_item->setHref("action/groups/killrequest?user_guid={$user->getGUID()}&group_guid={$page_owner->getGUID()}");
				$menu_item->is_action = true;
				
			} elseif (check_entity_relationship($page_owner->getGUID(), 'invited', $user->getGUID())) {
				// the user was invited, so let him/her join
				$menu_item->setName('groups:join');
				$menu_item->setText(elgg_echo('groups:join'));
				$menu_item->setTooltip(elgg_echo('group_tools:join:already:tooltip'));
				$menu_item->setHref("action/groups/join?user_guid={$user->getGUID()}&group_guid={$page_owner->getGUID()}");
				$menu_item->is_action = true;
				
			} elseif (group_tools_check_domain_based_group($page_owner, $user)) {
				// user has a matching email domain
				$menu_item->setName('groups:join');
				$menu_item->setText(elgg_echo('groups:join'));
				$menu_item->setTooltip(elgg_echo('group_tools:join:domain_based:tooltip'));
				$menu_item->setHref("action/groups/join?user_guid={$user->getGUID()}&group_guid={$page_owner->getGUID()}");
				$menu_item->is_action = true;
				
			} elseif (group_tools_join_motivation_required($page_owner)) {
				// a join motivation is required
				elgg_load_js('lightbox');
				elgg_load_css('lightbox');
				
				$menu_item->setHref("ajax/view/group_tools/forms/motivation?guid={$page_owner->getGUID()}");
				
				$menu_item->addLinkClass('elgg-lightbox');
				$opts = 'data-colorbox-opts';
				$menu_item->$opts = json_encode([
					'width' => '500px',
				]);
			}
			
			break;
		}

		return $return_value;
	}
	
	/**
	 * Change the text of the group invite button, and maybe add it for group members
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function groupInvite($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('groups')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		$user = elgg_get_logged_in_user_entity();
		
		if (!($page_owner instanceof \ElggGroup) || !($user instanceof \ElggUser)) {
			return;
		}
		
		if (empty($return_value) || !is_array($return_value)) {
			return;
		}
		
		// change invite menu text
		$invite_found = false;
		foreach ($return_value as $index => $menu_item) {
			
			if ($menu_item->getName() !== 'groups:invite') {
				continue;
			}
			
			$invite_found = true;
			
			$invite_friends = elgg_get_plugin_setting('invite_friends', 'group_tools', 'yes');
			$invite = elgg_get_plugin_setting('invite', 'group_tools');
			$invite_email = elgg_get_plugin_setting('invite_email', 'group_tools');
			$invite_csv = elgg_get_plugin_setting('invite_csv', 'group_tools');
			
			if (in_array('yes', [$invite, $invite_csv, $invite_email])) {
				$menu_item->setText(elgg_echo('group_tools:groups:invite'));
			} elseif ($invite_friends === 'no') {
				unset($return_value[$index]);
			}
			
			break;
		}
		
		// maybe allow normal users to invite new members
		if (!elgg_in_context('group_profile') || $invite_found) {
			return $return_value;
		}
		
		// this is only allowed for group members
		if (!$page_owner->isMember($user)) {
			return;
		}
		
		// we're on a group profile page, but haven't found the invite button yet
		// so check if it should be here
		$setting = elgg_get_plugin_setting('invite_members', 'group_tools');
		if (!in_array($setting, ['yes_off', 'yes_on'])) {
			return;
		}
		
		// check group settings
		$invite_members = $page_owner->invite_members;
		if (empty($invite_members)) {
			$invite_members = 'no';
			if ($setting == 'yes_on') {
				$invite_members = 'yes';
			}
		}
		
		if ($invite_members !== 'yes') {
			return;
		}
		
		// normal users are allowed to invite users
		$invite_friends = elgg_get_plugin_setting('invite_friends', 'group_tools', 'yes');
		$invite = elgg_get_plugin_setting('invite', 'group_tools');
		$invite_email = elgg_get_plugin_setting('invite_email', 'group_tools');
		$invite_csv = elgg_get_plugin_setting('invite_csv', 'group_tools');
		
		if (in_array('yes', [$invite, $invite_csv, $invite_email])) {
			$text = elgg_echo('group_tools:groups:invite');
		} elseif ($invite_friends !== 'no') {
			$text = elgg_echo('groups:invite');
		} else {
			// not allowed
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'groups:invite',
			'href' => "groups/invite/{$page_owner->getGUID()}",
			'text' => $text,
			'link_class' => 'elgg-button elgg-button-action',
		]);
		
		return $return_value;
	}
	
	/**
	 * add button to export users
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function exportGroupMembers($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('groups')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if (!($page_owner instanceof \ElggGroup)) {
			return;
		}
		
		if (!is_array($return_value)) {
			return;
		}
		
		// group member export
		$group_members_page = elgg_normalize_url("groups/members/{$page_owner->getGUID()}");
		if (strpos(current_page_url(), $group_members_page) === false) {
			return;
		}
		
		if (!$page_owner->canEdit() || (elgg_get_plugin_setting('member_export', 'group_tools') !== 'yes')) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'member_export',
			'text' => elgg_echo('group_tools:member_export:title_button'),
			'href' => "action/group_tools/member_export?group_guid={$page_owner->getGUID()}",
			'is_action' => true,
			'link_class' => 'elgg-button elgg-button-action',
		]);
		
		return $return_value;
	}
	
	
	/**
	 * Change title menu buttons for a group pending admin approval
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function pendingApproval($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('groups')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if (!($page_owner instanceof \ElggGroup)) {
			return;
		}
		
		if ($page_owner->access_id !== ACCESS_PRIVATE) {
			return;
		}
		
		if (!is_array($return_value)) {
			return;
		}
		
		$allowed_items = [
			'groups:edit',
		];
		
		// cleanup all items
		foreach ($return_value as $index => $menu_item) {
			if (in_array($menu_item->getName(), $allowed_items)) {
				continue;
			}
			
			unset($return_value[$index]);
		}
		
		// add admin actions
		if (elgg_is_admin_logged_in()) {
			// approve
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'approve',
				'text' => elgg_echo('approve'),
				'href' => 'action/group_tools/admin/approve?guid=' . $page_owner->getGUID(),
				'confirm' => true,
				'class' => 'elgg-button elgg-button-submit',
			]);
			
			// decline
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'decline',
				'text' => elgg_echo('decline'),
				'href' => 'action/group_tools/admin/decline?guid=' . $page_owner->getGUID(),
				'confirm' => elgg_echo('group_tools:group:admin_approve:decline:confirm'),
				'class' => 'elgg-button elgg-button-delete',
			]);
		}
		
		return $return_value;
	}
}

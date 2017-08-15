<?php
/**
 * This class handles the sidebar cleanup for groups
 */

namespace ColdTrick\GroupTools;

class Cleanup {
	
	const SETTING_PREFIX = 'group_tools:cleanup:';
	/**
	 * Hide the members listing in the sidebar
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function hideSidebarMembers($hook, $type, $return_value, $params) {
		
		$group = elgg_extract('entity', $return_value);
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		if ($group->canEdit()) {
			return;
		}
		
		if ($group->getPrivateSetting(self::SETTING_PREFIX . 'members') !== 'yes') {
			return;
		}
		
		$return_value[\Elgg\ViewsService::OUTPUT_KEY] = '';
		
		return $return_value;
	}
	
	/**
	 * Hide my status in the sidebar
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function hideMyStatus($hook, $type, $return_value, $params) {
		
		$group = elgg_extract('entity', $return_value);
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		if ($group->canEdit()) {
			return;
		}
		
		if ($group->getPrivateSetting(self::SETTING_PREFIX . 'my_status') !== 'yes') {
			return;
		}
		
		$return_value[\Elgg\ViewsService::OUTPUT_KEY] = '';
		
		return $return_value;
	}
	
	/**
	 * Hide the search box in the sidebar
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function hideSearchbox($hook, $type, $return_value, $params) {
		
		$group = elgg_extract('entity', $return_value);
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		if ($group->canEdit()) {
			return;
		}
		
		if ($group->getPrivateSetting(self::SETTING_PREFIX . 'search') !== 'yes') {
			return;
		}
		
		$return_value[\Elgg\ViewsService::OUTPUT_KEY] = '';
		
		return $return_value;
	}
	
	/**
	 * Hide the extras menu in the sidebar
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|array
	 */
	public static function hideExtrasMenu($hook, $type, $return_value, $params) {
		
		$page_owner = elgg_get_page_owner_entity();
		if (!($page_owner instanceof \ElggGroup)) {
			return;
		}
		
		if ($page_owner->canEdit()) {
			return;
		}
		
		if ($page_owner->getPrivateSetting(self::SETTING_PREFIX . 'extras_menu') !== 'yes') {
			return;
		}
		
		return [];
	}
	
	/**
	 * Hide the membership action buttons
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|array
	 */
	public static function hideMembershipActions($hook, $type, $return_value, $params) {
		
		if (!is_array($return_value)) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if (!($page_owner instanceof \ElggGroup) || ! elgg_in_context('group_profile')) {
			return;
		}
		
		if ($page_owner->canEdit()) {
			return;
		}
		
		if ($page_owner->getPrivateSetting(self::SETTING_PREFIX . 'actions') !== 'yes') {
			return;
		}
		
		$remove_menu_items = [
			'groups:join',
			'groups:joinrequest',
			'membership_status',
		];
		
		$is_member = $page_owner->isMember();
		
		foreach ($return_value as $section => $menu_items) {
			
			if (!is_array($menu_items)) {
				continue;
			}
			
			/* @var $menu_item \ElggmenuItem */
			foreach ($menu_items as $index => $menu_item) {
				
				if (!in_array($menu_item->getName(), $remove_menu_items)) {
					continue;
				}
				
				if (($menu_item->getName() === 'membership_status') && $is_member) {
					continue;
				}
				
				// remove menu item
				unset($return_value[$section][$index]);
			}
			
			// check if section is empty, to prevent output of empty <ul>
			if (empty($return_value[$section])) {
				unset($return_value[$section]);
			}
		}
		
		return $return_value;
	}
	
	/**
	 * Hide the owner_block menu in the sidebar
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|array
	 */
	public static function hideOwnerBlockMenu($hook, $type, $return_value, $params) {
		
		if (!is_array($params)) {
			return;
		}
		
		$group = elgg_extract('entity', $params);
		if (!($group instanceof \ElggGroup)) {
			return;
		}
		
		if ($group->canEdit()) {
			return;
		}
		
		if ($group->getPrivateSetting(self::SETTING_PREFIX . 'menu') !== 'yes') {
			return;
		}
		
		return [];
	}
}

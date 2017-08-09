<?php

namespace ColdTrick\GroupTools;

class EntityMenu {
	
	/**
	 * Remove the group as a related group
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function relatedGroup($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('group_tools_related_groups')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		$entity = elgg_extract('entity', $params);
		if (!($page_owner instanceof \ElggGroup) || !($entity instanceof \ElggGroup)) {
			return;
		}
		
		if (!$page_owner->canEdit()) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'related_group',
			'text' => elgg_echo('group_tools:related_groups:entity:remove'),
			'href' => "action/group_tools/remove_related_groups?group_guid={$page_owner->getGUID()}&guid={$entity->getGUID()}",
			'confirm' => true,
		]);
		
		return $return_value;
	}
	
	/**
	 * Show number of members
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function showMemberCount($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('widgets_groups_show_members')) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		$num_members = $entity->getMembers(['count' => true]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'members',
			'text' => $num_members . ' ' . elgg_echo('groups:member'),
			'href' => false,
			'priority' => 200,
		]);
		
		return $return_value;
	}
	
	/**
	 * Show the group access status indicator
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function showGroupHiddenIndicator($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		if (!group_tools_show_hidden_indicator($entity)) {
			return;
		}
		
		$access_id_string = get_readable_access_level($entity->access_id);
		$text = elgg_format_element('span', ['title' => $access_id_string], elgg_view_icon('eye'));
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'hidden_indicator',
			'text' => $text,
			'href' => false,
			'priority' => 1,
		]);
		
		return $return_value;
	}
	
	/**
	 * Remove user from a group
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function removeUserFromGroup($hook, $type, $return_value, $params) {
		
		if (elgg_in_context('widgets')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		$entity = elgg_extract('entity', $params);
		if (!($page_owner instanceof \ElggGroup) || !($entity instanceof \ElggUser)) {
			return;
		}
		
		if (!$page_owner->canEdit() || !$page_owner->isMember($entity)) {
			return;
		}
		
		if (($page_owner->getOwnerGUID() === $entity->getGUID()) || ($entity->getGUID() === elgg_get_logged_in_user_guid())) {
			return;
		}
		
		// remove user from group
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'removeuser',
			'text' => elgg_echo('groups:removeuser'),
			'href' => "action/groups/remove?user_guid={$entity->getGUID()}&group_guid={$page_owner->getGUID()}",
			'confirm' => true,
			'priority' => 900,
		]);
		
		return $return_value;
	}
}

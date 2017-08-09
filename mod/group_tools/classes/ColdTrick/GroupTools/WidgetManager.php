<?php

namespace ColdTrick\GroupTools;

class WidgetManager {
	
	/**
	 * Set the title URL for the group tools widgets
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function widgetURL($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			// someone already set an url
			return;
		}
		
		$widget = elgg_extract('entity', $params);
		if (!($widget instanceof \ElggWidget)) {
			return;
		}
		
		switch ($widget->handler) {
			case 'group_members':
				$return_value = "groups/members/{$widget->getOwnerGUID()}";
				break;
			case 'group_invitations':
				$user = elgg_get_logged_in_user_entity();
				if (!empty($user)) {
					$return_value = "groups/invitations/{$user->username}";
				}
				break;
			case 'group_river_widget':
				if ($widget->context !== 'groups') {
					$group_guid = (int) $widget->group_guid;
				} else {
					$group_guid = $widget->getOwnerGUID();
				}
				
				if (!empty($group_guid)) {
					$group = get_entity($group_guid);
					if ($group instanceof \ElggGroup) {
						$return_value = "groups/activity/{$group->getGUID()}";
					}
				}
				break;
			case 'index_groups':
				$return_value = 'groups/all';
				break;
			case 'featured_groups':
				$return_value = 'groups/all?filter=featured';
				break;
			case 'a_user_groups':
				$owner = $widget->getOwnerEntity();
				if ($owner instanceof \ElggUser) {
					$return_value = "groups/member/{$owner->username}";
				}
				break;
			case 'group_related':
				$return_value = "groups/related/{$widget->getOwnerGUID()}";
				break;
		}
		
		return $return_value;
	}
	
	/**
	 * Add or remove widgets based on the group tool option
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function groupToolWidgets($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		if (!is_array($return_value)) {
			return;
		}
		
		// check different group tools for which we supply widgets
		if ($entity->related_groups_enable === 'yes') {
			$return_value['enable'][] = 'group_related';
		} else {
			$return_value['disable'][] = 'group_related';
		}
			
		if ($entity->activity_enable === 'yes') {
			$return_value['enable'][] = 'group_river_widget';
		} else {
			$return_value['disable'][] = 'group_river_widget';
		}
		
		return $return_value;
	}
}

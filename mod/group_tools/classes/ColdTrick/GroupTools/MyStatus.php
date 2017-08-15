<?php

namespace ColdTrick\GroupTools;

class MyStatus {
	
	/**
	 * Change the join status menu item
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerJoinStatus($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			return;
		}
		
		foreach ($return_value as $menu_item) {
			if ($menu_item->getName() !== 'membership_status') {
				continue;
			}
			
			if ($menu_item->getText() !== elgg_echo('groups:join')) {
				// @todo this should be nicer, but Elgg give the same name to 3 use cases??!!!
				continue;
			}
			
			if (check_entity_relationship($user->getGUID(), 'membership_request', $entity->getGUID())) {
				// user already requested to join this group
				$menu_item->setText(elgg_echo('group_tools:joinrequest:already'));
				$menu_item->setTooltip(elgg_echo('group_tools:joinrequest:already:tooltip'));
				$menu_item->setHref("action/groups/killrequest?user_guid={$user->getGUID()}&group_guid={$entity->getGUID()}");
				$menu_item->is_action = true;
				
			} elseif (check_entity_relationship($entity->getGUID(), 'invited', $user->getGUID())) {
				// the user was invited, so let him/her join
				$menu_item->setTooltip(elgg_echo('group_tools:join:already:tooltip'));
				
			} elseif (group_tools_check_domain_based_group($entity, $user)) {
				// user has a matching email domain
				$menu_item->setTooltip(elgg_echo('group_tools:join:domain_based:tooltip'));
				
			} elseif (group_tools_join_motivation_required($entity)) {
				// a join motivation is required
				elgg_load_js('lightbox');
				elgg_load_css('lightbox');
				
				$menu_item->setHref("ajax/view/group_tools/forms/motivation?guid={$entity->getGUID()}");
				
				$menu_item->addLinkClass('elgg-lightbox');
				$opts = 'data-colorbox-opts';
				$menu_item->$opts = json_encode([
					'width' => '500px',
				]);
			}
		}
	}
}

<?php

namespace ColdTrick\TheWireTools;

class Menus {
	
	/**
	 * Add reshare menu items to the entity menu
	 *
	 * @param string          $hook        the name of the hook
	 * @param string          $type        the type of the hook
	 * @param \ElggMenuItem[] $returnvalue current return value
	 * @param array           $params      supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function entityRegisterReshare($hook, $type, $returnvalue, $params) {
		
		if (!elgg_is_logged_in()) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggEntity)) {
			return;
		}
		
		if (!self::canReshareEntity($entity)) {
			return;
		}
		
		elgg_load_js('elgg.thewire');
	
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
	
		$reshare_guid = $entity->getGUID();
		$reshare = null;
		
		if (elgg_instanceof($entity, 'object', 'thewire')) {
			$reshare = $entity->getEntitiesFromRelationship([
				'relationship' => 'reshare',
				'limit' => 1,
				'callback' => function($row) {
					return (int) $row->guid;
				},
			]);
			if ($reshare) {
				// this is a wire post which is a reshare, so link to original object
				$reshare_guid = $reshare[0];
			}
		}
		
		if (empty($reshare)) {
			// check is this item was shared on thewire
			$count = $entity->getEntitiesFromRelationship([
				'type' => 'object',
				'subtype' => 'thewire',
				'relationship' => 'reshare',
				'inverse_relationship' => true,
				'count' => true,
			]);
			
			if ($count) {
				// show counter
				$returnvalue[] = \ElggMenuItem::factory([
					'name' => 'thewire_tools_reshare_count',
					'text' => $count,
					'title' => elgg_echo('thewire_tools:reshare:count'),
					'href' => 'ajax/view/thewire_tools/reshare_list?entity_guid=' . $reshare_guid,
					'link_class' => 'elgg-lightbox',
					'is_trusted' => true,
					'priority' => 501,
					'data-colorbox-opts' => json_encode(['maxHeight' => '85%']),
				]);
			}
		}
	
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'thewire_tools_reshare',
			'text' => elgg_view_icon('share'),
			'title' => elgg_echo('thewire_tools:reshare'),
			'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $reshare_guid,
			'link_class' => 'elgg-lightbox',
			'is_trusted' => true,
			'priority' => 500,
		]);
		
		return $returnvalue;
	}
	
	/**
	 * Check if resharing of this entity is allowed
	 *
	 * @param \ElggEntity $entity the entity to check
	 *
	 * @return bool
	 */
	protected static function canReshareEntity(\ElggEntity $entity) {
		
		if (!($entity instanceof \ElggEntity)) {
			return false;
		}
		
		// only allow objects and groups
		if (!($entity instanceof \ElggObject) && !($entity instanceof \ElggGroup)) {
			return false;
		}
		
		// comments and discussion replies are never allowed
		$blocked_subtypes = ['comment', 'discussion_reply'];
		if (in_array($entity->getSubtype(), $blocked_subtypes)) {
			return false;
		}
		
		// by default allow searchable entities
		$reshare_allowed = false;
		if ($entity instanceof \ElggGroup) {
			$reshare_allowed = true;
		} else {
			$searchable_entities = get_registered_entity_types($entity->getType());
			if (!empty($searchable_entities)) {
				$reshare_allowed = in_array($entity->getSubtype(), $searchable_entities);
			}
		}
		
		// trigger hook to allow others to change
		$params = [
			'entity' => $entity,
			'user' => elgg_get_logged_in_user_entity(),
		];
		return (bool) elgg_trigger_plugin_hook('reshare', $entity->getType(), $params, $reshare_allowed);
	}
	
	/**
	 * Optionally extend the group owner block with a link to the wire posts of the group
	 *
	 * @param string         $hook_name   'register'
	 * @param string         $entity_type 'menu:owner_block'
	 * @param ElggMenuItem[] $return      all the current menu items
	 * @param array          $params      supplied params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function ownerBlockRegister($hook_name, $entity_type, $return, $params) {
		$group = elgg_extract('entity', $params);
		if (!elgg_instanceof($group, 'group')) {
			return;
		}
		
		if (!thewire_tools_groups_enabled()) {
			return;
		}
	
		if ($group->thewire_enable == 'no') {
			return;
		}
	
		if (!$group->canEdit() && !$group->isMember()) {
			return;
		}

		$return[] = new \ElggMenuItem('thewire', elgg_echo('thewire_tools:group:title'), "thewire/group/{$group->getGUID()}");
	
		return $return;
	}
	
	/**
	 * Improves entity menu items for thewire objects
	 *
	 * @param string         $hook_name   'register'
	 * @param string         $entity_type 'menu:entity'
	 * @param ElggMenuItem[] $return      the current menu items
	 * @param array          $params      supplied params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function entityRegisterImprove($hook_name, $entity_type, $return, $params) {
	
		$entity = elgg_extract('entity', $params, false);
		if (!elgg_instanceof($entity, 'object', 'thewire')) {
			return;
		}
		
		if (!is_array($return)) {
			return;
		}
		
		foreach ($return as $index => $menu_item) {
			switch ($menu_item->getName()) {
				case 'thread':
						
					if (elgg_in_context('thewire_tools_thread') || elgg_in_context('thewire_thread')) {
						unset($return[$index]);
						break;
					}
						
					//removes thread link from thewire entity menu if there is no conversation
					if (!($entity->countEntitiesFromRelationship('parent') || $entity->countEntitiesFromRelationship('parent', true))) {
						unset($return[$index]);
					} else {
						$menu_item->rel = $entity->getGUID();
					}
					break;
				case 'previous':
					unset($return[$index]);
					break;
				case 'reply':
					if (elgg_in_context('thewire_tools_thread')) {
						unset($return[$index]);
						break;
					}
						
					$menu_item->setHref("#thewire-tools-reply-{$entity->getGUID()}");
					$menu_item->rel = 'toggle';
					break;
			}
		}
	
		return $return;
	}
	
	/**
	 * Add wire reply link to river wire entities
	 *
	 * @param string         $hook_name   'register'
	 * @param string         $entity_type 'menu:river'
	 * @param ElggMenuItem[] $return      the current menu items
	 * @param array          $params      supplied params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function riverRegisterReply($hook_name, $entity_type, $return, $params) {
		if (!elgg_is_logged_in()) {
			return;
		}
		
		$item = elgg_extract('item', $params);
		$entity = $item->getObjectEntity();
	
		if (!elgg_instanceof($entity, 'object', 'thewire')) {
			return;
		}
		
		if (!is_array($return)) {
			$return = [];
		}
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'reply',
			'text' => elgg_echo('reply'),
			'href' => "thewire/reply/{$entity->getGUID()}",
			'priority' => 150,
		]);
		
		return $return;
	}
	
	/**
	 * Add feature menu items to the entity menu of a wire post
	 *
	 * @param string          $hook        the name of the hook
	 * @param string          $type        the type of the hook
	 * @param \ElggMenuItem[] $returnvalue current return value
	 * @param array           $params      supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function entityRegisterFeature($hook, $type, $returnvalue, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggWire)) {
			return;
		}
		
		$container = $entity->getContainerEntity();
		if ($container instanceof \ElggGroup) {
			if (!$container->canEdit()) {
				return;
			}
		} elseif (!elgg_is_admin_logged_in()) {
			return;
		}
		
		elgg_require_js('thewire_tools/entity_menu');
		
		$featured = !empty($entity->featured);
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'thewire_tools_feature',
			'text' => elgg_echo('thewire_tools:feature'),
			'href' => "action/thewire_tools/toggle_feature?guid={$entity->getGUID()}",
			'is_action' => true,
			'item_class' => $featured ? 'hidden' : '',
			'priority' => 200,
		]);
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'thewire_tools_unfeature',
			'text' => elgg_echo('thewire_tools:unfeature'),
			'href' => "action/thewire_tools/toggle_feature?guid={$entity->getGUID()}",
			'is_action' => true,
			'item_class' => $featured ? '' : 'hidden',
			'priority' => 201,
		]);
		
		return $returnvalue;
	}
	
	/**
	 * Add menu items to the page menu on thewire pages
	 *
	 * @param string          $hook        the name of the hook
	 * @param string          $type        the type of the hook
	 * @param \ElggMenuItem[] $returnvalue current return value
	 * @param array           $params      supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function pageRegister($hook, $type, $returnvalue, $params) {
		
		if (!elgg_in_context('thewire')) {
			return;
		}
		
		$page_owner = elgg_get_page_owner_entity();
		if ($page_owner instanceof \ElggGroup) {
			return;
		}
		
		$user = elgg_get_logged_in_user_entity();
		if (!empty($user)) {
			$returnvalue[] = \ElggMenuItem::factory([
				'name' => 'mentions',
				'href' => "thewire/search/@{$user->username}",
				'text' => elgg_echo('thewire_tools:menu:mentions'),
			]);
		}
		
		$returnvalue[] = \ElggMenuItem::factory([
			'name' => 'search',
			'href' => 'thewire/search',
			'text' => elgg_echo('search'),
		]);
		
		return $returnvalue;
	}
}

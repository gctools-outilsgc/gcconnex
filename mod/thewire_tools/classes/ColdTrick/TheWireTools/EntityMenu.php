<?php

namespace ColdTrick\TheWireTools;

class EntityMenu {
	
	/**
	 * Add resahre menu items to the entity menu
	 *
	 * @param string          $hook        the name of the hook
	 * @param string          $type        the type of the hook
	 * @param \ElggMenuItem[] $returnvalue current return value
	 * @param array           $params      supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerReshare($hook, $type, $returnvalue, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (empty($entity) || !elgg_instanceof($entity)) {
			return;
		}
		
		// add reshare options
		$blocked_subtypes = array('comment', 'discussion_reply');
		if (!(elgg_instanceof($entity, 'object') || elgg_instanceof($entity, 'group')) || in_array($entity->getSubtype(), $blocked_subtypes)) {
			return;
		}
		
		elgg_load_js('elgg.thewire');
	
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
	
		$reshare_guid = $entity->getGUID();
		$reshare = $entity->getEntitiesFromRelationship(array('relationship' => 'reshare', 'limit' => 1));
		if (!empty($reshare)) {
			// this is a wire post which is a reshare, so link to original object
			$reshare_guid = $reshare[0]->getGUID();
		} else {
			// check is this item was shared on thewire
			$count = $entity->getEntitiesFromRelationship(array(
				'type' => 'object',
				'subtype' => 'thewire',
				'relationship' => 'reshare',
				'inverse_relationship' => true,
				'count' => true
			));
			
			if ($count) {
				// show counter
				$returnvalue[] = \ElggMenuItem::factory(array(
					'name' => 'thewire_tools_reshare_count',
					'text' => $count,
					'title' => elgg_echo('thewire_tools:reshare:count'),
					'href' => 'ajax/view/thewire_tools/reshare_list?entity_guid=' . $reshare_guid,
					'link_class' => 'elgg-lightbox',
					'is_trusted' => true,
					'priority' => 501,
					'data-colorbox-opts' => json_encode(array(
						'maxHeight' => '85%'
					))
				));
			}
		}
	
		$returnvalue[] = \ElggMenuItem::factory(array(
			'name' => 'thewire_tools_reshare',
			'text' => elgg_view_icon('share'),
			'title' => elgg_echo('thewire_tools:reshare'),
			'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $reshare_guid,
			'link_class' => 'elgg-lightbox',
			'is_trusted' => true,
			'priority' => 500
		));
		
		return $returnvalue;
	}
}

<?php

namespace ColdTrick\GroupTools;

class OwnerBlockMenu {
	
	/**
	 * Add a link to the related groups page
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return vaue
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function relatedGroups($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		if ($entity->related_groups_enable !== 'yes') {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'related_groups',
			'text' => elgg_echo('group_tools:related_groups:title'),
			'href' => "groups/related/{$entity->getGUID()}",
			'is_trusted' => true,
		]);
		
		return $return_value;
	}
}

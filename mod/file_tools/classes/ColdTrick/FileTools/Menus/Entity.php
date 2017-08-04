<?php

namespace ColdTrick\FileTools\Menus;

class Entity {
	
	/**
	 * Add items to the file entity menu
	 *
	 * @param string         $hook        the name of the hook
	 * @param string         $type        the type of the hook
	 * @param ElggMenuItem[] $return_value current return value
	 * @param array          $params      supplied params
	 *
	 * @return void|ElggMenuItem[]
	 */
	public static function registerFile($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggFile)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'download',
			'text' => elgg_view_icon('download'),
			'title' => elgg_echo('download'),
			'href' => elgg_get_download_url($entity),
			'priority' => 200,
		]);
		
		return $return_value;
	}
}

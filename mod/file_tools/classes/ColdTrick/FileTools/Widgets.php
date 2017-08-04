<?php

namespace ColdTrick\FileTools;

class Widgets {
	
	/**
	 * get the URL of a widget
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function wigetGetURL($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			// url already set
			return;
		}
		
		$widget = elgg_extract('entity', $params);
		if (!($widget instanceof \ElggWidget)) {
			return;
		}
		
		$owner = $widget->getOwnerEntity();
		
		switch ($widget->handler) {
			case 'file_tree':
			case 'filerepo':
				if ($owner instanceof \ElggUser) {
					return "file/owner/{$owner->username}";
				} elseif ($owner instanceof \ElggGroup) {
					return "file/group/{$owner->getGUID()}/all";
				}
				
				break;
			case 'group_files':
				return "file/group/{$owner->getGUID()}/all";
				break;
			case 'index_file':
				return 'file/all';
				break;
		}
	}
	
	/**
	 * get registered widgets
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|\Elgg\WidgetDefinition[]
	 */
	public static function getHandlers($hook, $type, $return_value, $params) {
		
		$page_owner = elgg_get_page_owner_entity();
		
		$context = elgg_extract('context', $params);
		switch ($context) {
			case 'index':
				
				$return_value[] = \Elgg\WidgetDefinition::factory([
					'id' => 'index_file',
					'name' => elgg_echo('file'),
					'description' => elgg_echo('widgets:index_file:description'),
					'context' => [$context],
					'multiple' => true,
				]);
				
				break;
			case 'groups':
				
				if (($page_owner instanceof \ElggGroup) && ($page_owner->files_enable === 'no')) {
					// no files for this group
					break;
				}
				
				$return_value[] = \Elgg\WidgetDefinition::factory([
					'id' => 'file_tree',
					'name' => elgg_echo('widgets:file_tree:title'),
					'description' => elgg_echo('widgets:file_tree:description'),
					'context' => [$context],
					'multiple' => true,
				]);
				
				$return_value[] = \Elgg\WidgetDefinition::factory([
					'id' => 'group_files',
					'name' => elgg_echo('file:group'),
					'description' => elgg_echo('widgets:group_files:description'),
					'context' => [$context],
				]);
				
				break;
			case 'profile':
			case 'dashboard':
				
				$return_value[] = \Elgg\WidgetDefinition::factory([
					'id' => 'file_tree',
					'name' => elgg_echo('widgets:file_tree:title'),
					'description' => elgg_echo('widgets:file_tree:description'),
					'context' => [$context],
					'multiple' => true,
				]);
				break;
		}
		
		return $return_value;
	}
}

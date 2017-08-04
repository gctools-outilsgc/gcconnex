<?php

namespace ColdTrick\FileTools\Menus;

class FolderBreadcrumb {
	
	/**
	 * Set folder breadcrumb menu
	 *
	 * @param string         $hook        the name of the hook
	 * @param string         $type        the type of the hook
	 * @param ElggMenuItem[] $return_value current return value
	 * @param array          $params      supplied params
	 *
	 * @return void|ElggMenuItem[]
	 */
	public static function register($hook, $type, $return_value, $params) {
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$container = elgg_get_page_owner_entity();
		
		/* @var $folder \ElggObject */
		$folder = elgg_extract('entity', $params);
		if (elgg_instanceof($folder, 'object', FILE_TOOLS_SUBTYPE)) {
			$container = $folder->getContainerEntity();
			
			$priority = 9999999;
			
			$return_value[] = \ElggMenuItem::factory([
				'name' => "folder_{$folder->getGUID()}",
				'text' => $folder->getDisplayName(),
				'href' => false,
				'priority' => $priority,
			]);
			
			$parent_guid = (int) $folder->parent_guid;
			while (!empty($parent_guid)) {
				$parent = get_entity($parent_guid);
				if (!elgg_instanceof($parent, 'object', FILE_TOOLS_SUBTYPE)) {
					break;
				}
				
				$priority--;
				
				$return_value[] = \ElggMenuItem::factory([
					'name' => "folder_{$parent->getGUID()}",
					'text' => $parent->getDisplayName(),
					'href' => $parent->getURL(),
					'priority' => $priority,
				]);
				$parent_guid = (int) $parent->parent_guid;
			}
		}
		
		// make main folder item
		$main_folder_options = [
			'name' => 'main_folder',
			'text' => elgg_echo('file_tools:list:folder:main'),
			'priority' => 0,
		];
		
		if ($container instanceof \ElggGroup) {
			$main_folder_options['href'] = "file/group/{$container->getGUID()}/all#";
		} else {
			$main_folder_options['href'] = "file/owner/{$container->username}/all#";
		}
		
		$return_value[] = \ElggMenuItem::factory($main_folder_options);
		
		return $return_value;
	}
}

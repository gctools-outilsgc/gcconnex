<?php

namespace ColdTrick\TheWireTools;

class Router {
	
	/**
	 * Extends thewire pagehandler with some extra pages
	 *
	 * @param string $hook_name   'route'
	 * @param string $entity_type 'thewire'
	 * @param bool   $return      the default return value
	 * @param array  $params      supplied params
	 *
	 * @return bool
	 */
	public static function thewire($hook_name, $entity_type, $return, $params) {
		$page = elgg_extract('segments', $return);
	
		if (!isset($page[0])) {
			$page = ['all'];
		}
	
		switch ($page[0]) {
			case 'all':
			case 'owner':
				set_input('limit', get_input('limit', elgg_get_config('default_limit')));
				return;
			case 'group':
				if (!empty($page[1])) {
					set_input('group_guid', $page[1]); // @todo is this still needed or replace with page_owner in page
						
					if (!empty($page[2])) {
						set_input('wire_username', $page[2]); // @todo is this still needed?
					}
						
					echo elgg_view_resource('thewire/group');
					return false;
				}
			case 'tag':
			case 'search':
				if (isset($page[1])) {
					if ($page[0] == 'tag') {
						set_input('query', '#' . $page[1]);
					} else {
						set_input('query', $page[1]);
					}
				}
					
				echo elgg_view_resource('thewire/search');
				return false;
			case 'autocomplete':
				echo elgg_view_resource('thewire/autocomplete');
				return false;
			case 'thread':
				elgg_push_context('thewire_thread');
			case 'reply':
				if (!empty($page[1])) {
					$entity = get_entity($page[1]);
	
					if (!empty($entity) && elgg_instanceof($entity->getContainerEntity(), 'group')) {
						elgg_set_page_owner_guid($entity->getContainerGUID());
					}
				}
				break;
	
		}
	}
}
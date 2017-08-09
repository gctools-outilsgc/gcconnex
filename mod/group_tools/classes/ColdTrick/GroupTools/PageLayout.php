<?php

namespace ColdTrick\GroupTools;

class PageLayout {
	
	/**
	 * Don't allow closed groups to be indexed by search engines
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param mixed  $params       supplied params
	 */
	public static function noIndexClosedGroups($hook, $type, $return_value, $params) {
		
		$page_owner = elgg_get_page_owner_entity();
		if (!($page_owner instanceof \ElggGroup)) {
			// not a group
			return;
		}
		
		if ($page_owner->isPublicMembership()) {
			// public group
			return;
		}
		
		if (elgg_get_plugin_setting('search_index', 'group_tools') === 'yes') {
			// indexing is allowed
			return;
		}
		
		$return_value['metas']['robots'] = [
			'name' => 'robots',
			'content' => 'noindex',
		];
		
		return $return_value;
	}
}

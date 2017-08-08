<?php

namespace ColdTrick\TheWireTools;

class Access {
	
	/**
	 * Provide a custom access pulldown for use on personal wire posts
	 *
	 * @param string $hook_name   'access:collections:write'
	 * @param string $entity_type 'all'
	 * @param array  $return      the current access options
	 * @param array  $params      supplied params
	 *
	 * @return array
	 */
	public static function collectionsWrite($hook_name, $entity_type, $return, $params) {
	
		if (!elgg_in_context('thewire_add')) {
			return;
		}
	
		if (empty($return) || !is_array($return)) {
			return;
		}
	
		$user_guid = (int) elgg_extract('user_id', $params, elgg_get_logged_in_user_guid());
		if (empty($user_guid)) {
			return;
		}
	
		// remove unwanted access options
		unset($return[ACCESS_PRIVATE]);
		unset($return[ACCESS_FRIENDS]);
	
		// add groups (as this hook is only trigged when thewire_groups is enabled
		$groups = new \ElggBatch('elgg_get_entities_from_relationship', [
			'type' => 'group',
			'limit' => false,
			'relationship' => 'member',
			'relationship_guid' => $user_guid,
			'joins' => ['JOIN ' . elgg_get_config('dbprefix') . 'groups_entity ge ON e.guid = ge.guid'],
			'order_by' => 'ge.name ASC',
		]);
		foreach ($groups as $group) {
			if ($group->thewire_enable !== 'no') {
				$return[$group->group_acl] = $group->name;
			}
		}
	
		return $return;
	}
}
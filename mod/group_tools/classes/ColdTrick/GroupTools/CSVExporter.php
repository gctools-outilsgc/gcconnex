<?php

namespace ColdTrick\GroupTools;

class CSVExporter {
	
	/**
	 * Add group admins to the exportable values
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function addGroupAdminsToGroups($hook, $type, $return_value, $params) {
		
		$content_type = elgg_extract('type', $params);
		if ($content_type !== 'group') {
			return;
		}
		
		if (!group_tools_multiple_admin_enabled()) {
			// group admins not enabled
			return;
		}
		
		$readable = (bool) elgg_extract('readable', $params, false);
		
		$fields = [
			elgg_echo('group_tools:csv_exporter:group_admin:name') => 'group_tools_group_admin_name',
			elgg_echo('group_tools:csv_exporter:group_admin:email') => 'group_tools_group_admin_email',
			elgg_echo('group_tools:csv_exporter:group_admin:url') => 'group_tools_group_admin_url',
		];
		
		if (!$readable) {
			$fields = array_values($fields);
		}
		
		return array_merge($return_value, $fields);
	}
	
	/**
	 * Add the groups a user is admin of to the exportable values
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function addGroupAdminsToUsers($hook, $type, $return_value, $params) {
		
		$content_type = elgg_extract('type', $params);
		if ($content_type !== 'user') {
			return;
		}
		
		if (!group_tools_multiple_admin_enabled()) {
			// group admins not enabled
			return;
		}
		
		$readable = (bool) elgg_extract('readable', $params, false);
		
		$fields = [
			elgg_echo('group_tools:csv_exporter:user:group_admin:name') => 'group_tools_user_group_admin_name',
			elgg_echo('group_tools:csv_exporter:user:group_admin:url') => 'group_tools_user_group_admin_url',
		];
		
		if (!$readable) {
			$fields = array_values($fields);
		}
		
		return array_merge($return_value, $fields);
	}
	
	/**
	 * Supply the group admin information for the export
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function exportGroupAdminsForGroups($hook, $type, $return_value, $params) {
		
		if (!is_null($return_value)) {
			// someone already provided output
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		$group_admin_options = [
			'type' => 'user',
			'limit' => false,
			'relationship' => 'group_admin',
			'relationship_guid' => $entity->getGUID(),
			'inverse_relationship' => true,
			'wheres' => [
				"e.guid <> {$entity->getOwnerGUID()}",
			],
		];
		
		$exportable_value = elgg_extract('exportable_value', $params);
		switch ($exportable_value) {
			case 'group_tools_group_admin_name':
				$result = [];
				$batch = new \ElggBatch('elgg_get_entities_from_relationship', $group_admin_options);
				/* @var $group_admin \ElggUser */
				foreach ($batch as $group_admin) {
					$result[] = "\"{$group_admin->name}\"";
				}
				return $result;
				break;
			case 'group_tools_group_admin_email':
				$result = [];
				$batch = new \ElggBatch('elgg_get_entities_from_relationship', $group_admin_options);
				/* @var $group_admin \ElggUser */
				foreach ($batch as $group_admin) {
					$result[] = $group_admin->email;
				}
				return $result;
				break;
			case 'group_tools_group_admin_url':
				$result = [];
				$batch = new \ElggBatch('elgg_get_entities_from_relationship', $group_admin_options);
				/* @var $group_admin \ElggUser */
				foreach ($batch as $group_admin) {
					$result[] = $group_admin->getURL();
				}
				return $result;
				break;
		}
	}
	
	/**
	 * Supply the group admin information for the export
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function exportGroupAdminsForUsers($hook, $type, $return_value, $params) {
		
		if (!is_null($return_value)) {
			// someone already provided output
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		$group_admin_options = [
			'type' => 'group',
			'limit' => false,
			'relationship' => 'group_admin',
			'relationship_guid' => $entity->getGUID(),
			'wheres' => [
				"e.guid <> {$entity->getOwnerGUID()}",
			],
		];
		
		$exportable_value = elgg_extract('exportable_value', $params);
		switch ($exportable_value) {
			case 'group_tools_user_group_admin_name':
				$result = [];
				$batch = new \ElggBatch('elgg_get_entities_from_relationship', $group_admin_options);
				/* @var $group_admin \ElggUser */
				foreach ($batch as $group_admin) {
					$result[] = "\"{$group_admin->name}\"";
				}
				return $result;
				break;
			case 'group_tools_user_group_admin_url':
				$result = [];
				$batch = new \ElggBatch('elgg_get_entities_from_relationship', $group_admin_options);
				/* @var $group_admin \ElggUser */
				foreach ($batch as $group_admin) {
					$result[] = $group_admin->getURL();
				}
				return $result;
				break;
		}
	}
	
	/**
	 * Add stale information to the exportable values
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function addStaleInfo($hook, $type, $return_value, $params) {
		
		$content_type = elgg_extract('type', $params);
		if ($content_type !== 'group') {
			return;
		}
		
		if ((int) elgg_get_plugin_setting('stale_timeout', 'group_tools') < 1) {
			return;
		}
		
		$readable = (bool) elgg_extract('readable', $params, false);
		
		$fields = [
			elgg_echo('group_tools:csv_exporter:stale_info:is_stale') => 'group_tools_stale_info_is_stale',
			elgg_echo('group_tools:csv_exporter:stale_info:timestamp') => 'group_tools_stale_info_timestamp',
			elgg_echo('group_tools:csv_exporter:stale_info:timestamp:readable') => 'group_tools_stale_info_timestamp_reabable',
		];
		
		if (!$readable) {
			$fields = array_values($fields);
		}
		
		return array_merge($return_value, $fields);
	}
	
	/**
	 * Export stale information about the group
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|int|string
	 */
	public static function exportStaleInfo($hook, $type, $return_value, $params) {
		
		if (!is_null($return_value)) {
			// someone already provided output
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		$stale_info = group_tools_get_stale_info($entity);
		if (empty($stale_info)) {
			return;
		}
		
		$exportable_value = elgg_extract('exportable_value', $params);
		switch ($exportable_value) {
			case 'group_tools_stale_info_is_stale':
				if ($stale_info->isStale()) {
					return 'yes';
				}
				return 'no';
				break;
			case 'group_tools_stale_info_timestamp':
				$ts = $stale_info->getTimestamp();
				if (empty($ts)) {
					return;
				}
				return $ts;
				break;
			case 'group_tools_stale_info_timestamp_reabable':
				$ts = $stale_info->getTimestamp();
				if (empty($ts)) {
					return;
				}
				return csv_exported_get_readable_timestamp($ts);
				break;
		}
	}
}

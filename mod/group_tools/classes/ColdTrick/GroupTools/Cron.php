<?php

namespace ColdTrick\GroupTools;

class Cron {
	
	/**
	 * Find the new stale groups and notify the owner
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param mixed  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void
	 */
	public static function notifyStaleGroupOwners($hook, $type, $return_value, $params) {
		
		$time = (int) elgg_extract('time', $params, time());
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// get stale groups
		$groups = self::findStaleGroups($time);
		if (empty($groups)) {
			// non found
			elgg_set_ignore_access($ia);
			return;
		}
		
		// process groups
		foreach ($groups as $group) {
			
			$stale_info = group_tools_get_stale_info($group);
			if (empty($stale_info)) {
				// error
				continue;
			}
			
			if (!$stale_info->isStale()) {
				// not stale
				continue;
			}
			
			self::notifyStaleGroupOwner($group);
		}
		
		// restore access
		elgg_set_ignore_access($ia);
	}
	
	/**
	 * Get all stale group, which became stale today
	 *
	 * @param int $ts timestamp to compare to
	 *
	 * @return false|\ElggGroup[]
	 */
	protected static function findStaleGroups($ts) {
		
		if (empty($ts)) {
			return false;
		}
		
		$stale_timeout = (int) elgg_get_plugin_setting('stale_timeout', 'group_tools');
		if ($stale_timeout < 1) {
			return false;
		}
		
		$compare_ts_upper = $ts - ($stale_timeout * 24 * 60 * 60);
		$compare_ts_lower = $compare_ts_upper - (24 * 60 * 60);
		
		$dbprefix = elgg_get_config('dbprefix');
		$touch_md_id = elgg_get_metastring_id('group_tools_stale_touch_ts');
		
		$row_to_guid = function ($row) {
			return (int) $row->guid;
		};
		
		$group_guids = [];
		
		// groups created in timespace
		$options = [
			'type' => 'group',
			'limit' => false,
			'created_time_upper' => $compare_ts_upper,
			'created_time_lower' => $compare_ts_lower,
			'callback' => $row_to_guid,
		];
		$groups_created = elgg_get_entities($options);
		if (!empty($groups_created)) {
			$group_guids = array_merge($group_guids, $groups_created);
		}
		
		// groups with touch in timespace
		$options = [
			'type' => 'group',
			'limit' => false,
			'created_time_upper' => $compare_ts_upper,
			'callback' => $row_to_guid,
			'wheres' => [
				"e.guid IN (SELECT tmd.entity_guid
					FROM {$dbprefix}metadata tmd
					JOIN {$dbprefix}metastrings tmsv ON tmd.value_id = tmsv.id
					WHERE tmd.name_id = {$touch_md_id}
					AND tmd.entity_guid = e.guid
					AND CAST(tmsv.string AS SIGNED) > {$compare_ts_lower}
					AND CAST(tmsv.string AS SIGNED) < {$compare_ts_upper})
				",
			],
		];
		
		$groups_touch_ts = elgg_get_entities($options);
		if (!empty($groups_touch_ts)) {
			$group_guids = array_merge($group_guids, $groups_touch_ts);
		}
		
		// groups with last content in timespace
		$searchable_objects = StaleInfo::getObjectSubtypes();
		$object_ids = [];
		foreach ($searchable_objects as $index => $subtype) {
			switch ($subtype) {
				case 'page':
				case 'page_top':
					$object_ids[] = get_subtype_id('object', 'page');
					$object_ids[] = get_subtype_id('object', 'page_top');
					break;
				case 'comment':
				case 'discussion_reply':
					// don't do these yet
					break;
				default:
					$object_ids[] = get_subtype_id('object', $subtype);
					break;
			}
		}
		
		$object_ids = array_filter($object_ids);
		$object_ids = array_unique($object_ids);
		
		if (!empty($object_ids)) {
			$options = [
				'type' => 'group',
				'limit' => false,
				'created_time_upper' => $compare_ts_upper,
				'callback' => $row_to_guid,
				'wheres' => [
					"e.guid IN (
						SELECT container_guid
						FROM (
							SELECT container_guid, max(time_updated) as time_updated
							FROM {$dbprefix}entities
							WHERE type = 'object'
							AND subtype IN (" . implode(',', $object_ids) . ")
							GROUP BY container_guid
						) as content
						WHERE content.time_updated > {$compare_ts_lower}
						AND content.time_updated < {$compare_ts_upper}
					)",
				],
			];
			
			$group_content_ts = elgg_get_entities($options);
			if (!empty($group_content_ts)) {
				$group_guids = array_merge($group_guids, $group_content_ts);
			}
		}
		
		// groups with last comments/discussion_replies in timespace
		$comment_ids = [];
		$comment_ids[] = get_subtype_id('object', 'comment');
		if (elgg_is_active_plugin('discussions')) {
			$comment_ids[] = get_subtype_id('object', 'discussion_reply');
		}
		
		$options = [
			'type' => 'group',
			'limit' => false,
			'created_time_upper' => $compare_ts_upper,
			'callback' => $row_to_guid,
			'wheres' => [
				"e.guid IN (
					SELECT container_guid
					FROM (
						SELECT ce.container_guid, max(re.time_updated) as time_updated
						FROM {$dbprefix}entities re
						JOIN {$dbprefix}entities ce ON re.container_guid = ce.guid
						WHERE re.type = 'object'
						AND re.subtype IN (" . implode(',', $comment_ids) . ")
						GROUP BY ce.container_guid
					) as comments
					WHERE comments.time_updated > {$compare_ts_lower}
					AND comments.time_updated < {$compare_ts_upper}
				)",
			],
		];
		
		$group_comments_ts = elgg_get_entities($options);
		if (!empty($group_comments_ts)) {
			$group_guids = array_merge($group_guids, $group_comments_ts);
		}
		
		$group_guids = array_unique($group_guids);
		if (empty($group_guids)) {
			return false;
		}
		
		return elgg_get_entities([
			'type' => 'group',
			'limit' => false,
			'guids' => $group_guids,
			'batch' => true,
		]);
	}
	
	/**
	 * Notify the owner of the group
	 *
	 * @param \ElggGroup $entity
	 *
	 * @return void
	 */
	protected static function notifyStaleGroupOwner(\ElggGroup $entity) {
		
		if (!($entity instanceof \ElggGroup)) {
			return;
		}
		
		$owner = $entity->getOwnerEntity();
		if (!($owner instanceof \ElggUser)) {
			return;
		}
		
		$site = elgg_get_site_entity();
		
		$subject = elgg_echo('groups_tools:state_info:notification:subject', [$entity->getDisplayName()]);
		$message = elgg_echo('groups_tools:state_info:notification:message', [
			$owner->getDisplayName(),
			$entity->getDisplayName(),
			$entity->getURL(),
		]);
		
		$mail_params = [
			'object' => $entity,
			'action' => 'group_tools:stale',
			'summary' => elgg_echo('groups_tools:state_info:notification:summary', [$entity->getDisplayName()]),
		];
		
		notify_user($owner->getGUID(), $site->getGUID(), $subject, $message, $mail_params);
	}
}

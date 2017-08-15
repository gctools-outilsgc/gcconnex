<?php

namespace ColdTrick\GroupTools;

class StaleInfo {

	/**
	 * @var \ElggGroup
	 */
	protected $group;
	
	/**
	 * @var int
	 */
	protected $number_of_days;
	
	public function __construct(\ElggGroup $entity, $days) {
		
		$days = (int) $days;
		if ($days < 1) {
			throw new \ClassException('Provide a positive number of days');
		}
		
		$this->group = $entity;
		$this->number_of_days = $days;
	}
	
	/**
	 * Is the group stale
	 *
	 * @return bool
	 */
	public function isStale() {
		
		$compare_ts = time() - ($this->number_of_days * 24 * 60 * 60);
		
		if ($this->group->time_created > $compare_ts) {
			return false;
		}
		
		$ts = $this->getTouchTimestamp();
		if ($ts > $compare_ts) {
			return false;
		}
		
		$ts = $this->getContentTimestamp();
		if ($ts > $compare_ts) {
			return false;
		}
		
		$ts = $this->getCommentTimestamp();
		if ($ts > $compare_ts) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Get the timestamp of the last touch/content created in the group
	 *
	 * @return int
	 */
	public function getTimestamp() {
		
		$timestamps = [
			$this->group->time_created,
			$this->getTouchTimestamp(),
			$this->getContentTimestamp(),
			$this->getCommentTimestamp(),
		];
		
		return max($timestamps);
	}
	
	/**
	 * Get the timestamp when the group was touched as not stale
	 *
	 * @return int
	 */
	protected function getTouchTimestamp() {
		return (int) $this->group->group_tools_stale_touch_ts;
	}
	
	/**
	 * Get the timestamp of the last content in the group
	 *
	 * This is based of searchable entities
	 *
	 * @return int
	 */
	protected function getContentTimestamp() {
		
		$object_subtypes = $this::getObjectSubtypes();
		if (empty($object_subtypes)) {
			return 0;
		}
		
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtypes' => $object_subtypes,
			'limit' => 1,
			'container_guid' => $this->group->getGUID(),
			'order_by' => 'e.time_updated DESC',
		]);
		if (empty($entities)) {
			return 0;
		}
		
		return (int) $entities[0]->time_updated;
	}
	
	/**
	 * Get the timestamp of the last comment/discussion_reply in the group
	 *
	 * @return int
	 */
	protected function getCommentTimestamp() {
		
		$subtypes = ['comment'];
		if (elgg_is_active_plugin('discussions')) {
			$subtypes[] = 'discussion_reply';
		}
		
		$dbprefix = elgg_get_config('dbprefix');
		
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtypes' => $subtypes,
			'limit' => 1,
			'joins' => [
				"JOIN {$dbprefix}entities ce ON e.container_guid = ce.guid",
			],
			'wheres' => [
				"(ce.container_guid = {$this->group->getGUID()})",
			],
			'order_by' => 'e.time_updated DESC',
		]);
		if (empty($entities)) {
			return 0;
		}
		
		return (int) $entities[0]->time_updated;
	}
	
	/**
	 * Get supported subtypes for stale info
	 *
	 * @return string[]
	 */
	public static function getObjectSubtypes() {
		
		$object_subtypes = get_registered_entity_types('object');
		if (empty($object_subtypes)) {
			$object_subtypes = [];
		}
		
		return elgg_trigger_plugin_hook('stale_info_object_subtypes', 'group_tools', [
			'subtypes' => $object_subtypes,
		], $object_subtypes);
	}
}

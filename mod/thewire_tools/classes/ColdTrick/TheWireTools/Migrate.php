<?php

namespace ColdTrick\TheWireTools;

class Migrate extends \ColdTrick\EntityTools\MigrateTheWire {
	

	/**
	 * Registers this class to the entity_tools supported_types hook
	 *
	 * @param string $hook        the name of the hook
	 * @param string $type        the type of the hook
	 * @param array  $returnvalue current return value
	 * @param array  $params      supplied params
	 *
	 * return array
	 */
	static public function registerClass($hook, $type, $returnvalue, $params) {
		$returnvalue['thewire'] = Migrate::class;
		return $returnvalue;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \ColdTrick\EntityTools\Migrate::canChangeContainer()
	 */
	public function canChangeContainer() {
		$page_owner_entity = elgg_get_page_owner_entity();
		if ($page_owner_entity) {
			// viewing a listing
			return (bool) ($page_owner_entity instanceof \ElggGroup);
		}
		
		// no listing so just checking the entity
		if (!($this->getObject()->getContainerEntity() instanceof \ElggGroup)) {
			return false;
		}
		
		// check if object is conversation starter
		return (bool) ($object->guid == $object->wire_thread);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \ColdTrick\EntityTools\Migrate::changeContainer()
	 */
	public function changeContainer($new_container_guid) {
		
		// do all the default stuff
		parent::changeContainer($new_container_guid);
		
		// move all items in thread to the new container
		if ($this->getObject()->guid == $this->getObject()->wire_thread) {
			$this->moveThreadItems($new_container_guid);
		}
	}
		
	/**
	 * Move all the posts in the thread to the new container_guid
	 *
	 * @param int $new_container_guid the new container_guid
	 *
	 * @return void
	 */
	protected function moveThreadItems($new_container_guid) {
		
		// ignore access for this part
		$ia = elgg_set_ignore_access(true);
		
		$batch = new \ElggBatch('elgg_get_entities_from_metadata', [
			'type' => 'object',
			'subtype' => 'thewire',
			'limit' => false,
			'metadata_name_value_pairs' => [
				'name' => 'wire_thread',
				'value' => $this->getObject()->getGUID(),
			],
			'wheres' => [
				'e.guid <> ' . $this->getObject()->getGUID(),
			]
		]);
		
		/* @var $post \ElggObject */
		foreach ($batch as $post) {
			
			$migrate = new Migrate($post);
			$migrate->changeContainer($new_container_guid);
			
			$post->save();
		}
		
		// restore access
		elgg_set_ignore_access($ia);
	}
}
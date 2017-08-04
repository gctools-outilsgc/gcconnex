<?php

namespace ColdTrick\FileTools;

class ElggFile {
	
	/**
	 * Listen to the create event of a file
	 *
	 * @param string      $event  the name of the event
	 * @param string      $type   the type of the event
	 * @param \ElggObject $object supplied entity
	 *
	 * @return void
	 */
	public static function create($event, $type, $object) {
		
		if (!($object instanceof \ElggFile)) {
			return;
		}
		
		self::setFolderGUID($object);
	}
	
	/**
	 * Listen to the update event of a file
	 *
	 * @param string      $event  the name of the event
	 * @param string      $type   the type of the event
	 * @param \ElggObject $object supplied entity
	 *
	 * @return void
	 */
	public static function update($event, $type, $object) {
		
		if (!($object instanceof \ElggFile)) {
			return;
		}
		
		self::setFolderGUID($object);
	}
	
	/**
	 * Set the folder for the file
	 *
	 * @param \ElggFile $entity the file to edit
	 *
	 * @return void
	 */
	protected static function setFolderGUID(\ElggFile $entity) {
		
		$folder_guid = get_input('folder_guid', false);
		if ($folder_guid === false) {
			// folder_input was not present in form/action
			// maybe someone else did something with a file
			return;
		}
		
		$folder_guid = (int) $folder_guid;
		if (!empty($folder_guid)) {
			$folder = get_entity($folder_guid);
			if (!elgg_instanceof($folder, 'object', FILE_TOOLS_SUBTYPE)) {
				unset($folder_guid);
			}
		}
		
		// remove old relationships
		remove_entity_relationships($entity->getGUID(), FILE_TOOLS_RELATIONSHIP, true);
		
		if (!empty($folder_guid)) {
			add_entity_relationship($folder_guid, FILE_TOOLS_RELATIONSHIP, $entity->getGUID());
		}
	}
}

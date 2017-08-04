<?php

namespace ColdTrick\FileTools;

class Folder {
	
	/**
	 * Delete subfolders when removing a folder
	 *
	 * Optionaly also removes files in the folder
	 *
	 * @param string      $event  the name of the event
	 * @param string      $type   the type of the event
	 * @param \ElggObject $object the folder to remove
	 *
	 * @return void
	 */
	public static function delete($event, $type, $object) {
		
		if (!elgg_instanceof($object, 'object', FILE_TOOLS_SUBTYPE)) {
			return;
		}
		
		// remove subfolders
		self::removeSubFolders($object);
		
		if (get_input('files') === 'yes') {
			// removed files in this folder
			self::removeFolderContents($object);
		}
	}
	
	/**
	 * Remove all the child folders of the current folder
	 *
	 * @param \ElggObject $entity the folder to remove the children for
	 *
	 * @return void
	 */
	protected static function removeSubFolders(\ElggObject $entity) {
		
		$batch = new \ElggBatch('elgg_get_entities_from_metadata', [
			'type' => 'object',
			'subtype' => FILE_TOOLS_SUBTYPE,
			'container_guid' => $entity->getContainerGUID(),
			'limit' => false,
			'metadata_name_value_pairs' => [
				'name' => 'parent_guid',
				'value' => $entity->getGUID(),
			],
			'wheres' => [
				"(e.guid <> {$entity->getGUID()})", // prevent deadloops
			],
		]);
		$batch->setIncrementOffset(false);
		foreach ($batch as $folder) {
			$folder->delete();
		}
	}
	
	/**
	 * Remove all the files in this folder
	 *
	 * @param \ElggObject $entity the folder to removed the file from
	 *
	 * @return void
	 */
	protected static function removeFolderContents(\ElggObject $entity) {
		
		$batch = new \ElggBatch('elgg_get_entities_from_relationship', [
			'type' => 'object',
			'subtype' => 'file',
			'container_guid' => $entity->getContainerGUID(),
			'limit' => false,
			'relationship' => FILE_TOOLS_RELATIONSHIP,
			'relationship_guid' => $entity->getGUID(),
		]);
		$batch->setIncrementOffset(false);
		foreach ($batch as $file) {
			$file->delete();
		}
	}
	
	/**
	 * Can a user edit metadata of a folder
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @retrun void|true
	 */
	public static function canEditMetadata($hook, $type, $return_value, $params) {
		
		if ($return_value) {
			// already have access
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!($user instanceof \ElggUser) || !elgg_instanceof($entity, 'object', FILE_TOOLS_SUBTYPE)) {
			return;
		}
		
		$container_entity = $entity->getContainerEntity();
		if (!($container_entity instanceof \ElggGroup)) {
			return;
		}
		
		if ($container_entity->isMember($user) && ($container_entity->file_tools_structure_management_enable !== 'no')) {
			// is group member
			return true;
		}
	}
	
	/**
	 * Get the icon URL for a folder
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @retrun void|string
	 */
	public static function getIconURL($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		$size = elgg_extract('size', $params, 'small');
		if (!elgg_instanceof($entity, 'object', FILE_TOOLS_SUBTYPE)) {
			return;
		}
		
		switch ($size) {
			case 'topbar':
			case 'tiny':
			case 'small':
				return elgg_normalize_url("mod/file_tools/_graphics/folder/{$size}.png");
				break;
			default:
				return elgg_normalize_url('mod/file_tools/_graphics/folder/medium.png');
				break;
		}
	}
	
	/**
	 * Get the URL for a folder
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $retrun_value current return value
	 * @param array  $params       supplied params
	 *
	 * @retrun void|string
	 */
	public static function getURL($hook, $type, $retrun_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!elgg_instanceof($entity, 'object', FILE_TOOLS_SUBTYPE)) {
			return;
		}
		
		$container = $entity->getContainerEntity();
	
		if ($container instanceof \ElggGroup) {
			return "file/group/{$container->getGUID()}/all#{$entity->getGUID()}";
		} else {
			return "file/owner/{$container->username}#{$entity->getGUID()}";
		}
	}
	
	/**
	 * Can create a folder in a group
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $retrun_value current return value
	 * @param array  $params       supplied params
	 *
	 * @retrun void|bool
	 */
	public static function canWriteToContainer($hook, $type, $return_value, $params) {
		
		$subtype = elgg_extract('subtype', $params);
		if ($subtype !== FILE_TOOLS_SUBTYPE) {
			return;
		}
		
		$container = elgg_extract('container', $params);
		$user = elgg_extract('user', $params);
		if (!($container instanceof \ElggGroup) || !($user instanceof \ElggUser)) {
			return;
		}
		
		if ($container->canEdit($user->getGUID())) {
			// admins, group owners and group admins can create folder all the time
			return true;
		}
		
		if (!$container->isMember($user)) {
			// user is not a group member
			return false;
		}
		
		if ($container->file_tools_structure_management_enable === 'no') {
			// file management is disabled
			return false;
		}
	}
}

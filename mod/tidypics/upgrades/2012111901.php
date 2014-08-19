<?php
// Only admin users can run this upgrade
if ( !elgg_is_admin_logged_in() ) {
	return;
}

$file_version = elgg_get_upgrade_file_version(basename(__FILE__));
$upgrade_version = elgg_get_plugin_setting('upgrade_version', 'tidypics');

if ( $upgrade_version and $file_version <= $upgrade_version) {
	return;
}

$db_prefix = elgg_get_config('dbprefix');
$ignore_access = elgg_set_ignore_access(TRUE);

// Count tidypics_batch entities that need to correct the access_id
$options = array(
	'type' => 'object',
	'subtype' => 'tidypics_batch',
	'limit' => 0,
	'count' => TRUE,
	'joins' => array("JOIN {$db_prefix}entities e2 ON e2.guid = e.container_guid"),
	'wheres' => array("e.access_id <> e2.access_id"),
);
$tidypics_batch = elgg_get_entities($options);

// If no entities found set upgrade as runned
if ( !$tidypics_batch ) {
	return elgg_set_plugin_setting('upgrade_version', $file_version, 'tidypics');
}

// Correct the access_id of the tidypics_batch entities
if ( $tidypics_batch ) {
	$options['count'] = FALSE;
	$batch = new ElggBatch('elgg_get_entities', $options, 'tidypics_2012111901');
	// Correct the acces_id from river itens
	$tidypics_batch_river = elgg_get_river(array('object_guids' => $batch->callbackResult, 'action_types' => 'create', 'types' => 'object', 'subtypes' => 'tidypics_batch', 'limit' => 0));
	tidypics_adjust_river_access_id($tidypics_batch_river);
	error_log("Tidypics batches upgrade (2012111901) succeeded");
}
elgg_set_ignore_access($ignore_access);

// Set upgrade as runned
return elgg_set_plugin_setting('upgrade_version', $file_version, 'tidypics');

/**
 * Change the tidypics_batch's access_id to container's access_id (album object)
 *
 * @param ElggObject $entity
 * @param string 	 $getter
 * @param array 	 $options
 */
function tidypics_2012111901($entity, $getter, $options) {
	$album = $entity->getContainerEntity();
	if ( $guid = tidypics_adjust_batch_access_id($entity, $album) ) {
		return $guid;
	}
}

/**
 * Change the tidypics_batch's access_id
 *
 * @param ElggObject $entity
 * @param ElggObject $album
 * @return void
 */
function tidypics_adjust_batch_access_id(ElggObject $entity = NULL, ElggObject $album = NULL) {
	if ( !elgg_instanceof($entity, 'object', 'tidypics_batch') or !elgg_instanceof($album, 'object', 'album') ) {
		return FALSE;
	}

	if ( $entity->access_id != $album->access_id ) {
		$entity->access_id = $album->access_id;
		return $entity->save();
	}
}

/**
 * Change the river iten's acces_id to album acces_id
 *
 * @param Array $river_itens
 * @return void
 */
function tidypics_adjust_river_access_id(array $river_itens = NULL) {
	if ( !$river_itens or !count($river_itens) ) {
		return;
	}
	foreach ($river_itens as $item) {
		$object = $item->getObjectEntity();
		$access_id = $object->access_id;
		if ( $item->access_id != $access_id ) {
			update_river_access_by_object($object->guid, $access_id);
		}
	}
}

<?php
/**
 * A batch is complete so check if this is first upload to album
 *
 */

set_input('tidypics_action_name', 'tidypics_photo_upload');

$batch = get_input('batch');
$album_guid = (int) get_input('album_guid');
$img_river_view = elgg_get_plugin_setting('img_river_view', 'tidypics');

$album = get_entity($album_guid);
if (!elgg_instanceof($album, 'object', 'album')) {
	exit;
}

$params = array(
	'type' => 'object',
	'subtype' => 'image',
	'metadata_names' => 'batch',
	'metadata_values' => $batch,
	'limit' => 0
);

$images = elgg_get_entities_from_metadata($params);
if ($images) {
	// Create a new batch object to contain these photos
	$batch = new TidypicsBatch();
	$batch->access_id = $album->access_id;
	$batch->container_guid = $album->guid;

	if ($batch->save()) {
		foreach ($images as $image) {
			add_entity_relationship($image->guid, "belongs_to_batch", $batch->getGUID());
		}
	}
} else {
	// @todo some sort of message to edit them manually.
	exit;
}

// "added images to album" river
if ($img_river_view == "batch" && $album->new_album == false) {
	elgg_create_river_item(array(
		'view' => 'river/object/tidypics_batch/create',
		'action_type' => 'create',
		'subject_guid' => $batch->getOwnerGUID(),
		'object_guid' => $batch->getGUID(),
		'target_guid' => $album->getGUID(),
	));
}  else if ($img_river_view == "1" && $album->new_album == false) {
	elgg_create_river_item(array(
		'view' => 'river/object/tidypics_batch/create_single_image',
		'action_type' => 'create',
		'subject_guid' => $batch->getOwnerGUID(),
		'object_guid' => $batch->getGUID(),
		'target_guid' => $album->getGUID(),
	));
}

// "created album" river
if ($album->new_album) {
	$album->new_album = false;
	$album->first_upload = true;

	$album_river_view = elgg_get_plugin_setting('album_river_view', 'tidypics');
	if ($album_river_view != "none") {
		elgg_create_river_item(array(
			'view' => 'river/object/album/create',
			'action_type' => 'create',
			'subject_guid' => $album->getOwnerGUID(),
			'object_guid' => $album->getGUID(),
			'target_guid' => $album->getGUID(),
		));
	}

	// "created album" notifications
	// we throw the notification manually here so users are not told about the new album until
	// there are at least a few photos in it
	if ($album->shouldNotify()) {
		elgg_trigger_event('album_first', 'album', $album);
		$album->last_notified = time();
	}
} else {
	// "added image to album" notifications
	if ($album->first_upload) {
		$album->first_upload = false;
	}

	if ($album->shouldNotify()) {
		elgg_trigger_event('album_more', 'album', $album);
		$album->last_notified = time();
	}
}

echo json_encode(array('batch_guid' => $batch->getGUID()));
exit;
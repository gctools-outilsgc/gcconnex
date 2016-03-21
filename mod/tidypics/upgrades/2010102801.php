<?php
/**
 * Convert river entries for tags to be tagger-tagee-annotation from
 * image-tagee
 */

// prevent timeout when script is running
set_time_limit(0);

// Ignore access to make sure all items get updated
$ia = elgg_set_ignore_access(true);

elgg_register_plugin_hook_handler('permissions_check', 'all', 'elgg_override_permissions');
elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'elgg_override_permissions');

// Make sure that entries for disabled entities also get upgraded
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$db_prefix = elgg_get_config('dbprefix');

$batch = new ElggBatch('elgg_get_river', array(
	'view' => 'river/object/image/tag',
	'limit' => false
));

foreach ($batch as $river_entry) {
	$batch_annotations = new ElggBatch('elgg_get_annotations', array(
		'guid' => $river_entry->subject_guid,
		'annotation_name' => 'phototag',
		'limit' => false
	));
	foreach ($batch_annotations as $annotation) {
		$tag = unserialize($annotation->value);
		if ($tag->type === 'user') {
			if ($tag->value == $river_entry->object_guid) {
				$query = "
					UPDATE {$db_prefix}river
					SET subject_guid = {$annotation->owner_guid}, annotation_id = {$annotation->id}
					WHERE id = {$river_entry->id}
				";
				update_data($query);
			}
		}
	}
}

elgg_set_ignore_access($ia);
access_show_hidden_entities($access_status);

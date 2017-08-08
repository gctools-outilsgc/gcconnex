<?php

/**
 * Update river entries for image uploads and tags
 *
 * The target_guid of existing river entries is set to the corresponding album's guid
 * for the river entries to show up in the activity lists of groups if the
 * album the images belong to or have been tagged is a group album
 *
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
	'type' => 'object',
	'subtype' => 'album',
	'action_type' => 'create',
	'limit' => false
));
foreach ($batch as $river_entry) {
	$query = "
		UPDATE {$db_prefix}river
		SET target_guid = {$river_entry->object_guid}
		WHERE id = {$river_entry->id}
	";
	update_data($query);
}

$batch = new ElggBatch('elgg_get_river', array(
	'type' => 'object',
	'subtype' => 'image',
	'action_type' => 'create',
	'limit' => false
));
foreach ($batch as $river_entry) {
	$image = get_entity($river_entry->object_guid);
	$query = "
		UPDATE {$db_prefix}river
		SET target_guid = {$image->container_guid}
		WHERE id = {$river_entry->id}
	";
	update_data($query);
}

$batch = new ElggBatch('elgg_get_river', array(
	'type' => 'object',
	'subtype' => 'tidypics_batch',
	'action_type' => 'create',
	'limit' => false
));
foreach ($batch as $river_entry) {
	$tidypics_batch = get_entity($river_entry->object_guid);
	$query = "
		UPDATE {$db_prefix}river
		SET target_guid = {$tidypics_batch->container_guid}
		WHERE id = {$river_entry->id}
	";
	update_data($query);
}

$batch = new ElggBatch('elgg_get_river', array(
	'type' => 'object',
	'subtype' => 'image',
	'action_type' => 'tag',
	'limit' => false
));
foreach ($batch as $river_entry) {
	$tag_annotation = elgg_get_annotation_from_id($river_entry->annotation_id);
	$image = get_entity($tag_annotation->entity_guid);
	$query = "
		UPDATE {$db_prefix}river
		SET target_guid = {$image->container_guid}
		WHERE id = {$river_entry->id}
	";
	update_data($query);
}

$batch = new ElggBatch('elgg_get_river', array(
	'type' => 'object',
	'subtype' => 'image',
	'action_type' => 'wordtag',
	'limit' => false
));
foreach ($batch as $river_entry) {
	$image = get_entity($river_entry->object_guid);
	$query = "
		UPDATE {$db_prefix}river
		SET target_guid = {$image->container_guid}
		WHERE id = {$river_entry->id}
	";
	update_data($query);
}


elgg_set_ignore_access($ia);
access_show_hidden_entities($access_status);

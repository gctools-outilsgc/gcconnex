<?php

/*
 * Converting personal_event annotations (old way of managing the addition of an event to a user's personal calendar)
 * into personal_event relationships (the new way)
 */

set_time_limit(0);

// Ignore access to make sure all items get updated
$ia = elgg_set_ignore_access(true);

elgg_register_plugin_hook_handler('permissions_check', 'all', 'elgg_override_permissions');
elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'elgg_override_permissions');

// Make sure that entries for disabled entities also get upgraded
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$db_prefix = elgg_get_config('dbprefix');

$batch = new ElggBatch('elgg_get_annotations', array(
	'type' => 'object',
	'subtype' => 'event_calendar',
	'annotation_name' => 'personal_event',
	'limit' => false
));

// now collect the ids of the personal_event annotations for later deletion and create a corresponding relationship
$personal_event_entry_id = array();
foreach ($batch as $personal_event_annotation) {
	// collect annotation id for deletion only if addition of relationship was a success
	if (add_entity_relationship($personal_event_annotation->annotation_value, 'personal_event', $personal_event_annotation->guid)) {
		$personal_event_entry_id[] = $personal_event_annotation->id;
	}
}

// and finally delete the rows of the personal_event annotations in the annotations table
if ($personal_event_entry_id) {
	$personal_event_entry_id = implode(', ', $personal_event_entry_id);
	$del_personal_event_annotations_query = "DELETE FROM {$db_prefix}annotations
							WHERE id IN ($personal_event_entry_id)";
	delete_data($del_personal_event_annotations_query);
	unset($personal_event_entry_id);
}

elgg_set_ignore_access($ia);
access_show_hidden_entities($access_status);

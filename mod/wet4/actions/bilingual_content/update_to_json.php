<?php
/**
 * Upgrade bilingual content storage to use ajax strings instead of metadata
 * 
 * Run for 2 seconds per request as set by $batch_run_time_in_secs. This includes
 * the engine loading time.
 */

// from engine/start.php

global $START_MICROTIME;
$batch_run_time_in_secs = 2;

// Offset is the total amount of errors so far. We skip these
// comments to prevent them from possibly repeating the same error.
$offset = get_input('offset', 0);
$limit = 10;

$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

// don't want any event or plugin hook handlers from plugins to run
$original_events = _elgg_services()->events;
$original_hooks = _elgg_services()->hooks;
_elgg_services()->events = new Elgg\EventsService();
_elgg_services()->hooks = new Elgg\PluginHooksService();
elgg_register_plugin_hook_handler('permissions_check', 'all', 'elgg_override_permissions');
elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'elgg_override_permissions');

$db_prefix = elgg_get_config('dbprefix');

$title2_id = elgg_get_metastring_id('title2', true);	// get the metastring id, create the metastring if it does not exist
$title3_id = elgg_get_metastring_id('title3', true);

$name2_id = elgg_get_metastring_id('name2', true);	// get the metastring id, create the metastring if it does not exist
$name3_id = elgg_get_metastring_id('name3', true);

$question2_id = elgg_get_metastring_id('question2', true);	// get the metastring id, create the metastring if it does not exist
$question3_id = elgg_get_metastring_id('question3', true);

$description2_id = elgg_get_metastring_id('description2', true);	// get the metastring id, create the metastring if it does not exist
$description3_id = elgg_get_metastring_id('description3', true);

$briefdescription2_id = elgg_get_metastring_id('briefdescription2', true);	// get the metastring id, create the metastring if it does not exist
$briefdescription3_id = elgg_get_metastring_id('briefdescription3', true);

$excerpt2_id = elgg_get_metastring_id('excerpt2', true);	// get the metastring id, create the metastring if it does not exist
$excerpt3_id = elgg_get_metastring_id('excerpt3', true);

$poll_choice2_id = elgg_get_metastring_id('text2', true);	// get the metastring id, create the metastring if it does not exist
$poll_choice3_id = elgg_get_metastring_id('text3', true);

$update_id = elgg_get_metastring_id('enfr_update_complete', true);

$success_count = 0;
$error_count = 0;

do {
	$object_guids = get_data("SELECT distinct e.guid as guid from {$db_prefix}entities e LEFT JOIN {$db_prefix}metadata md ON e.guid = md.entity_guid LEFT JOIN (SELECT * FROM {$db_prefix}metadata WHERE name_id = {$update_id}) mdu ON e.guid = mdu.entity_guid
		WHERE md.name_id IN ({$title2_id}, {$title3_id}, {$name2_id}, {$name3_id}, {$question2_id}, {$question3_id}, {$description2_id}, {$description3_id}, {$briefdescription2_id}, {$briefdescription3_id}, {$excerpt2_id}, {$excerpt3_id}, {$poll_choice2_id}, {$poll_choice3_id}) AND mdu.value_id IS NULL
		ORDER BY e.guid DESC
		LIMIT {$offset}, {$limit}");

	if (!$object_guids) {
		// no users left to process
		break;
	}

	// migrate all old storage style of bilingual content to json strings
	foreach ( $object_guids as $object_guid ) {
		$object = get_entity($object_guid->guid);

		// check, migrate title
		if ( isset($object->title2) ){
			$new_title = gc_implode_translation( $object->title, $object->title2 );
			$object->title = $new_title;
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->title3 ) ){
			$object->title = gc_implode_translation( old_gc_explode_translation($object->title3, 'en'), old_gc_explode_translation($object->title3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		// check, migrate group names
		if ( isset($object->name2) ){
			$new_name = gc_implode_translation( $object->name, $object->name2 );
			$object->name = $new_name;
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->name3 ) ){
			$object->name = gc_implode_translation( old_gc_explode_translation($object->name3, 'en'), old_gc_explode_translation($object->name3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		// check, migrate poll questions, which are also titles...
		if ( isset($object->question2) ){
			$new_name = gc_implode_translation( $object->question, $object->question2 );
			$object->question = $new_name;
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->question3 ) ){
			$object->question = gc_implode_translation( old_gc_explode_translation($object->question3, 'en'), old_gc_explode_translation($object->question3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		// check, migrate description
		if ( isset($object->description2) ){
			$object->description = gc_implode_translation( $object->description, $object->description2 );
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->description3 ) ){
			$object->description = gc_implode_translation( old_gc_explode_translation($object->description3, 'en'), old_gc_explode_translation($object->description3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		// check, migrate briefdescription
		if ( isset($object->briefdescription2) ){
			$object->briefdescription = gc_implode_translation( $object->briefdescription, $object->briefdescription2 );
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->briefdescription3 ) ){
			$object->briefdescription = gc_implode_translation( old_gc_explode_translation($object->briefdescription3, 'en'), old_gc_explode_translation($object->briefdescription3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		// check, migrate excerpt
		if ( isset($object->excerpt2) ){
			$object->excerpt = gc_implode_translation( $object->excerpt, $object->excerpt2 );
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->excerpt3 ) ){
			$object->excerpt = gc_implode_translation( old_gc_explode_translation($object->excerpt3, 'en'), old_gc_explode_translation($object->excerpt3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		// check, migrate poll_choice
		if ( isset($object->text2) ){
			$object->text = gc_implode_translation( $object->text, $object->text2 );
			$object->enfr_update_complete = 1;
			$object->save();
		}
		else if ( isset($object->text3) ){
			$object->text = gc_implode_translation( old_gc_explode_translation($object->text3, 'en'), old_gc_explode_translation($object->text3, 'fr') );
			$object->enfr_update_complete = 1;
			$object->save();
		}

		$success_count++;
	}
} while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs);
access_show_hidden_entities($access_status);

// replace events and hooks
_elgg_services()->events = $original_events;
_elgg_services()->hooks = $original_hooks;



if (!$object_guids) {
	// no users left to process
	echo json_encode(array(
		'numSuccess' => $success_count,
		'numErrors' => $error_count,
		'processComplete' => true,
	));
}
else{
	// Give some feedback for the UI
	echo json_encode(array(
		'numSuccess' => $success_count,
		'numErrors' => $error_count,
		'processComplete' => false,
	));
}

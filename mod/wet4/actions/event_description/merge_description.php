<?php
/**
 * Upgrade event calendar description to contain all extra info
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

$room = elgg_get_metastring_id('room', true);
$check_web_conf = elgg_get_metastring_id('teleconference_radio', true);
$url_web_conf = elgg_get_metastring_id('teleconference', true);
$add_web_conf = elgg_get_metastring_id('calendar_additional', true);// en/fr	
$fees = elgg_get_metastring_id('fees', true);
$language = elgg_get_metastring_id('language', true);
$check_contact = elgg_get_metastring_id('contact_checkbox', true);
$name_contact = elgg_get_metastring_id('contact', true);
$email_contact = elgg_get_metastring_id('contact_email', true);
$phone_contact = elgg_get_metastring_id('contact_phone', true);


$update_id = elgg_get_metastring_id('event_update_complete', true);

$success_count = 0;
$error_count = 0;

do {
	$object_guids = get_data("SELECT distinct e.guid as guid from {$db_prefix}entities e LEFT JOIN {$db_prefix}metadata md ON e.guid = md.entity_guid LEFT JOIN (SELECT * FROM {$db_prefix}metadata WHERE name_id = {$update_id}) mdu ON e.guid = mdu.entity_guid
		WHERE md.name_id IN ({$room}, {$check_web_conf}, {$url_web_conf}, {$add_web_conf}, {$fees}, {$language}, {$check_contact}, {$name_contact}, {$email_contact}, {$phone_contact}) AND mdu.value_id IS NULL
		LIMIT {$offset}, {$limit}");

	if (!$object_guids) {
		// no users left to process
		break;
	}
	// migrate all old storage style of bilingual content to json strings
	foreach ( $object_guids as $object_guid ) {
		$object = get_entity($object_guid->guid);
		// check, migrate web conference
		if(isset($object->room)){
			$new_venue = $object->venue.', '.$object->room;
			$object->venue = $new_venue; 
			$object->event_update_complete = 1;
		}
		if ( isset($object->teleconference_radio) ){
			if(isset($object->teleconference)){
				$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'Web conference url: '.$object->teleconference.'<br>', gc_explode_translation($object->description, 'fr').'Web conférence URL: '.$object->teleconference.'<br>' );
				$object->description = $new_description; 
				$object->event_update_complete = 1;
			}
			if(isset($object->calendar_additional) ){
				$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'Additional information: '. gc_explode_translation($object->calendar_additional,'en').'<br>', gc_explode_translation($object->description, 'fr').'Information supplémentaire: '.gc_explode_translation($object->calendar_additional,'fr').'<br>' );
				$object->description = $new_description; 
				$object->event_update_complete = 1;
			}
		}
		if(isset($object->fees) ){
			$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'Fees: '.$object->fees.'<br>', gc_explode_translation($object->description, 'fr').'Frais: '.$object->fees.'<br>' );
			$object->description = $new_description; 
			$object->event_update_complete = 1;
		}
		if(isset($object->language) ){
			$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'Language: '.$object->language.'<br>', gc_explode_translation($object->description, 'fr').'Langue: '.$object->language.'<br>' );
			$object->description = $new_description; 
			$object->event_update_complete = 1;
		}
		if ( isset($object->contact_checkbox) ){
			if(isset($object->contact)){
				$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'Contact: '.$object->contact.'<br>', gc_explode_translation($object->description, 'fr').'Personne ressource: '.$object->contact.'<br>' );
				$object->description = $new_description; 
				$object->event_update_complete = 1;
			}
			if(isset($object->contact_email) ){
				$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'E-mail address: '.$object->contact_email.'<br>', gc_explode_translation($object->description, 'fr').'Adresse courriel: '.$object->contact_email.'<br>' );
				$object->description = $new_description; 
				$object->event_update_complete = 1;
			}
			if(isset($object->contact_phone) ){
				$new_description = gc_implode_translation( gc_explode_translation($object->description, 'en').'Phone number: '.$object->contact_phone.'<br>', gc_explode_translation($object->description, 'fr').'Numéro de téléphone: '.$object->contact_phone.'<br>' );
				$object->description = $new_description; 
				$object->event_update_complete = 1;
			}
		}
		$object->save();
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

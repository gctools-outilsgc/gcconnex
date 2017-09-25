<?php
/*
 * Exposes API endpoints for Event entities
 */

elgg_ws_expose_function(
	"get.event",
	"get_event",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves an event based on user id and event id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.events",
	"get_events",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"from" => array('type' => 'string', 'required' => false, 'default' => ""),
		"to" => array('type' => 'string', 'required' => false, 'default' => ""),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves an event based on user id and event id',
	'POST',
	true,
	false
);

function get_event( $user, $guid, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	$entity = get_entity( $guid );
	if( !$entity ) return "Event was not found. Please try a different GUID";
	if( !$entity->type !== "event_calendar" ) return "Invalid event. Please try a different GUID";

	if( !elgg_is_logged_in() )
		login($user_entity);
	
	$events = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'guid' => $guid
	));
	$event = json_decode($events)[0];

	$likes = elgg_get_annotations(array(
		'guid' => $event->guid,
		'annotation_name' => 'likes'
	));
	$event->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $event->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$event->liked = count($liked) > 0;

	// $event->comments = get_entity_comments($event->guid);
	
	$event->title = gc_explode_translation($event->title, $lang);
	$event->description = gc_explode_translation($event->description, $lang);

	$event->userDetails = get_user_block($event->owner_guid, $lang);

	$eventObj = get_entity($event->guid);
	$event->startDate = date("Y-m-d H:i:s", $eventObj->start_date);
	$event->endDate = date("Y-m-d H:i:s", $eventObj->end_date);

	return $event;
}

function get_events( $user, $from, $to, $limit, $offset, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	if( !elgg_is_logged_in() )
		login($user_entity);

	$params = array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'limit' => $limit,
		'offset' => $offset,
		'order_by_metadata' => array(array('name' => 'start_date', 'direction' => 'ASC', 'as' => 'integer'))
	);

	if( $from ){
		$params['metadata_name_value_pairs'][] = array(
			'name' => 'start_date',
			'value' => strtotime($from),
			'operand' => '>='
		);
	}
	if( $to ){
		$params['metadata_name_value_pairs'][] = array(
			'name' => 'end_date',
			'value' => strtotime($to),
			'operand' => '<='
		);
	}

	$all_events = elgg_list_entities_from_metadata($params);
	$events = json_decode($all_events);

	foreach($events as $event){
		$likes = elgg_get_annotations(array(
			'guid' => $event->guid,
			'annotation_name' => 'likes'
		));
		$event->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $event->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$event->liked = count($liked) > 0;

		// $event->comments = get_entity_comments($event->guid);
		
		$event->title = gc_explode_translation($event->title, $lang);
		$event->description = gc_explode_translation($event->description, $lang);

		$event->userDetails = get_user_block($event->owner_guid, $lang);

		$eventObj = get_entity($event->guid);
		$event->startDate = date("Y-m-d H:i:s", $eventObj->start_date);
		$event->endDate = date("Y-m-d H:i:s", $eventObj->end_date);
	}

	return $events;
}

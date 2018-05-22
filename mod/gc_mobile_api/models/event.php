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
	"event.add.calendar",
	"event_add_calendar",
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
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves an event based on user id and event id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.eventsbyowner",
	"get_events_by_owner",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"from" => array('type' => 'string', 'required' => false, 'default' => ""),
		"to" => array('type' => 'string', 'required' => false, 'default' => ""),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves an event based on user id and event id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.eventsbycolleagues",
	"get_events_by_colleagues",
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

elgg_ws_expose_function(
	"get.seecalendar",
	"get_see_calendar",
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
function get_event($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Event was not found. Please try a different GUID";
	}
	if (!$entity->type !== "event_calendar") {
		//return "Invalid event. Please try a different GUID";
	}

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

	$event->title = gc_explode_translation($event->title, $lang);
	$event->description = gc_explode_translation($event->description, $lang);

	$event->userDetails = get_user_block($event->owner_guid, $lang);
	$eventObj = get_entity($event->guid);
	$event->startDate = date("Y-m-d H:i:s", $eventObj->start_date);
	$event->endDate = date("Y-m-d H:i:s", $eventObj->end_date);
	$event->organizer = $eventObj->contact;
	$event->phone = $eventObj->contact_phone;
	$event->email = $eventObj->contact_email;
	$event->fee = $eventObj->fees;
	$event->eventLang = $eventObj->language;
	$event->location = $eventObj->venue;
	if ($eventObj->group_guid){
		$group = get_entity($eventObj->group_guid);
		$event->group = gc_explode_translation($group->name, $lang);
		$event->groupGUID = $eventObj->group_guid;
	}


	return $event;
}

function get_events($user, $from, $to, $limit, $offset, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$params = array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'limit' => $limit,
		'offset' => $offset,
		'order_by_metadata' => array(array('name' => 'start_date', 'direction' => 'DESC', 'as' => 'integer'))
	);

	if ($from) {
		$params['metadata_name_value_pairs'][] = array(
			'name' => 'start_date',
			'value' => strtotime($from),
			'operand' => '>='
		);
	}
	if ($to) {
		$params['metadata_name_value_pairs'][] = array(
			'name' => 'end_date',
			'value' => strtotime($to),
			'operand' => '<='
		);
	}

	$all_events = elgg_list_entities_from_metadata($params);
	$events = json_decode($all_events);
	$now = time();
	$one_day = 60*60*24;

	foreach ($events as $event) {

		$eventObj = get_entity($event->guid);
		if (($eventObj->start_date > $now-$one_day) || ($eventObj->end_date && ($eventObj->end_date > $now-$one_day))) {
			
			$options = array(
				'type' => 'user',
				'relationship' => 'personal_event',
				'relationship_guid' => $event->guid,
				'inverse_relationship' => true,
				'limit' => false,
				'count' => true,
			);

			$count = elgg_get_entities_from_relationship($options);
			if ($count == 1) {
				$event->in_calendar = elgg_echo('event_calendar:personal_event_calendars_link_one');
			} else {
				$event->in_calendar = elgg_echo('event_calendar:personal_event_calendars_link', array($count));
			}

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

			$event->title = gc_explode_translation($event->title, $lang);
			$event->description = gc_explode_translation($event->description, $lang);
			$event->userDetails = get_user_block($event->owner_guid, $lang);
			$event->startDate = date("Y-m-d H:i:s", $eventObj->start_date);
			$event->endDate = date("Y-m-d H:i:s", $eventObj->end_date);
	
			$event->location = $eventObj->venue;

			if ($eventObj->group_guid){
				$group = get_entity($eventObj->group_guid);
				$event->group = gc_explode_translation($group->name, $lang);
				$event->groupGUID = $eventObj->group_guid;
			}
		}
	}
	return $events;
}

function get_events_by_owner($user, $from, $to, $limit, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$params = array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'limit' => $limit,
		'offset' => $offset,
		'order_by_metadata' => array(array('name' => 'start_date', 'direction' => 'DESC', 'as' => 'integer')),
		'filter' => 'mine',
		'relationship' => 'personal_event',
		'relationship_guid' => $user_entity->entity,
	);

	if ($from) {
		$params['metadata_name_value_pairs'][] = array(
			'name' => 'start_date',
			'value' => strtotime($from),
			'operand' => '>='
		);
	}
	if ($to) {
		$params['metadata_name_value_pairs'][] = array(
			'name' => 'end_date',
			'value' => strtotime($to),
			'operand' => '<='
		);
	}

	$all_events = elgg_list_entities_from_relationship($params);

	$events = json_decode($all_events);
	$now = time();
	$one_day = 60*60*24;
	foreach ($events as $event) {

		$eventObj = get_entity($event->guid);
		if (($eventObj->start_date > $now-$one_day) || ($eventObj->end_date && ($eventObj->end_date > $now-$one_day))) {
		
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

			$event->title = gc_explode_translation($event->title, $lang);
			$event->description = gc_explode_translation($event->description, $lang);

			$event->userDetails = get_user_block($event->owner_guid, $lang);

			$eventObj = get_entity($event->guid);
			$event->startDate = date("Y-m-d H:i:s", $eventObj->start_date);
			$event->endDate = date("Y-m-d H:i:s", $eventObj->end_date);
			$event->location = $eventObj->venue;

			if ($eventObj->group_guid){
				$group = get_entity($eventObj->group_guid);
				$event->group = gc_explode_translation($group->name, $lang);
				$event->groupGUID = $eventObj->group_guid;
			}		
		}
	}
	return $events;
}

function get_events_by_colleagues($user, $from, $to, $limit, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}
	$friends = $user_entity->getFriends(array('limit' => false));
	
	if ($friends) {
		$friend_guids = array();

		foreach($friends as $friend) {
			$friend_guids[] = $friend->getGUID();
		}
		$friend_list = implode(",", $friend_guids);
		$db_prefix = elgg_get_config('dbprefix');
		$params = array(
			'type' => 'object',
			'subtype' => 'event_calendar',
			'limit' => $limit,
			'order_by_metadata' => array(array('name' => 'start_date', 'direction' => 'DESC', 'as' => 'integer')),
			'filter' => 'friends',
			'relationship' => 'personal_event',
			'relationship_guid' => $user_entity->entity,
			'joins' => array("JOIN {$db_prefix}entity_relationships r ON (r.guid_two = e.guid)"),
			'wheres' => array("r.relationship = 'personal_event'","r.guid_one IN ($friend_list)"),
		);

		if ($from) {
			$params['metadata_name_value_pairs'][] = array(
				'name' => 'start_date',
				'value' => strtotime($from),
				'operand' => '>='
			);
		}
		if ($to) {
			$params['metadata_name_value_pairs'][] = array(
				'name' => 'end_date',
				'value' => strtotime($to),
				'operand' => '<='
			);
		}

		$all_events = elgg_list_entities_from_metadata($params);
		$events = json_decode($all_events);
		$now = time();
		$one_day = 60*60*24;
		foreach ($events as $event) {

			$eventObj = get_entity($event->guid);
			if (($eventObj->start_date > $now-$one_day) || ($eventObj->end_date && ($eventObj->end_date > $now-$one_day))) {
			
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

				$event->title = gc_explode_translation($event->title, $lang);
				$event->description = gc_explode_translation($event->description, $lang);

				$event->userDetails = get_user_block($event->owner_guid, $lang);

				$eventObj = get_entity($event->guid);
				$event->startDate = date("Y-m-d H:i:s", $eventObj->start_date);
				$event->endDate = date("Y-m-d H:i:s", $eventObj->end_date);
				$event->location = $eventObj->venue;

				if ($eventObj->group_guid){
					$group = get_entity($eventObj->group_guid);
					$event->group = gc_explode_translation($group->name, $lang);
					$event->groupGUID = $eventObj->group_guid;
				}
			}
		}
	}
	return $events;
}

function event_add_calendar($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	elgg_load_library('elgg:event_calendar');

	$event_guid = $guid;
	$event = get_entity($event_guid);
	if (elgg_instanceof($event, 'object', 'event_calendar')) {

		if (!event_calendar_has_personal_event($event_guid,$user_entity->guid)) {
			if (event_calendar_add_personal_event($event_guid,$user_entity->guid)) {
				return(elgg_echo('event_calendar:add_to_my_calendar_response'));
			} else {
				return(elgg_echo('event_calendar:add_to_my_calendar_error'));
			}
		}else{
			return elgg_echo('event_calendar:already_in');

		}
	}
}

function get_see_calendar($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	elgg_load_library('elgg:event_calendar');

	$limit = 12;
	$offset = get_input('offset', 0);
	$users = event_calendar_get_users_for_event($guid, $limit, $offset, false);

	$data = array();
	foreach ($users as $user) {
		$user_obj = get_user($user->guid);
		$user_data = get_user_block($user->guid, $lang);
		$data[] = $user_data;
	}

	return $data;

}
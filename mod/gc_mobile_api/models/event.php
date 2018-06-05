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
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
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

elgg_ws_expose_function(
	"save.event",
	"save_event",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"title" => array('type' => 'string', 'required' => true),
		"excerpt" => array('type' =>'string', 'required' => false, 'default' => ''),
		"body" => array('type' =>'string', 'required' => true),
		"startdate" => array('type' =>'string', 'required' => true),
		"starttime" => array('type' =>'string', 'required' => true),
		"enddate" => array('type' =>'string', 'required' => true),
		"endtime" => array('type' =>'string', 'required' => true),
		"container_guid" => array('type' =>'string', 'required' => false, 'default' => ''),
		"blog_guid" => array('type' =>'string', 'required' => false, 'default' => ''),
		"comments" => array('type' =>'int', 'required' => false, 'default' => 1),
		"access" => array('type' =>'int', 'required' => false, 'default' => 1),
		"status" => array('type' =>'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Posts/Saves an event post',
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


function save_event($user, $title, $excerpt, $body, $startdate, $starttime, $enddate, $endtime, $container_guid, $event_guid, $comments, $access, $status, $lang)
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


	$startdate = new DateTime($startdate);
	$enddate = new DateTime($enddate);	

	 $event_calendar_times = elgg_get_plugin_setting('times', 'event_calendar');
	 $event_calendar_region_display = elgg_get_plugin_setting('region_display', 'event_calendar');
	 $event_calendar_type_display = elgg_get_plugin_setting('type_display', 'event_calendar');
	 $event_calendar_spots_display = elgg_get_plugin_setting('spots_display', 'event_calendar');
	 $event_calendar_hide_end = elgg_get_plugin_setting('hide_end', 'event_calendar');
	 $event_calendar_more_required = elgg_get_plugin_setting('more_required', 'event_calendar');
	 $event_calendar_personal_manage = elgg_get_plugin_setting('personal_manage', 'event_calendar');
	 $event_calendar_repeating_events = elgg_get_plugin_setting('repeating_events', 'event_calendar');
	 // temporary place to store values
	 $e = new stdClass();
	 $e->schedule_type = '0';

		 $required_fields = array('title', 'start_date', 'end_date', 'venue');
	 
 

		 $user_guid = $user_entity->guid;
		 $event = new ElggObject();
		 $event->subtype = 'event_calendar';
		 $event->owner_guid = $user_guid;
		$event->container_guid = $event->owner_guid;
	 
 
	 if ($e->schedule_type != 'poll') {
		 if ($e->schedule_type == 'all_day') {
			 $start_date_text = $startdate;
		 } else {
			 $start_date_text = $startdate;
		 }
		 // TODO: is the timezone bit necessary?
		 $e->start_date = strtotime($start_date_text." ".date_default_timezone_get());
		 $end_date_text = $enddate;
		 if ($end_date_text) {
			 $e->end_date = strtotime($end_date_text." ".date_default_timezone_get());
		 } else {
			 $e->end_date = '';
		 }
 
		 if ($e->schedule_type != 'all_day' && $event_calendar_times != 'no') {
			//  $hour = get_input('start_time_hour', '');
			//  $minute = get_input('start_time_minute', '');
			//  $meridian = get_input('start_time_meridian', '');
			// if (is_numeric($hour) && is_numeric($minute)) {
				 $e->start_time = $starttime;//event_calendar_convert_to_time($hour, $minute, $meridian);
			// } else {
			//	 $e->start_time = '';
			// }
			//  $hour = get_input('end_time_hour', '');
			//  $minute = get_input('end_time_minute', '');
			//  $meridian = get_input('end_time_meridian', '');
			//  if (is_numeric($hour) && is_numeric($minute)) {
			// 	 $e->end_time = event_calendar_convert_to_time($hour, $minute, $meridian);
			//  } else {
				 $e->end_time =$endtime;
			 //}
			 if (is_numeric($e->start_date) && is_numeric($e->start_time)) {
				 // Set start date to the Unix start time, if set.
				 // This allows sorting by date *and* time.
				 $e->start_date += $e->start_time*60;
			 }
		 } else {
			 $e->start_time = 0;
			 $e->end_time = '';
		 }
	 }
	$start_time_exp = explode(':',$starttime);
	$start_time =60*$start_time_exp[0]+$start_time_exp[1];

	 $e->start_time = $start_time;  
	 $end_time_exp = explode(':',$endtime);
	 $end_time =60*$end_time_exp[0]+$end_time_exp[1];
 
	  $e->end_time = $end_time;  
 	error_log($start_time);
	 $e->access_id = $access;
	 $e->title = JSON_encode($title);
	 $e->title2 = '';
	 $e->brief_description = JSON_encode($excerpt);
	 $e->venue = "somewhere";
	 $e->fees = 'too much';
	 $e->language = 'both';
	 $e->teleconference_radio = true;
	 $e->teleconference = true;
	 $e->calendar_additional = 'more';
	 $e->start_date = $startdate->getTimestamp();
	 $e->end_date = $enddate->getTimestamp();
	// $e->start_time = 760;
	// $e->end_time = 1000;
	//  $e->calendar_additional2 = get_input('calendar_additional2');
	//  $e->calendar_additional = gc_implode_translation($e->calendar_additional,$e->calendar_additional2);
	// $e->contact = get_input('contact');
	 //$e->organiser = get_input('organiser');
	 //$e->tags = string_to_tag_array(get_input('tags'));
	 $e->description = JSON_encode($description);
	// $e->description2 = get_input('description2');
	 //$e->description = gc_implode_translation($e->description,$e->description2);
	 //$e->send_reminder = get_input('send_reminder');
	 //$e->reminder_number = get_input('reminder_number');
	 //$e->reminder_interval = get_input('reminder_interval');
	 //$e->web_conference = get_input('web_conference');
	 //$e->group_guid = get_input('group_guid');
	 //$e->real_end_time = event_calendar_get_end_time($e);
	 //$e->room = get_input('room');
	 //$e->contact_phone = get_input('contact_phone');
	 //$e->contact_email = get_input('contact_email');
	 //$e->contact_checkbox = get_input('contact_checkbox');
 
	 // sanity check
	 if ($e->schedule_type == 'fixed' && $e->real_end_time <= $e->start_date) {
		 register_error(elgg_echo('event_calander:end_before_start:error'));
		 return "error 1";
	 }
 
	 if ($e->teleconference_radio == 'no'){
		 $e->teleconference = '';
		 $e->calendar_additional = '';
 
	 }
 
 if((!$e->title)||(!$e->start_date) || (!$e->end_date)){
	 return 'error 2';
 }
 
 //Validation if recurrence box is check
 if ($event_calendar_repeating_events != 'no') {
	 $validation ='';
	 $repeats = get_input('repeats');
	 $e->repeats = $repeats;
	 if ($repeats == 'yes') {
 
		 $dow = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
		 foreach ($dow as $w) {
			 $v = 'event-calendar-repeating-'.$w.'-value';
			 $event->$v = get_input($v);
				 if($event->$v == 1){
					 $validation = '1';
				 }
		 }
		 if (!$validation){
			 return false;
		 }
	 }
	}
	$keys = array(
		'title',
		'title2',
		'brief_description',
		'access_id',
		'start_date',
		'start_time',
		'end_date',
		'end_time',
		'venue',
		'fees',
		'language',
		'teleconference_radio',
		'teleconference',
		'calendar_additional',
		'calendar_additional2',
		'contact',
		'organiser',
		'tags',
		'description',
		'description2',
		'send_reminder',
		'reminder_number',
		'reminder_interval',
		'web_conference',
		'real_end_time',
		'schedule_type',
		'group_guid',
		'room',
		'email',
		'contact_phone',
		'contact_email',
		'contact_checkbox',
		);

	foreach ($keys as $key) {
		if(($key != 'title2') && ($key != 'description2') && ($key != 'calendar_additional2') ){
			$event->$key = $e->$key;
		}

	}

	if ($event->save()) {
		error_log('save');
		if (!$event_guid && $event->web_conference) {
			if (!event_calendar_create_bbb_conf($event)) {
				register_error(elgg_echo('event_calendar:conference_create_error'));
			}
		}
		if ($group_guid && (elgg_get_plugin_setting('autogroup', 'event_calendar') == 'yes')) {
			event_calendar_add_personal_events_from_group($event->guid, $group_guid);
		}
	}


$event_guid = $event->guid;



		$event_calendar_autopersonal = elgg_get_plugin_setting('autopersonal', 'event_calendar');
		if (!$event_calendar_autopersonal || ($event_calendar_autopersonal == 'yes'))
		add_entity_relationship($user_entity->guid,'personal_event', $event_guid);

		$action = 'create';

		elgg_create_river_item(array(
			'view' => "river/object/event_calendar/$action",
			'action_type' => $action,
			'subject_guid' => $user_entity->guid,
			'object_guid' => $event->guid,
		));
	
		if ($event->schedule_type == 'poll')
			forward('event_poll/add/'.$event->guid);
	
	//	forward($event->getURL());
		return elgg_echo('event_calendar:add_event_response');
}

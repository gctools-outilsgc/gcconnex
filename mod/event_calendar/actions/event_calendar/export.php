<?php

elgg_load_library('elgg:event_calendar');
elgg_load_library('event_calendar:ical');

$filter = get_input('filter', 'mine');
$container_guid = get_input('container_guid', 0);
$region = get_input('region');
$start_date = get_input('start_date', date('Y-n-j'));
$end_date = get_input('end_date', date('Y-n-j'));
$start_ts = strtotime($start_date . " " . date_default_timezone_get());
$end_ts = strtotime($end_date . " " . date_default_timezone_get()) + 60 * 60 * 24 - 1;
$user_guid = elgg_get_logged_in_user_guid();

switch ($filter) {
	case 'mine':
		$events = event_calendar_get_events_for_user_between($start_ts, $end_ts, false, 0, 0, $user_guid, $container_guid, $region);
		break;
	case 'friends':
		$events = event_calendar_get_events_for_friends_between($start_ts, $end_ts, false, 0, 0, $user_guid, $container_guid, $region);
		break;
	case 'site':
		$container_guid = 0;
	case 'all':
		$events = event_calendar_get_events_between($start_ts, $end_ts, false, 0, 0, $container_guid, $region);
		break;
	default:
		// see if we're exporting just a single event
		$events = false;
		$event = get_entity($filter);
		if (elgg_instanceof($event, 'object', 'event_calendar')) {
			$events = array(array('event' => $event));
		}
		break;
}

if (!$events) {
	register_error(elgg_echo('event_calendar:no_events_found'));
	forward(REFERER);
}

$events = event_calendar_flatten_event_structure($events);

$timezone = date_default_timezone_get(); //get_plugin_setting('timezone', 'event_connector');

$config = array(
	'UNIQUE_ID' => elgg_get_site_url(),
	'FILENAME'=> 'Calendar.ics',
	'TZID' => $timezone
);

$v = new vcalendar($config);

$v->setProperty( 'method', 'PUBLISH' );
$v->setProperty( "X-WR-TIMEZONE", date_default_timezone_get() );
$v->setProperty( "calscale", "GREGORIAN" );
$v->setProperty( "version", "2.0" );
$v->setProperty( "X-WR-CALNAME", elgg_get_logged_in_user_entity()->username. "Calendar" );

iCalUtilityFunctions::createTimezone($v, $timezone);

foreach($events as $event) {
	//set default beginning and ending time
	$hb = 8;
	$he = 18;
	$mb = $me = $sb = $se = 0;
	if ($event->start_time) {
		$hb = (int)($event->start_time / 60);
		$mb = $event->start_time % 60;
	}

	if ($event->end_time) {
		$he = (int)($event->end_time / 60);
		$me = $event->end_time % 60;
	}

	$vevent = $v->newComponent('vevent');

	if (!isset($event->end_date)) {
		$event_end_date = $event->start_date;
	} else {
		$event_end_date = $event->end_date;
	}

	$start = array(
		'year' => date('Y', (int)$event->start_date),
		'month' => date('m', (int)$event->start_date),
		'day' => date('d', (int)$event->start_date),
		'hour' => $hb,
		'min' => $mb,
		'sec' => $sb
	);

	$vevent->setProperty('dtstart', $start);

	$end = array(
		'year' => date('Y', (int)$event_end_date),
		'month' => date('m', (int)$event_end_date),
		'day' => date('d', (int)$event_end_date),
		'hour' => $he,
		'min' => $me,
		'sec' => $se
	);

	$vevent->setProperty('dtend', $end);
	$vevent->setProperty('LOCATION', $event->venue);
	$vevent->setProperty('LAST_MODIFIED', $event->time_updated);
	$vevent->setProperty('summary', $event->title);
	$description = (isset($event->description) && $event->description != "") ? $event->description : null;

	if (!$description && $event->long_description) {
		$description = $event->long_description;
	}

	if (is_string($event->tags)) {
		$tags = implode(',' , $event->tags);
	} else {
		$tags = '';
	}

	$vevent->setProperty('description', $description);
	$vevent->setProperty('organizer', $event->getOwnerEntity()->email, array('CN' => $event->organiser));
	$vevent->setProperty( "X-PROP-REGION", $event->region );
	$vevent->setProperty( "X-PROP-TYPE", $event->event_type );
	$vevent->setProperty( "X-PROP-FEES", $event->fees );
	$vevent->setProperty( "X-PROP-TAGS", $tags);
	$vevent->setProperty( "X-PROP-CONTACT", $event->contact );
	$vevent->setProperty( "X-PROP-LONG-DESC", $event->long_description);
}

$v->returnCalendar();

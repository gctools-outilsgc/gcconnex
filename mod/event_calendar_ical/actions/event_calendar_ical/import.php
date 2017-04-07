<?php

elgg_load_library('elgg:event_calendar');
elgg_load_library('event_calendar_ical:creator');

$container_guid = (int) get_input('container_guid', 0);
$import_timezone = get_input('timezone', date_default_timezone_get());

// check if upload failed
if (!empty($_FILES['ical_file']['name']) && $_FILES['ical_file']['error'] != 0) {
	register_error(elgg_echo('event_calendar_ical:file:cannotload'));
	forward(REFERER);
}

// must have a file if a new file upload
if (empty($_FILES['ical_file']['name'])) {
  register_error(elgg_echo('event_calendar_ical:file:nofile'));
  forward(REFERER);
}

$thumb = new ElggFile();
$thumb->setMimeType($_FILES['ical_file']['type']);
$thumb->setFilename($_FILES['ical_file']['name']);
$thumb->open('write');
$thumb->close();

// copy the file
$moved = move_uploaded_file($_FILES['ical_file']['tmp_name'], $thumb->getFilenameOnFilestore());

if (!$moved) {
  register_error(elgg_echo('event_calendar_ical:file:cannotload'));
  forward(REFERER);
}

$path = pathinfo($thumb->getFilenameOnFilestore());

$config = array(
	'unique_id' => elgg_get_site_url(),
	'delimiter' => '/',
	'directory' => $path['dirname'],
	'filename' => $_FILES['ical_file']['name']
);

$v = new vcalendar($config);
$v->parse();

$timezone_calendar = $v->getProperty('X-WR-TIMEZONE');
$export_timezone = false;
if ($timezone_calendar[1]) {
  $export_timezone = $timezone_calendar[1];
}

$event_calendar_times = elgg_get_plugin_setting('times', 'event_calendar');
$event_calendar_region_display = elgg_get_plugin_setting('region_display', 'event_calendar');
$event_calendar_type_display = elgg_get_plugin_setting('type_display', 'event_calendar');
$event_calendar_more_required = elgg_get_plugin_setting('more_required', 'event_calendar');

// for now, turn off the more_required setting during import
elgg_set_plugin_setting('more_required', 'no', 'event_calendar');

$created = array(); // an array to hold all of the created events
while ($vevent = $v->getComponent()) {
  if ($vevent instanceof vevent) {
	$dtstart = $vevent->getProperty('dtstart');
	$dtend = $vevent->getProperty('dtend');
	
	if (empty($dtstart['hour'])) {
	  $dtstart['hour'] = 0;
	}
	
	if (empty($dtstart['min'])) {
	  $dtstart['min'] = 0;
	}
	
	if ($dtend && empty($dtend['hour'])) {
	  $dtend['hour'] = 0;
	}
	
	if ($dtend && empty($dtend['min'])) {
	  $dtend['min'] = 0;
	}
	
	// if we don't have an export timezone, check for Z in tz
	// @TODO - how do we handle offsets? why are there so many options for a standard?
	if (!$export_timezone) {
	  if ($dtstart['tz'] == 'Z' || $dtstart['tz'] == 'z') {
		$export_timezone = 'UTC';
	  }
	}
	
	if (!$export_timezone) {
	  // we can't determine any timezone, import it using the import timezone
	  $export_timezone = $import_timezone;
	}
	
	// get our timezone objects
	$ExportTimeZone = new DateTimeZone($export_timezone);
	$ImportTimeZone = new DateTimeZone($import_timezone);
	
	$starttime = new DateTime("{$dtstart['year']}-{$dtstart['month']}-{$dtstart['day']} {$dtstart['hour']}:{$dtstart['min']}:00", $ExportTimeZone);//new DateTime('2008-08-03 12:35:23');
	$starttime->setTimezone($ImportTimeZone);
	//echo $starttime->format('Y-m-d H:i:s');
	
	$endtime = new DateTime("{$dtend['year']}-{$dtend['month']}-{$dtend['day']} {$dtend['hour']}:{$dtend['min']}:00", $ExportTimeZone);//new DateTime('2008-08-03 12:35:23');
	$endtime->setTimezone($ImportTimeZone);
	
	$summary = $vevent->getProperty('summary');
	$description = $vevent->getProperty('description');
	$organiser = $vevent->getProperty('organizer', false, true);
	$venue = $vevent->getProperty('location') ? $vevent->getProperty('location') : "default";
	
	//cross plateform exchange
	$region = $fees = $type = $tags = "";
	$region = $vevent->getProperty( 'X-PROP-REGION' );
	$fees = $vevent->getProperty( 'X-PROP-FEES' );
	$event_type = $vevent->getProperty( 'X-PROP-TYPE' );
	$tags = $vevent->getProperty( 'X-PROP-TAGS' );
	$contact = $vevent->getProperty( 'X-PROP-CONTACT' );
	$long_description = $vevent->getProperty( 'X-PROP-LONG-DESC' );
	
	if (empty($long_description[1])) {
	  $long_description = array(1 => $description);
	}
	
	set_input('event_action', 'add_event');
	set_input('event_id', 0);
	
	if ($container_guid) {
	  set_input('group_guid', $container_guid);
	}
	
	set_input('title', elgg_strip_tags($summary));
	set_input('venue',$venue);
	  
	if ($event_calendar_times == 'yes') {
	  set_input('start_time_hour',$starttime->format('H'));
	  set_input('start_time_minute',$starttime->format('i'));
	  set_input('end_time_hour',$endtime->format('H'));
	  set_input('end_time_minute',$endtime->format('i'));
	}
	
	$strdate = $starttime->format('Y-m-d');
	set_input('start_date',$strdate);					

	$enddate = $endtime->format('Y-m-d');
	set_input('end_date',$enddate);
	
	set_input('brief_description', nl2br($description));
					
	if ($event_calendar_region_display == 'yes') {
	  set_input('region',$region[1]);
	}
					
	if ($event_calendar_type_display == 'yes') {
	  set_input('event_type',$event_type[1]);
	}

	set_input('fees',$fees[1]);
	set_input('contact',$contact[1]);
	set_input('organiser', $organiser['params']['CN']);
	set_input('tags',  $tags[1]);
	set_input('long_description', nl2br($long_description[1]));
	$result = event_calendar_set_event_from_form(0, $container_guid);
	
	if ($result) {
	  $created[] = $result;
	  add_to_river('river/object/event_calendar/create','create',elgg_get_logged_in_user_guid(),$result->guid);
	}
	else {
	  $error = true;
	  break;
	}
  }
}

elgg_set_plugin_setting('more_required', $event_calendar_more_required, 'event_calendar');

if ($error) {
  // there was an error, lets undo the imports that may have happened so far
  if ($created) {
	foreach ($created as $new_event) {
	  $new_event->delete();
	}
  }
  register_error(elgg_echo('event_calendar_ical:error:failed'));
  forward(REFERER);
}

system_message(elgg_echo('event_calendar:add_event_response'));
forward(REFERER);
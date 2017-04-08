<?php

elgg_load_library('elgg:event_calendar');
elgg_load_library('event_calendar_ical:creator');

$filter = get_input('filter', 'mine');
$container_guid = get_input('container_guid', 0);
$region = get_input('region');
$start_date = get_input('start_date', date('Y-n-j'));
$end_date = get_input('end_date', date('Y-n-j'));
$start_ts = strtotime($start_date . " " . date_default_timezone_get());
$end_ts = strtotime($end_date . " " . date_default_timezone_get()) + 60*60*24 - 1;
$user_guid = elgg_get_logged_in_user_guid();

switch ($filter) {
  case 'mine':
	$events = event_calendar_get_events_for_user_between2($start_ts,$end_ts,false,0,0,$user_guid,$container_guid, $region);
	break;
  
  case 'friends':
	$events = event_calendar_get_events_for_friends_between($start_ts,$end_ts,false,0,0,$user_guid,$container_guid, $region);
	break;  
  
  case 'site':
	$container_guid = 0;
  case 'all':
	$events = event_calendar_get_events_between($start_ts,$end_ts,false,0,0,$container_guid, $region);
	break;
  default:
	// see if we're exporting just a single event
	$events = false;
	$singleEvent = true;
	$event = get_entity($filter);
	if (elgg_instanceof($event, 'object', 'event_calendar')) {
	  $events = array(array('event' => $event));
	}
	break;
}

if (!$events) {		
	register_error(elgg_echo('event_calendar_ical:no_event'));
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
if(!$singleEvent)
	$v->setProperty( "X-WR-CALNAME", "GCconnex" );


iCalUtilityFunctions::createTimezone($v, $timezone);

foreach($events as $event){
	//set default beginning and ending time
	$hb = 8; $he = 18;
	$mb = $me = $sb = $se = 0;
	if($event->start_time) {
		$hb = (int)($event->start_time/60);
		$mb = $event->start_time%60;
	}
	
	if($event->end_time) {
		$he = (int)($event->end_time/60);
		$me = $event->end_time%60;
	}
	
	$vevent = $v->newComponent('vevent');

	if (!isset($event->end_date)) {
	  $event->end_date = $event->start_date;
	}
	
	$start = array(
		'year' => date('Y', $event->start_date),
		'month' => date('m', $event->start_date),
		'day' => date('d', $event->start_date),
		'hour' => $hb,
		'min' => $mb,
		'sec' => $sb
	);
	
	$vevent->setProperty('dtstart', $start);
	
	$end = array(
		'year' => date('Y', $event->end_date),
		'month' => date('m', $event->end_date),
		'day' => date('d', $event->end_date),
		'hour' => $he,
		'min' => $me,
		'sec' => $se
	);
	
	//get events language
	$language = $event->language;
	//get both titles
	$title_en = $event->title;
	$title_fr = $event->title2;
	//get both descriptions
	$description_en = $event->long_description;
	$description_fr = $event->long_description2;
	
	//create plain text description (strip all HTML)
	$description_en_PlainText = html_entity_decode(strip_tags($description_en));
	$description_fr_PlainText = html_entity_decode(strip_tags($description_fr));
	
	$debug = "";
	
	/*When an event is created and
		- there is no english title
		- there is a french title
	 The french title is copied over to the english title
	* if french and english titles are the same, don't include both in event title when exported
	*/
	/*if($title_fr)
		$debug .= "French title true<br/>";
	if($title_en)
		$debug .= "English title true<br/>";
	if(!strcmp($title_fr,$title_en))//english and french title equal
		$debug .= "English and French title equal<br/>";
	if($description_fr)
		$debug .= "french description true<br/>";
	if($description_en)
		$debug .= "english description true<br/>";
	*/
	if(!strcmp($title_fr,$title_en))//english and french title equal
		$title_bi = $title_fr;
	else if($title_fr){
		if(!strcmp($language, "English"))//event language english put english first
			$title_bi = $title_en . " / " . $title_fr;
		else
			$title_bi = $title_fr . " / " . $title_en;
	}
	else $title_bi = $title_en;
	
	
	
	//$title_bi = $title_fr . " / " . $title_en;
	
	
	//Convert description to plain text
	
	if($description_fr && $description_en){
		if(!strcmp($language, "English")){//event language english put english first
			$description_bi = $description_en . "<hr/>". $description_fr;
			$description_bi_PlainText = $description_en_PlainText. "\n------------------------------\n" . $description_fr_PlainText;
		}else{
			$description_bi =  $description_fr. "<hr/>". $description_en;
			$description_bi_PlainText = $description_fr_PlainText . "\n------------------------------\n" . $description_en_PlainText;
		}
	}else if($description_en){
		$description_bi = $description_en;
		$description_bi_PlainText = $description_en_PlainText;
	}else{
		$description_bi = $description_fr;
		$description_bi_PlainText = $description_fr_PlainText;
	}
	
	//$description_bi = "language: " . $language . "<br/>" . $description_fr . "<hr/>".$description_en . "<br/>" . $debug;
	 //"";
	
	
	$vevent->setProperty('dtend', $end);
	$vevent->setProperty('LOCATION', $event->venue);
	$vevent->setProperty('LAST_MODIFIED', $event->time_updated);
	$vevent->setProperty('summary', $title_bi);
	//$description = (isset($event->description) && $event->description != "") ? $event->description : null;
	
	$vevent->setProperty("description", $description_bi_PlainText);
	//add html description so compatible applications can display the rich text
	$vevent->setProperty('X-ALT-DESC;FMTTYPE=text/html', $description_bi);
	$vevent->setProperty('organizer', $event->getOwnerEntity()->email, array('CN' => $event->organiser));
	$vevent->setProperty( "X-PROP-REGION", $event->region );
	$vevent->setProperty( "X-PROP-TYPE", $event->event_type );
	$vevent->setProperty( "X-PROP-FEES", $event->fees );
	$vevent->setProperty( "X-PROP-TAGS", implode(',' , $event->tags) );
	$vevent->setProperty( "X-PROP-CONTACT", $event->contact );
	$vevent->setProperty( "X-PROP-LONG-DESC", $event->long_description);
		
}

$v->returnCalendar();
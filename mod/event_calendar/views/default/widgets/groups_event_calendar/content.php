<?php

// Load event calendar model
elgg_load_library('elgg:event_calendar');

//the number of events to display
$num = (int) $vars['entity']->events_count;
if (!$num) {
	$num = 4;
}

$group = elgg_get_page_owner_entity();

// Get the events
$owner = elgg_get_page_owner_entity();
if(elgg_instanceof($owner, 'group')) {
	$events = event_calendar_get_events_for_group($owner->getGUID(), $num);
}

$starts_date1 = date("j F Y", strtotime("now"));  
$end_date1=date('j F Y', strtotime('+1 year', strtotime($starts_date1)) );
$starts_date2 = strtotime($starts_date1);
$end_date2 = strtotime($end_date1);
$events = event_calendar_get_events_between($starts_date2, $end_date2, false, $limit, $offset, $owner->getGUID(), $region);
$events = event_calendar_flatten_event_structure($events);

// If there are any events to view, view them
if (is_array($events) && sizeof($events) > 0) {
	echo "<div id=\"widget_calendar\">";
	$i = 0;	
	foreach($events as $event) {

		echo elgg_view("object/event_calendar", array('entity' => $event));
		if (++$i == $num) break;

	}
	echo "</div>";
} else {
	echo elgg_echo('event_calendar:no_events_found');
}
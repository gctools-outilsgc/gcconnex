<?php

// Load event calendar model
elgg_load_library('elgg:event_calendar');

//the number of events to display
$num = (int) $vars['entity']->events_count;
if (!$num) {
	$num = 4;
}

// Get the events
$owner = elgg_get_page_owner_entity();
if(elgg_instanceof($owner, 'group')) {
	$events = event_calendar_get_events_for_group($owner->getGUID(), $num);
}

// If there are any events to view, view them
if (is_array($events) && sizeof($events) > 0) {
	echo "<div id=\"widget_calendar\">";
	foreach($events as $event) {
		echo elgg_view("object/event_calendar", array('entity' => $event));
	}
	echo "</div>";
} else {
	echo elgg_echo('event_calendar:no_events_found');
}
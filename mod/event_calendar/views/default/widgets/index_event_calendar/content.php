<?php

//the number of events to display
$num = (int) $vars['entity']->events_count;
if (!$num) {
	$num = 4;
}

// Display $num (personal and group) events
// but don't show events that have been over for more than a day
// TODO How to deal with recurring events?
// TODO Instead of only checking start_date it might be better to check (start_date OR end_date) like in event_calendar_get_personal_events_for_user()
// but how to do that without fetching all events first?
$now = time();
$one_day = 60*60*24;
$options = array(
	'type' => 'object',
	'subtype' => 'event_calendar',
	'metadata_name_value_pair' => array('name' => 'start_date', 'value' => $now-$one_day,  'operand' => '>'),
	'limit' => $num,
);

$events = elgg_get_entities_from_metadata($options);

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
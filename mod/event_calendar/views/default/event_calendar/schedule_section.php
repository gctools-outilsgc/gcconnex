<?php

$event = $vars['event'];
$fd = $vars['form_data'];
$event_calendar_repeated_events = elgg_get_plugin_setting('repeated_events', 'event_calendar');

$body = '<div class="event-calendar-edit-date-wrapper mbm">';
$body .= elgg_view('event_calendar/datetime_edit', array(
	'start_date' => $fd['start_date'],
	'end_date' => $fd['end_date'],
	'start_time' => $fd['start_time'],
	'end_time' => $fd['end_time'],
	'prefix' => $vars['prefix'],
	'fd' => $fd,
));
$body .= '</div>';
if ($event_calendar_repeated_events == 'yes') {
	$body .= '<div class="mbl">' . elgg_view('event_calendar/repeat_form_element', $vars) . '</div>';
}

$body .= '<div class="mbl">' . elgg_view('event_calendar/reminder_section', $vars) . '</div>';

echo $body;

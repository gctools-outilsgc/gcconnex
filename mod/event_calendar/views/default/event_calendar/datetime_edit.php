<?php

$event_calendar_times = elgg_get_plugin_setting('times', 'event_calendar');
$event_calendar_hide_end = elgg_get_plugin_setting('hide_end', 'event_calendar');
$prefix = $vars['prefix'];
$body = '';

if ($event_calendar_times != 'no') {
	if ($event_calendar_hide_end != 'yes') {
		$body .= '<div class="mbm"><label>'.elgg_echo('event_calendar:from_label').' '.'</label>';
	}
	$body .= elgg_view("event_calendar/input/date_local", array(
		'autocomplete' => 'off',
		'class' => 'event-calendar-compressed-date clearfix',
		'name' => 'start_date',
		'value' => $vars['start_date'],
	));
	$body .= '<span id="event-calendar-start-time-wrapper">';
	$body .= elgg_view("input/timepicker", array(
		'name' => 'start_time',
		'value' => $vars['start_time'],
		'hours' => $vars['fd']['start_time_hour'],
		'minutes' => $vars['fd']['start_time_minute'],
		'meridian' => $vars['fd']['start_time_meridian'],
		'class' => 'pull-left'
	));
	$body .= '</span>';
	if ($event_calendar_hide_end != 'yes') {
		$body .= '</div><div id="event-calendar-to-time-wrapper"><label>'.elgg_echo('event_calendar:to_label').' '.'</label>';
		$body .= elgg_view("event_calendar/input/date_local", array(
			'autocomplete' => 'off',
			'class' => 'event-calendar-compressed-date',
			'name' => 'end_date',
			'value' => $vars['end_date'],
		));
		$body .= '<span id="event-calendar-end-time-wrapper">';
		$body .= elgg_view("input/timepicker", array(
			'name' => 'end_time',
			'value' => $vars['end_time'],
			'hours' => $vars['fd']['end_time_hour'],
			'minutes' => $vars['fd']['end_time_minute'],
			'meridian' => $vars['fd']['end_time_meridian'],
			'class' => 'pull-left'
		));
		$body .= '</span>';
	}
	$body .= '</div></span>';
} else {

	$body .= '<div class="mbm"><label>'.elgg_echo("event_calendar:start_date_label").'</label><br>';
	$body .= elgg_view("event_calendar/input/date_local", array('timestamp' => true, 'autocomplete' => 'off', 'name' => 'start_date', 'value' => $vars['start_date']));
	$body .= '<div class="elgg-subtext">'.$prefix['start_date'].elgg_echo('event_calendar:start_date_description').'</div>';
	$body .= '</div>';

	if ($event_calendar_hide_end != 'yes') {
		$body .= '<div class="mbm" id="event-calendar-to-time-wrapper"><label>'.elgg_echo("event_calendar:end_date_label").'</label><br>';
		$body .= elgg_view("event_calendar/input/date_local", array('timestamp' => true, 'autocomplete' => 'off', 'name' => 'end_date', 'value' => $vars['end_date']));
		$body .= '</div>';
	}
}

echo $body;

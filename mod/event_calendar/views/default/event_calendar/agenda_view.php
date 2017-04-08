<?php

$nav = elgg_view('navigation/pagination',array(
	'base_url' => $_SERVER['SCRIPT_NAME'].'/?'.$_SERVER['QUERY_STRING'],
	'offset' => $vars['offset'],
	'count' => $vars['count'],
	'limit' => $vars['limit'],
));

$event_calendar_times = elgg_get_plugin_setting('times', 'event_calendar');
$events = $vars['events'];
$html = '';
$date_format_day = 'j';
$date_format_month = 'm';
$date_format_year = 'Y';
$current_date = '';

if ($events) {
	foreach($events as $event) {
		$date = date($date_format_day, $event->start_date) . ". " . elgg_echo("event_calendar:month:".date($date_format_month, $event->start_date)) . " " . date($date_format_year, $event->start_date);
		if ($date != $current_date) {
			if ($html) {
				$html .= elgg_view('event_calendar/agenda_footer');
			}
			$html .= elgg_view('event_calendar/agenda_header', array('date' => $date));

			$current_date = $date;
		}
		$html .= elgg_view('event_calendar/agenda_item_view', array('event' => $event, 'times' => $event_calendar_times));
	}
	$html .= elgg_view('event_calendar/agenda_footer');
}
$html = $nav.'<div class="event_calendar_agenda">'.$html.'</div>'.$nav;

echo $html;

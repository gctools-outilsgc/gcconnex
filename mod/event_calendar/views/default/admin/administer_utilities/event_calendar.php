<?php

elgg_require_js('event_calendar/delete_past_events');

$title = elgg_echo('event_calendar:administer:title');

$body = "<div class='mbl'>" . elgg_echo('event_calendar:administer:description') . "</div>";

$delete_upper_limit_options = array(
	' ' . elgg_echo('event_calendar:administer:one_year') => 'one_year',
	' ' . elgg_echo('event_calendar:administer:half_year') => 'half_year',
	' ' . elgg_echo('event_calendar:administer:three_months') => 'three_months',
	' ' . elgg_echo('event_calendar:administer:four_weeks') => 'four_weeks',
	' ' . elgg_echo('event_calendar:administer:two_weeks') => 'two_weeks',
);

$delete_upper_limit = "<div class='mbl'>";
$delete_upper_limit .= "<label>" . elgg_echo('event_calendar:administer:delete_upper_limit_label') . "</label>";
$delete_upper_limit .= "<br>";
$delete_upper_limit .= elgg_view('input/radio', array('name' => 'delete_upper_limit', 'options' => $delete_upper_limit_options, 'value' => 'one_year'));
$delete_upper_limit .= "</div>";

$delete_repeating_events .= "<div class='mbl'>";
$delete_repeating_events .= elgg_view('input/checkbox', array(
	'name' => 'delete_repeating_events',
	'value' => 1,
	'label' => ' ' . elgg_echo('event_calendar:administer:delete_repeating_events')
));
$delete_repeating_events .= "</div>";

$submit = elgg_view('input/submit', array(
	'value' => elgg_echo('submit'),
	'id' => 'elgg-event-calendar-past-delete-submit'
));

$body .=<<<HTML
	$delete_upper_limit
	$delete_repeating_events
	<div>
		$submit
		<div id="elgg-event-calendar-past-delete-results"></div>
	</div>
HTML;

echo elgg_view_module('inline', $title, $body);

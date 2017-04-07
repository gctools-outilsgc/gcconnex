<?php

echo '<br>';
echo '<h3>' . elgg_echo('event_calendar_ical:export:settings') . '</h3>';
echo '<br>';


// export which calendar
echo elgg_echo('event_calendar_ical:export:type') . ' ';

$options_values = array();

if (elgg_get_plugin_setting('site_calendar', 'event_calendar') != 'no') {
  $options_values[0] = elgg_echo('event_calendar_ical:site');
}


$groups = elgg_get_logged_in_user_entity()->getGroups('', false);
  
if ($groups) {
  foreach ($groups as $group) {
	if (event_calendar_activated_for_group($group)) {
	  $options_values[$group->guid] = elgg_echo('group') . ': ' . $group->name;
    }
  }
}


echo elgg_view('input/dropdown', array(
	'name' => 'container_guid',
	'value' => $vars['group_guid'],
	'options_values' => $options_values
));


echo '<br><br>';

echo elgg_echo('event_calendar_ical:filter') . ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'filter',
	'value' => $vars['filter'],
	'options_values' => array(
		'all' => elgg_echo('event_calendar_ical:all'),
		'mine' => elgg_echo('event_calendar_ical:mine'),
		'friends' => elgg_echo('event_calendar_ical:friends')
	)
));

echo '<br><br>';

$region_list = trim(elgg_get_plugin_setting('region_list', 'event_calendar'));
// make sure that we are using Unix line endings
$region_list = str_replace("\r\n","\n",$region_list);
$region_list = str_replace("\r","\n",$region_list);
if ($region_list) {
	$options_values = array('-' =>elgg_echo('event_calendar:all'));
	foreach(explode("\n",$region_list) as $region_item) {
		$region_item = trim($region_item);
		$options_values[$region_item] = $region_item;
	}
	
	echo elgg_echo('event_calendar:region_filter_by_label');
	echo elgg_view("input/dropdown", array('name' => 'region', 'value' => $vars['region'], 'options_values' => $options_values));
	echo '<br><br>';
}


// determine default dates - start/end based on interval day/week/month
// start will be at 00:00 at the beginning of the day/week/month
// end will be at 23:59 at the end of day
// $date[0] = year, 1 = month, 2 = day
$date = explode('-', $vars['date']);
switch ($vars['interval']) {
  case 'day':
	$start_date = $end_date = $vars['date'];
	break;
  
  case 'week':
	// need to adjust start_date to be the beginning of the week
	$start_ts = strtotime($vars['date']);
	$start_ts -= date("w",$start_ts)*60*60*24;
	$end_ts = $start_ts + 6*60*60*24;
				
	$start_date = date('Y-m-d',$start_ts);
	$end_date = date('Y-m-d',$end_ts);
	break;
  
  case 'month':
  default:
	$start_date = $date[0] . '-' . $date[1] . '-1';
	$end_date = $date[0] . '-' . $date[1] . '-' . getLastDayOfMonth($date[1],$date[0]);
	break;
}

// start/end date
echo elgg_echo('event_calendar_ical:start_date') . "<br>";
echo elgg_view('input/date', array('name' => 'start_date', 'value' => $start_date, 'style' => 'width: 120px')) . "<br><br>";

echo elgg_echo('event_calendar_ical:end_date') . "<br>";
echo elgg_view('input/date', array('name' => 'end_date', 'value' => $end_date, 'style' => 'width: 120px;'));

echo '<br><br>';

echo elgg_view('input/submit', array('value' => elgg_echo('event_calendar_ical:export')));

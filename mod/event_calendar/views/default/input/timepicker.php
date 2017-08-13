<?php

$time_format = elgg_get_plugin_setting('timeformat', 'event_calendar');
if (!$time_format) {
	$time_format = '24';
}

$value = $vars['value'];
if (isset($vars['hours']) && $vars['hours']) {
	$hour = $vars['hours'];
	$minute = $vars['minutes'];
	$meridian = $vars['meridian'];
} else {
	if (is_numeric($value)) {
	$hour = floor($value/60);
	$minute = ($value -60*$hour);
	} else {
		$hour = 0;
		$minute = 0;
	}
	if ($time_format == '12') {
		if ($hour == 0) {
			$hour = 12;
			$meridian = 'am';
		} else if ($hour == 12) {
			$meridian = 'pm';
		} else if ($hour < 12) {
			$meridian = 'am';
		} else {
			$hour -= 12;
			$meridian = 'pm';
		}
	}
}

$hours = array();
$minutes = array();

if ($time_format == '12') {
	$meridians = array('am'=>'am','pm'=>'pm');
	for($h=1;$h<=12;$h++) {
		$hours[$h] = $h;
	}
} else {
	for($h=0;$h<=23;$h++) {
		$hours[$h] = $h;
	}
}

for($m=0;$m<60;$m=$m+5) {
	$mt = sprintf("%02d",$m);
	$minutes[$m] = $mt;
}

echo elgg_view('input/select', array('name' => $vars['name'].'_hour', 'value' => $hour, 'options_values' => $hours));
echo " <b>:</b> ";
echo elgg_view('input/select', array('name' => $vars['name'].'_minute', 'value' => $minute, 'options_values' => $minutes));
if ($time_format == '12') {
	echo elgg_view('input/select', array('name' => $vars['name'].'_meridian', 'value' => $meridian, 'options_values' => $meridians));
}

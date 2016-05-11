<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Displays the weekend start time and duration inputs.
 */
	$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
	$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
	$durationarray = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));

	$weekend_array = $_SESSION['weekend_array'];
	
	$input_saturday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'sat_start_hour',
			'value' => $weekend_array['sat_start_hour'],
			'options' => $hourarray,
			'class' => 'time-dropdown',
			'id' => 'time-saturday-start-hour-dropdown-input'
	));
	$input_saturday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'sat_start_min',
			'value' => $weekend_array['sat_start_min'],
			'options' => $minarray,
			'class' => 'time-dropdown',
			'id' => 'time-saturday-start-minute-dropdown-input'
	));
	$input_sunday_start_hour = elgg_view('input/dropdown', array(
			'name' => 'sun_start_hour',
			'value' => $weekend_array['sun_start_hour'],
			'options' => $hourarray,
			'class' => 'time-dropdown',
			'id' => 'time-sunday-start-hour-dropdown-input'
	));
	$input_sunday_start_minute = elgg_view('input/dropdown', array(
			'name' => 'sun_start_min',
			'value' => $weekend_array['sun_start_min'],
			'options' => $minarray,
			'class' => 'time-dropdown',
			'id' => 'time-sunday-start-minute-dropdown-input'
	));
	$input_saturday_duration_hour = elgg_view('input/dropdown', array(
			'name' => 'sat_duration_hour',
			'value' => $weekend_array['sat_duration_hour'],
			'options' => $durationarray,
			'class' => 'time-dropdown',
			'id' => 'time-saturday-duration-hour-dropdown-input'
	));
	$input_saturday_duration_minute = elgg_view('input/dropdown', array(
			'name' => 'sat_duration_min',
			'value' => $weekend_array['sat_duration_min'],
			'options' => $minarray,
			'class' => 'time-dropdown',
			'id' => 'time-saturday-duration-minute-dropdown-input'
	));
	$input_sunday_duration_hour = elgg_view('input/dropdown', array(
			'name' => 'sun_duration_hour',
			'value' => $weekend_array['sun_duration_hour'],
			'options' => $durationarray,
			'class' => 'time-dropdown',
			'id' => 'time-sunday-duration-hour-dropdown-input'
	));
	$input_sunday_duration_minute = elgg_view('input/dropdown', array(
			'name' => 'sun_duration_min',
			'value' => $weekend_array['sun_duration_min'],
			'options' => $minarray,
			'class' => 'time-dropdown',
			'id' => 'time-sunday-duration-minute-dropdown-input'
	));
?>

<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:sat'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
			echo '<span class="missions-inline-drop">' . $input_saturday_start_hour . '</span>';
			echo '<span style="font-size:16pt;"> : </span>';
			echo '<span class="missions-inline-drop">' . $input_saturday_start_minute . '</span>';
		?></div>
	</td></tr>
	<tr><td>
		<div><?php
			echo '<span class="missions-inline-drop">' . $input_saturday_duration_hour . '</span>';
			echo '<span style="font-size:16pt;"> : </span>';
			echo '<span class="missions-inline-drop">' . $input_saturday_duration_minute . '</span>';
		?></div>
	</td></tr>
</table>
<table class="mission-post-table-day">
	<tr><td>
		<h4> <?php echo elgg_echo('missions:sun'); ?> </h4>
	</td></tr>
	<tr><td>
		<div><?php
			echo '<span class="missions-inline-drop">' . $input_sunday_start_hour . '</span>';
			echo '<span style="font-size:16pt;"> : </span>';
			echo '<span class="missions-inline-drop">' . $input_sunday_start_minute . '</span>';
		?></div>
	</td></tr>
	<tr><td>
		<div><?php
			echo '<span class="missions-inline-drop">' . $input_sunday_duration_hour . '</span>';
			echo '<span style="font-size:16pt;"> : </span>';
			echo '<span class="missions-inline-drop">' . $input_sunday_duration_minute . '</span>';
		?></div>
	</td></tr>
</table>
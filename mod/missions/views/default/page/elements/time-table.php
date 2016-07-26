<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View which displays 28 dropdown fields. These are for the start times and duration of every day of the week.
 * Values in the dropdown fields are extracted from the hour_string and minute_string found in settings.
 */
/*$hourarray = explode(',', elgg_get_plugin_setting('hour_string', 'missions'));
$minarray = explode(',', elgg_get_plugin_setting('minute_string', 'missions'));
$durationarray = explode(',', elgg_get_plugin_setting('duration_string', 'missions'));

$metadata = array();
$metadata = $vars['mission_metadata'];
$_SESSION['mm_metadata_array'] = $metadata;*/

$mission = $vars['entity'];

if (elgg_is_sticky_form('tdropfill')) {
    extract(elgg_get_sticky_values('tdropfill'));
    // elgg_clear_sticky_form('thirdfill');
}

$monday = elgg_view('page/elements/time-table-day', array(
		'day' => 'mon',
		'start' => $mission->mon_start,
		'duration' => $mission->mon_duration
));
	
$tuesday = elgg_view('page/elements/time-table-day', array(
		'day' => 'tue',
		'start' => $mission->tue_start,
		'duration' => $mission->tue_duration
));
	
$wednesday = elgg_view('page/elements/time-table-day', array(
		'day' => 'wed',
		'start' => $mission->wed_start,
		'duration' => $mission->wed_duration
));
	
$thursday = elgg_view('page/elements/time-table-day', array(
		'day' => 'thu',
		'start' => $mission->thu_start,
		'duration' => $mission->thu_duration
));
	
$friday = elgg_view('page/elements/time-table-day', array(
		'day' => 'fri',
		'start' => $mission->fri_start,
		'duration' => $mission->fri_duration
));

$saturday = elgg_view('page/elements/time-table-day', array(
		'day' => 'sat',
		'start' => $mission->sat_start,
		'duration' => $mission->sat_duration
));

$sunday = elgg_view('page/elements/time-table-day', array(
		'day' => 'sun',
		'start' => $mission->sun_start,
		'duration' => $mission->sun_duration
));
?>

<div style="display:inline-block;">
	<div style="height:35px;">
	</div>
	<div style="font-weight:bold;height:37px;">
    	<?php echo elgg_echo('missions:start_time'); ?>
    </div>
    <div style="font-weight:bold;height:37px;">
    	<?php echo elgg_echo('missions:duration'); ?>
    </div>
</div>

<?php echo $monday; ?>
<?php echo $tuesday; ?>
<?php echo $wednesday; ?>
<?php echo $thursday; ?>
<?php echo $friday; ?>
<?php echo $saturday; ?>
<?php echo $sunday; ?>

<div style="font-style:italic;">
	<?php echo elgg_echo('missions:time_table_example'); ?>
</div>
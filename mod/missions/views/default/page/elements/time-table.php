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
		/*'start_hour' => $metadata['mon_start_hour'],
		'start_min' => $metadata['mon_start_min'],
		'duration_hour' => $metadata['mon_duration_hour'],
		'duration_min' => $metadata['mon_duration_min']*/
		'start' => $mission->mon_start,
		'duration' => $mission->mon_duration
));
	
$tuesday = elgg_view('page/elements/time-table-day', array(
		'day' => 'tue',
		/*'start_hour' => $metadata['tue_start_hour'],
		'start_min' => $metadata['tue_start_min'],
		'duration_hour' => $metadata['tue_duration_hour'],
		'duration_min' => $metadata['tue_duration_min']*/
		'start' => $mission->tue_start,
		'duration' => $mission->tue_duration
));
	
$wednesday = elgg_view('page/elements/time-table-day', array(
		'day' => 'wed',
		/*'start_hour' => $metadata['wed_start_hour'],
		'start_min' => $metadata['wed_start_min'],
		'duration_hour' => $metadata['wed_duration_hour'],
		'duration_min' => $metadata['wed_duration_min']*/
		'start' => $mission->wed_start,
		'duration' => $mission->wed_duration
));
	
$thursday = elgg_view('page/elements/time-table-day', array(
		'day' => 'thu',
		/*'start_hour' => $metadata['thu_start_hour'],
		'start_min' => $metadata['thu_start_min'],
		'duration_hour' => $metadata['thu_duration_hour'],
		'duration_min' => $metadata['thu_duration_min']*/
		'start' => $mission->thu_start,
		'duration' => $mission->thu_duration
));
	
$friday = elgg_view('page/elements/time-table-day', array(
		'day' => 'fri',
		/*'start_hour' => $metadata['fri_start_hour'],
		'start_min' => $metadata['fri_start_min'],
		'duration_hour' => $metadata['fri_duration_hour'],
		'duration_min' => $metadata['fri_duration_min']*/
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

/*$weekend_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:weekend'),
		'class' => 'elgg-button btn btn-default',
		'id' => 'time-table-weekend-button',
		'onclick' => 'set_weekend()'
));

$no_weekend_button = elgg_view('output/url', array(
		'text' => elgg_echo('missions:no_weekend'),
		'class' => 'elgg-button btn btn-default',
		'id' => 'time-table-no-weekend-button',
		'onclick' => 'unset_weekend()'
));*/
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

 <!--  
<div style="display:inline-block;">
	<div>
	</div>
	<div>
		<?php //echo $weekend_button; ?>
	</div>
	<div>
		<?php //echo $no_weekend_button; ?>
	</div>
</div>

<div id="weekend-section" style="display:inline-block;">
	<noscript>
		<?php //echo elgg_view('missions/weekend'); ?>
	</noscript>
</div>
-->

<script>
	/*function set_weekend() {
		var section = "#weekend-section";
		
		elgg.get('ajax/view/missions/weekend', {
			success: function(result, success, xhr) {
				$(section).html(result);
			}
		});
	}

	function unset_weekend() {
		var section = "#weekend-section";
		$(section).html("");
	}*/
	
	/*$('document').ready(function() {
	    $("#time-tue-start-text-input").mask("00:00");
	});*/
</script>
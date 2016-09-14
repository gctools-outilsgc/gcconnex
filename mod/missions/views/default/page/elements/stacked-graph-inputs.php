<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * The set of inputs necessary to create a Stacked Graph.
 */
$input_start_date = elgg_view('input/date', array(
		'name' => 'start_date',
		'value' => $start_date,
		'id' => 'data-analytics-start-date-input',
		'placeholder' => 'yyyy-mm-dd',
		'onchange' => 'wipe_away_graph()'
));

$input_end_date = elgg_view('input/date', array(
		'name' => 'end_date',
		'value' => $end_date,
		'id' => 'data-analytics-end-date-input',
		'placeholder' => 'yyyy-mm-dd',
		'onchange' => 'wipe_away_graph()'
));

$input_interval = elgg_view('input/dropdown', array(
		'name' => 'date_interval',
		'value' => $date_interval,
		'options_values' => array(
				'missions:year' => elgg_echo('missions:year'),
				'missions:fiscal_year' => elgg_echo('missions:fiscal_year'),
				'missions:quarter' => elgg_echo('missions:quarter'),
				'missions:month' => elgg_echo('missions:month'),
				'missions:week' => elgg_echo('missions:week'),
				'missions:day' => elgg_echo('missions:day')
		),
		'id' => 'data-analytics-interval-dropdown-input',
		'onchange' => 'wipe_away_graph()'
));

$input_target_mission_date = elgg_view('input/dropdown', array(
		'name' => 'target_mission_date',
		'value' => $target_mission_date,
		'options_values' => array(
				'missions:date_posted' => elgg_echo('missions:date_posted'),
				'missions:start_date' => elgg_echo('missions:start_date'),
				'missions:closure_date' => elgg_echo('missions:closure_date')
		),
		'id' => 'data-analytics-target-mission-date-dropdown-input',
		'onchange' => 'wipe_away_graph()'
));

$input_separator = elgg_view('input/dropdown', array(
		'name' => 'separator',
		'value' => $separator,
		'options_values' => array(
				'' => '',
				'missions:type' => elgg_echo('missions:type'),
				'missions:state' => elgg_echo('missions:state'),
				'missions:virtual_opportunity' => elgg_echo('missions:virtual_opportunity'),
				'missions:limited_by_department' => elgg_echo('missions:limited_by_department'),
				'missions:reliability' => elgg_echo('missions:reliability'),
				'missions:reason_to_decline' => elgg_echo('missions:reason_to_decline'),
				'missions:average_number_of_applicants' => elgg_echo('missions:average_number_of_applicants'),
				'missions:location' => elgg_echo('missions:location'),
				'missions:field_of_work' => elgg_echo('missions:program_area'),
		),
		'id' => 'data-analytics-separator-dropdown-input',
		'onchange' => 'wipe_away_graph(); disable_target_date();'
));
?>

<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-separator-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:separate_missions_by') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_separator; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-start-date-input' class="col-sm-3" style="text-align:right;"">
		<?php echo elgg_echo('missions:start_date') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_start_date; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-end-date-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:end_date') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_end_date; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-interval-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:time_interval') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_interval; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-target-mission-date-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:target_date') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_target_mission_date; ?>
	</div>
</div>
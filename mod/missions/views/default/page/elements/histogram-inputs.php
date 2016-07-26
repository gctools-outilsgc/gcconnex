<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * The set of inputs necessary to create a Histogram.
 */
if($bin_number == '') {
	$bin_number = 9;
}

$input_bin_number = elgg_view('input/dropdown', array(
		'name' => 'bin_number',
		'value' => $bin_number,
		'options' => array(5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21),
		'id' => 'data-analytics-bin-number-input',
		'onchange' => 'wipe_away_graph()'
));

$input_target_value = elgg_view('input/dropdown', array(
		'name' => 'target_value',
		'value' => $target_value,
		'options_values' => array(
				'missions:time_to_post_mission' => elgg_echo('missions:time_to_post_mission'),
				'missions:time_to_fill_mission' => elgg_echo('missions:time_to_fill_mission'),
				'missions:time_to_complete_mission' => elgg_echo('missions:time_to_complete_mission'),
				'missions:time_to_cancel_mission' => elgg_echo('missions:time_to_cancel_mission'),
				'missions:hours_total' => elgg_echo('missions:hours_total'),
				'missions:hours_per_day' => elgg_echo('missions:hours_per_day'),
				'missions:hours_per_week' => elgg_echo('missions:hours_per_week'),
				'missions:hours_per_month' => elgg_echo('missions:hours_per_month')
		),
		'id' => 'data-analytics-target-value-dropdown-input',
		'onchange' => 'wipe_away_graph()'
));
?>

<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-bin-number-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:number_of_intervals') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_bin_number; ?>
	</div>
</div>
<div class="col-sm-12" style="margin:4px;">
	<label for='data-analytics-target-value-dropdown-input' class="col-sm-3" style="text-align:right;"">
		<?php echo elgg_echo('missions:target_value') . ':';?>
	</label>
	<div class="col-sm-4">
		<?php echo $input_target_value; ?>
	</div>
</div>
<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which allows users to designate a time period and interval for the analytics graph.
 */
$time_period = get_input('gitp');
$start_month = get_input('gism');
$start_year = get_input('gisy');
$end_month = get_input('giem');
$end_year = get_input('giey');
$graph = get_input('gig');

if (elgg_is_sticky_form('intervalfill')) {
    extract(elgg_get_sticky_values('intervalfill'));
    elgg_clear_sticky_form('intervalfill');
}

if(!$end_month) {
	$end_month = date('m');
}

if(!$end_year) {
	$end_year = date('Y');
}

$input_time_period = elgg_view('input/dropdown', array(
		'name' => 'time_period',
		'value' => $time_period,
		'options' => array(elgg_echo('missions:year'), elgg_echo('missions:fiscal_year'), elgg_echo('missions:quarter'), elgg_echo('missions:month')),
		'id' => 'missions-graph-interval-time-period-input'
));

/*$input_date = elgg_view('input/date', array(
		'name' => 'date',
		'value' => $date,
		'id' => 'missions-graph-interval-date-input'
));

$input_time_interval = elgg_view('input/dropdown', array(
		'name' => 'time_interval',
		'value' => $time_interval,
		'options' => array(elgg_echo('missions:monthly'), elgg_echo('missions:weekly')),
		'id' => 'missions-graph-interval-time-interval-input'
));*/

$month_values = array(
		'01' => elgg_echo('missions:january'),
		'02' => elgg_echo('missions:february'),
		'03' => elgg_echo('missions:march'),
		'04' => elgg_echo('missions:april'),
		'05' => elgg_echo('missions:may'),
		'06' => elgg_echo('missions:june'),
		'07' => elgg_echo('missions:july'),
		'08' => elgg_echo('missions:august'),
		'09' => elgg_echo('missions:september'),
		'10' => elgg_echo('missions:october'),
		'11' => elgg_echo('missions:november'),
		'12' => elgg_echo('missions:december'),
);

$input_start_month = elgg_view('input/dropdown', array(
		'name' => 'start_month',
		'value' => $start_month,
		'options_values' => $month_values,
		'id' => 'missions-graph-interval-start-month-input'
));

$input_end_month = elgg_view('input/dropdown', array(
		'name' => 'end_month',
		'value' => $end_month,
		'options_values' => $month_values,
		'id' => 'missions-graph-interval-end-month-input'
));

$years = array();
$current_year = date('Y');
$count = 0;
for($i=$current_year;$i>=2000;$i--) {
	$years[$count] = $i;
	$count++;
}
$years = array_reverse($years);

$input_start_year = elgg_view('input/dropdown', array(
		'name' => 'start_year',
		'value' => $start_year,
		'options' => $years,
		'id' => 'missions-graph-interval-start-year-input'
));

$input_end_year = elgg_view('input/dropdown', array(
		'name' => 'end_year',
		'value' => $end_year,
		'options' => $years,
		'id' => 'missions-graph-interval-end-year-input'
));

$input_graph_type = elgg_view('input/dropdown', array(
		'name' => 'graph',
		'value' => $graph,
		'options_values' => array('bar' => elgg_echo('missions:bar_graph'), 'pie' => elgg_echo('missions:pie_graph')),
		'id' => 'missions-graph-interval-graph-type-input',
		'onchange' => 'graph_typing(this)'
));
?>

<div class="form-group" style="margin-left:0px;">
	<div style="display:inline-block;">
		<?php echo elgg_echo('missions:create_a'); ?>
	</div>
	<div style="display:inline-block;">
		<?php echo $input_graph_type; ?>
	</div>
	<div id="graph-time-interval-inputs" style="display:inline-block;">
		<div style="display:inline-block;">
			<?php echo elgg_echo('missions:with_time_period'); ?>
		</div>
		<div style="display:inline-block;">
			<?php echo $input_time_period; ?>
		</div>
		<div style="display:inline-block;">
			<?php echo elgg_echo('missions:since'); ?>
		</div>
		<div style="display:inline-block;">
			<?php echo $input_start_month; ?>
		</div>
		<div style="display:inline-block;">
			<?php echo $input_start_year; ?>
		</div>
		<div style="display:inline-block;">
			<?php echo elgg_echo('missions:to'); ?>
		</div>
		<div style="display:inline-block;">
			<?php echo $input_end_month; ?>
		</div>
		<div style="display:inline-block;">
			<?php echo $input_end_year; ?>
		</div>
	</div>
</div>
<div style="min-height:150px;">
	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:graph'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'missions-graph-interval-form-submission-button'
		));
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'missions-graph-interval-form-submission-button'));
	?>
</div>

<script>
function graph_typing(input) {
	var value = input.value;
	var division = document.getElementById('graph-time-interval-inputs');
	if(value == 'pie') {
		division.style.display = 'none';
	}
	else {
		division.style.display = 'inline-block';
	}
}
</script>
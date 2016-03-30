<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

// Uses the google charts API.
elgg_load_js('googlecharts');

$names = $vars['mission_department_name_array'];
$department_results = $vars['mission_graph_result_array'];
$state_count = $vars['state_number'];

$subtitle_count = count($department_results) - 1;

// For when the graph has no data passed to it.
if($vars['dummy_graph']) {
	$dummy_array = array();
	for($i=0;$i<$interval_number;$i++) {
		for($k=0;$k<$state_count;$k++) {
			$dummy_array[$i][$k] = 0;
		}
	}
	
	for($k=0;$k<$state_count;$k++) {
		$names[$k+1] = '';
	}
	
	$department_results[1] = $dummy_array;
}

$department_count = count($department_results) - 1;
$interval_number = count($department_results[0]);

// This converts the data from the search into the format google charts requires.
$formatted_result_array = array();
$max_value = 0;
$it_count = 0;
for($i=0;$i<$interval_number;$i++) {
	$temp_format_array = array();
	$temp_format_array[0] = $department_results[0][$i];
	for($j=0;$j<$department_count;$j++) {
		$temp_max = 0;
		for($k=0;$k<$state_count;$k++) {
			$temp_format_array[$state_count*$j+$k+1] = $department_results[$j+1][$i][$k];
			$temp_max += $department_results[$j+1][$i][$k];
			$it_count++;
		}
		if($temp_max > $max_value) {
			$max_value = $temp_max;
		}
	}
	$formatted_result_array[$i] = $temp_format_array;
}

// If the max value in the y-axis is 0 then it defaults to 1.
if($max_value == 0) {
	$max_value = 1;
}

$title = elgg_echo('missions:micro_mission_analytics');

$subtitle = $subtitle_count . ' ' . strtolower(elgg_echo('missions:department'));
$legend_display = 'right';
if($subtitle_count != 1) {
	$subtitle = $subtitle . 's';
}
if($subtitle_count == 0) {
	$legend_display = 'none';
}

// Button to download the chart as an image.
$save_as_image_button = elgg_view('page/elements/save-chart-as-image-button');
?>

<div id="my_chart" style="overflow-x:scroll;"></div>
<?php echo $save_as_image_button; ?>

<script>
google.charts.load('43', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	var data = new google.visualization.DataTable();

	// Creates the different data categories (1 per state/department combination).
	var columns = <?php echo json_encode($names); ?>;
	data.addColumn('string', columns[0]);
	for(i=1;i<columns.length;i++) {
		data.addColumn('number', columns[i]);
	}

	// Adds all the previously formatted data to the columns.
	var result_array = <?php echo json_encode($formatted_result_array); ?>;
	data.addRows(result_array);

	var department_count = <?php echo $department_count; ?>;
	var state_count = <?php echo $state_count; ?>;
	var max_value = <?php echo $max_value; ?>;

	// Groups up all department states into one stacked bar and fixes up the y-axis and some formatting.
	var series_object = {};
	var vaxes_object = {};
	vaxes_object[0] = {viewWindowMode: 'explicit', viewWindow: {max: max_value}}
	for(i=1;i<department_count;i++) {
		// Group up all of the department's states.
		for(j=0;j<state_count;j++) {
			series_object[state_count*i+j] = {targetAxisIndex: i};
		}
		vaxes_object[i] = {textStyle: {color: 'white'}, gridlines: {color: 'transparent'}, viewWindowMode: 'explicit', viewWindow: {max: max_value}};
	}

	// Chart options.
	var options = {
		isStacked: true,
		width: data.getNumberOfRows() * 100 + 150,
		height: 600,
		chart: {
			title: <?php echo json_encode($title); ?>,
			subtitle: <?php echo json_encode($subtitle); ?>
		},
		series: series_object,
		vAxes: vaxes_object,
		legend: {position: <?php echo json_encode($legend_display); ?>}
	};

	// Creates the chart in the div 'my_chart'.
	var chart = new google.charts.Bar(document.getElementById('my_chart'));
	chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>
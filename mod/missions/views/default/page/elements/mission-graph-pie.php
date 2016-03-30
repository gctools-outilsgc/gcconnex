<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
elgg_load_js('googlecharts');

$department_names = $vars['mission_department_name_array'];
$department_results = $vars['mission_graph_result_array'];
$state_array = $vars['state_array'];
$is_dummy = $vars['dummy_graph'];

// For when the graph has no data passed to it.
if($is_dummy) {
	$dummy_array = array();
	for($j=0;$j<count($state_array);$j++) {
		$department_names[$j+1] = $state_array[$j];
		for($i=0;$i<count($department_results[0]);$i++) {
			$dummy_array[$i][$j] = 0;
		}
	}
	$department_results[1] = $dummy_array;
}

// Converts the search results into a data table that can be read by the pie chart.
$data_table = array(array('States', 'Number of Missions'));
for($j=0;$j<count($state_array);$j++) {
	$temp_array = array($department_names[$j+1], 0);
	for($i=0;$i<count($department_results[0]);$i++) {
		$temp_array[1] += $department_results[1][$i][$j];
	}
	$data_table[$j+1] = $temp_array;
}

$abbr = explode(' ', $department_names[1])[0];
/*$first_date = explode("\n", $department_results[0][0])[0];
$last_date = explode("\n",  $department_results[0][count($department_results[0])-1])[2];
$date_range = $first_date . elgg_echo('missions:to') . $last_date;

if($is_dummy) {
	$title = elgg_echo('missions:for_dates') . ' ' . $date_range;
}
else {
	$title = $abbr . ' ' . elgg_echo('missions:for_dates') . ' ' . $date_range;
}*/
if($is_dummy) {
	$title = elgg_echo('missions:empty');
}
else {
	$title = $abbr;
}

// Download the pie chart as an image.
$save_as_image_button = elgg_view('page/elements/save-chart-as-image-button');
?>

<div id="my_chart"></div>
<?php echo $save_as_image_button; ?>

<script>
google.charts.load('43', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	// Turns the formatted array into a data table.
	var data = google.visualization.arrayToDataTable(<?php echo json_encode($data_table); ?>);

	// Chart options.
	var options = {
			title: <?php echo json_encode($title); ?>,
			width: 600,
			height: 400,
			sliceVisibilityThreshold: 0,
			colors: ['#047177', '#05A3AC', '#07D4DF']
	};

	// Creates the chart in the div 'my_chart'.
	var chart = new google.visualization.PieChart(document.getElementById('my_chart'));
	chart.draw(data, options);
}
</script>
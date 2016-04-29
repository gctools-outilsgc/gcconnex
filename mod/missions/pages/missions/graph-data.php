<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$graph_type = mm_clean_url_segment(array_pop($blast_radius));

$state_array = array('Posted', 'Completed', 'Cancelled');

$series_limit = '';
if($graph_type == 'pie') {
	$series_limit = 1;
}
else {
	$series_limit = 5;
}

$date_array = $_SESSION['mission_graph_date_array'];
$data_array = $_SESSION['mission_graph_data_array'];
$name_array = $_SESSION['mission_graph_name_array'];

if($name_array == '') {
	$_SESSION['mission_graph_name_array'] = array('Date');
	$name_array = $_SESSION['mission_graph_name_array'];
}

if($data_array == '') {
	$x_axis_labels = array();
	for($i=0;$i<count($date_array);$i++) {
		$temp_start = date('M,Y', strtotime($date_array[$i][0]));
		$temp_end = date('M,Y', strtotime($date_array[$i][1]));
		if($temp_start == $temp_end) {
			$x_axis_labels[$i] = $temp_start;
		}
		else {
			$x_axis_labels[$i] = $temp_start . "\n" . elgg_echo('missions:to') . "\n" . $temp_end;
		}
	}
	$_SESSION['mission_graph_data_array'] = array($x_axis_labels);
	$data_array = $_SESSION['mission_graph_data_array'];
}

$title = elgg_echo('missions:graph_data');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb(elgg_echo('missions:graph_interval'), elgg_get_site_url() . 'missions/graph-interval');
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs', array(
		'highlight_five' => true
));

if((count($data_array)-1) < $series_limit) {
	$content .= elgg_view_form('missions/graph-data-form', array(
			'class' => 'form-horizontal'
	), array(
			'state_array' => $state_array
	)) . '<br>';
}

$is_dummy_graph = false;
if(count($data_array) == 1) {
	$is_dummy_graph = true;
}

if($graph_type == 'pie') {
	$content .= elgg_view('page/elements/mission-graph-pie', array(
			'mission_department_name_array' => $name_array,
			'mission_graph_result_array' => $data_array,
			'state_array' => $state_array,
			'dummy_graph' => $is_dummy_graph
	)) . '<br><br>';
}
else {
	$content .= elgg_view('page/elements/mission-graph-bar', array(
			'mission_department_name_array' => $name_array,
			'mission_graph_result_array' => $data_array,
			'state_number' => count($state_array),
			'dummy_graph' => $is_dummy_graph
	)) . '<br><br>';
}

for($i=1;$i<count($data_array);$i++) {
	$content .= '<div>';
	
	$abbr = explode(' ', $name_array[count($state_array) * $i])[0];
	$content .= '<div id="remove-from-graph-button-department-' . $i . '" style="display:inline-block;">' . elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/missions/remove-department-from-graph?dep_pos=' . $i . '&state_num=' . count($state_array),
			'text' => elgg_echo('missions:remove') . ' ' . $abbr,
		    'is_action' => true,
			'class' => 'elgg-button btn btn-danger',
			'confirm' => elgg_echo('missions:confirm:remove_department')
	)) . '</div>';
	
	/*$content .= '<div id="pie-graph-button-department-' . $i . '" style="display:inline-block;">' . elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'missions/graph-department-pie/' . $i,
			'text' => elgg_echo('missions:pie_graph_for') . ' ' . $abbr,
			'class' => 'elgg-button btn btn-default'
	)) . '</div>';*/
	
	$content .= '</div>';
}

echo elgg_view_page($title, $content);
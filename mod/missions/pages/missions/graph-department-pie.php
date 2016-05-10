<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

gatekeeper();

if(elgg_get_logged_in_user_entity()->opt_in_missions != 'gcconnex_profile:opt:yes') {
	forward(elgg_get_site_url() . 'missions/main');
}

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$department_index = mm_clean_url_segment(array_pop($blast_radius));

$date_array = $_SESSION['mission_graph_date_array'];
$data_array = $_SESSION['mission_graph_data_array'];
$name_array = $_SESSION['mission_graph_name_array'];

$temp_date = strtotime('+1 Day', strtotime($date_array[0]));
$temp_date = date('Y-m-d', $temp_date);
$date_range = $temp_date . elgg_echo('missions:to') . array_pop($date_array);

$results = $data_array[$department_index];

$state_number = count($results[0]);
$states = array();
for($i=0;$i<$state_number;$i++) {
	$states[$i] = $name_array[$department_index * $state_number - $i];
}
$states = array_reverse($states);

$title = elgg_echo('missions:department_pie');
$content = elgg_view_title($title);
	
$content .= elgg_view('page/elements/mission-tabs', array(
		'highlight_five' => true
));

$content .= elgg_view('page/elements/department-pie-graph', array(
		'department_results' => $results,
		'department_states' => $states,
		'date_range' => $date_range
)) . '<br><br>';

echo elgg_view_page($title, $content);
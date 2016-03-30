<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Searches for mission data over a certain time period.
 * This search is always according to mission start dates.
 */
$start_time = time();

elgg_make_sticky_form('graphdatafill');
$data_form = elgg_get_sticky_values('graphdatafill');

$department_string = mo_get_last_input_node($data_form);
$state_array = $data_form['hidden_state_array'];
$state_array = explode(',', $state_array);

// Creates an array of the department and all of its children.
$department_and_children_array = mo_array_node_and_all_children($department_string);

// If the department string exists.
if($department_string) {
	// Gets the abbreviation of the targeted department in the user's current language.
	$abbr_metaname = '';
	if(get_current_language() == 'en') {
		$node_abbr = get_entity(mo_extract_node_guid($department_string))->abbr;
		$abbr_metaname = 'abbr';
	}
	else if(get_current_language() == 'fr') {
		$node_abbr = get_entity(mo_extract_node_guid($department_string))->abbr_french;
		$abbr_metaname = 'abbr_french';
	}
	
	// Gets the previously stored search data to append to it.
	$date_array = $_SESSION['mission_graph_date_array'];
	$data_array = $_SESSION['mission_graph_data_array'];
	$name_array = $_SESSION['mission_graph_name_array'];
	
	// 
	$result_array = array();
	for($i=0;$i<count($date_array);$i++) {
		//$date_range_array[$i] = $date_array[$i] . "\n" . elgg_echo('missions:to') . "\n" . $date_array[$i+1];
		$interval_array = array();
		foreach($state_array as $state) {
			// The state value being searched.
			$state_value = strtolower($state);
			
			$options['type'] = 'object';
			$options['subtype'] = 'mission';
			$options['metadata_case_sensitive'] = false;
			$options['limit'] = 0;
			$options['count'] = true;
			
			$missions_total = 0;
			// Iterates through the targeted department and all its children and summing the missions found.
			foreach($department_and_children_array as $temp_string) {
				$options['metadata_name_value_pairs'] = array(
						array('name' => 'department', 'value' => $temp_string, 'operand' => 'LIKE'),
						array('name' => 'state', 'value' => $state_value)
				);
				
				// Searches for missions with a start date between these two dates.
				// OVERRIDE causes the search to disregard the dates as search factors.
				if($date_array[$i][0] != 'OVERRIDE') {
					$options['metadata_name_value_pairs'][count($options['metadata_name_value_pairs'])] = array('name' => 'start_date', 'value' => $date_array[$i][0], 'operand' => '>=');
				}
				
				if($date_array[$i][1] != 'OVERRIDE') {
					$options['metadata_name_value_pairs'][count($options['metadata_name_value_pairs'])] = array('name' => 'start_date', 'value' => $date_array[$i][1], 'operand' => '<=');
				}
				
				$missions_total += elgg_get_entities_from_metadata($options);
			}
			
			$count = count($interval_array);
			$interval_array[$count] = $missions_total;
		}
		
		$count = count($result_array);
		$result_array[$count] = $interval_array;
	}
	
	$count = count($data_array);
	$data_array[$count] = $result_array;
	
	// Names each department state.
	foreach($state_array as $state) {
		$count = count($name_array);
		$name_array[$count] = $node_abbr . ' ' . $state;
	}
	
	$_SESSION['mission_graph_data_array'] = $data_array;
	$_SESSION['mission_graph_name_array'] = $name_array;
	
	elgg_clear_sticky_form('graphdatafill');
}
else {
	register_error(elgg_echo('missions:error:department_needs_input'));
}

$_SESSION['mission_graph_operation_time'] = time() - $start_time;

forward(REFERER);
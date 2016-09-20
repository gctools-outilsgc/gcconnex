<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Validate date inputs which allow yyyy, yyyy-mm, or yyyy-mm-dd entries.
 * yyyy must be sometime in the 1900's or 2000's.
 * mm must be 1 to 12.
 * dd must be 1 to 31.
 */
function mm_analytics_validate_date_for_time_scale($date) {
	//$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012]|Q[1234])(-(0?[1-9]|[12][0-9]|3[01]|W[12345]))?)?$/";
	//$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012]|Q[1234])(-(0?[1-9]|[12][0-9]|3[01]))?)?$/";
	$regex = "/^((19|20)\d\d)(-(0?[1-9]|1[012])(-(0?[1-9]|[12][0-9]|3[01]))?)?$/";
	return preg_match($regex, $date);
}

/*
 * Function which takes a start date and end date and generates an array of timestamps starting at 00:00 on the start date and ending at 23:59 on the end date.
 * The time between timestamps is determined by the interval which can be year, fiscal year, quarter, month, week, or day.
 * The end date given is always the last element of the array (which overrides the interval spacing).
 */
function mm_analytics_generate_time_scale_timestamps($beginning_date, $end_date, $interval) {
	// Validates the dates using the regex found in mm_analytics_validate_date_for_time_scale.
	if(!mm_analytics_validate_date_for_time_scale($beginning_date) || !mm_analytics_validate_date_for_time_scale($end_date)) {
		return false;
	}
	
	$original_timezone = date_default_timezone_get();
	// Needed to ensure that date's start at 00:00.
	date_default_timezone_set('Etc/GMT+0');
	
	$beginning_array = explode('-', $beginning_date);
	$end_array = explode('-', $end_date);
	
	// If the month is set as Qx, then it is translated to a integer value corresponding to the beginning of the quarter.
	/*if(strtolower(substr($beginning_array[1], 0, 1)) == 'q') {
		$beginning_array[1] = (3 * intval(substr($beginning_array[1], 1, 1))) + 1;
		if($beginning_array[1] == 13) {
			$beginning_array[1] = 1;
			$beginning_array[0] = date('Y', strtotime('+1 year', strtotime($beginning_array[0] . '-01')));
		}
	}
	
	if(strtolower(substr($end_array[1], 0, 1)) == 'q') {
		$end_array[1] = (3 * intval(substr($end_array[1], 1, 1))) + 1;
		if($end_array[1] == 13) {
			$end_array[1] = 1;
			$end_array[0] = date('Y', strtotime('+1 year', strtotime($end_array[0] . '-01')));
		}
		$end_array[1] = $end_array[1] + 2;
	}*/
	
	// Decides on the beginning date for the time range .
	switch($interval) {
		// Years always start on 01-01.
		case 'missions:year':
			$step = '+1 year';
			$beginning = strtotime($beginning_array[0] . '-01-01');
			break;
		// Fiscal years always start on 04-01. If the month value is after the year start but before the fiscal year start then it is the previous fiscal year.
		case 'missions:fiscal_year':
			$step = '+1 year';
			$beginning = strtotime($beginning_array[0] . '-04-01');
			if($beginning_array[1] != '') {
				if(intval($beginning_array[1]) <  4) {
					$beginning = strtotime('-1 year', $beginning);
				}
			}
			break;
		// Quarters always start on the day 01 of the months 01, 04, 07, or 10.
		case 'missions:quarter':
			$step = '+3 months';
			$beginning = strtotime($beginning_array[0] . '-04-01');
			if($beginning_array[1] != '') {
				$month_int = intval($beginning_array[1]);
				if($month_int >= 1 && $month_int <= 3) {
					$beginning = strtotime($beginning_array[0] . '-01-01');
				}
				else if($month_int >= 4 && $month_int <= 6) {
					$beginning = strtotime($beginning_array[0] . '-04-01');
				}
				else if($month_int >= 7 && $month_int <= 9) {
					$beginning = strtotime($beginning_array[0] . '-07-01');
				}
				else if($month_int >= 10 && $month_int <= 12) {
					$beginning = strtotime($beginning_array[0] . '-10-01');
				}
			}
			break;
		// Months always start on the day 01.
		case 'missions:month':
			$step = '+1 month';
			$beginning = strtotime($beginning_array[0] . '-01-01');
			if($beginning_array[1] != '') {
				$beginning = strtotime($beginning_array[0] . '-' . $beginning_array[1] . '-01');
			}
			break;
		// Weeks always start on a Monday.
		case 'missions:week':
			$step = '+1 week';
			$beginning = strtotime('this week', strtotime($beginning_array[0] . '-01-01'));
			if($beginning_array[1] != '') {
				$beginning = strtotime('this week', strtotime($beginning_array[0] . '-' .  $beginning_array[1] . '-01'));
				if($beginning_array[2] != '') {
					$beginning = strtotime('this week', strtotime(implode('-', $beginning_array)));
				}
			}
			break;
		// Days correspond to the granularity of the date inputs.
		case 'missions:day':
			$step = '+1 day';
			$beginning = strtotime($beginning_array[0] . '-01-01');
			if($beginning_array[1] != '') {
				$beginning = strtotime($beginning_array[0] . '-' . $beginning_array[1] . '-01');
				if($beginning_array[2] != '') {
					$beginning = strtotime(implode('-', $beginning_array));
				}
			}
			break;
		default:
			return false;
	}
	
	// Sets the end date to end of year.
	$end = strtotime($end_array[0] . '-12-31');
	// If the end date has a month set then the end date is set to the end of that month.
	if($end_array[1] != '') {
		$end = strtotime(date('Y-m-t', strtotime($end_array[0] . '-' . $end_array[1])));
		// If the end date has a day set then the end date is set to that day.
		if($end_array[2] != '') {
			$end = strtotime(implode('-', $end_array));
		}
	}
	
	// Creates steps in the interval until a step exceeds the end date and the end date replaces that last step.
	$returner_array = array($beginning);
	while(true) {
		$new_index = count($returner_array);
		$latest_time = strtotime($step, $returner_array[$new_index - 1]);
		$returner_array[$new_index] = $latest_time;
		if($latest_time > $end) {
			$end_array = explode('-', date('m-d-Y', $end));
			// Sets the end date to the end of that day.
			$returner_array[$new_index] = mktime(23,59,59,$end_array[0],$end_array[1],$end_array[2]);
			break;
		}
	}
	
	date_default_timezone_set($original_timezone);
	
	return $returner_array;
}

/*
 * Function which creates a string composed of days, hours, minutes, and seconds if their values are not 0.
 * Currently not in use anywhere.
 */
function mm_analytics_string_together_time_segments($days, $hours, $minutes, $seconds) {
	$returner = '';
	if($days != 0) {
		$plural = 's';
		if($days == 1) {
			$plural = '';
		}
		$returner .= elgg_echo('missions:day(s)', array($days, $plural)) . ' ';
	}
	if($hours != 0) {
		$plural = 's';
		if($hours == 1) {
			$plural = '';
		}
		$returner .= elgg_echo('missions:hour(s)', array($hours, $plural)) . ' ';
	}
	if($minutes != 0) {
		$plural = 's';
		if($minutes == 1) {
			$plural = '';
		}
		$returner .= elgg_echo('missions:minute(s)', array($minutes, $plural)) . ' ';
	}
	if($seconds != 0) {
		$plural = 's';
		if($seconds == 1) {
			$plural = '';
		}
		$returner .= elgg_echo('missions:second(s)', array($seconds, $plural)) . ' ';
	}
	return $returner;
}

/*
 * Creates labels for the graph's x-axis.
 */
function mm_analytics_generate_bin_labels($timescale_array, $case_value, $graph_type) {
	$timescale_labels = $timescale_array;
	
	if($graph_type == 'missions:stacked_graph') {
		array_pop($timescale_labels);
	}
	
	foreach($timescale_labels as $key => $time) {
		switch($case_value) {
			case 'missions:year':
				$timescale_labels[$key] = date('Y', $time);
				break;
			case 'missions:fiscal_year':
				$timescale_labels[$key] = 'FY: ' . date('Y', $time);
				break;
			case 'missions:quarter':
				$q_num = ceil(intval(date('m', $time)) / 3) - 1;
				$year = date('Y', $time);
				if($q_num == 0) {
					$q_num = 4;
					$year = date('Y', strtotime('-1 year', $time));
				}
				$timescale_labels[$key] = 'Q' . $q_num . ', ' . $year;
				break;
			case 'missions:month':
				$timescale_labels[$key] = date('M, Y', $time);
				break;
			case 'missions:week':
				$timescale_labels[$key] = 'W' . date('W, Y', $time);
				break;
			case 'missions:day':
				$timescale_labels[$key] = date('Y-m-d', $time);
				break;
			case 'missions:hours_total':
			case 'missions:hours_per_day':
			case 'missions:hours_per_week':
			case 'missions:hours_per_month':
				$timescale_labels[$key] = $time . ' ' . elgg_echo('missions:hours');
				break;
			case 'missions:time_to_post_mission':
			case 'missions:time_to_fill_mission':
			case 'missions:time_to_complete_mission':
			case 'missions:time_to_cancel_mission':
				$plural = 's';
				if($time == 1) {
					$plural = '';
				}
				
				switch($_SESSION['missions_analytics_histogram_time_unit_for_axis']) {
					case 'DAY':
						$timescale_labels[$key] = elgg_echo('missions:day(s)', array(($time / 86400), $plural));
						break;
					case 'HOUR':
						$timescale_labels[$key] = elgg_echo('missions:hour(s)', array(($time / 3600), $plural));
						break;
					case 'MINUTE':
						$timescale_labels[$key] = elgg_echo('missions:minute(s)', array(($time / 60), $plural));
						break;
					case 'SECOND':
						$timescale_labels[$key] = elgg_echo('missions:second(s)', array($time, $plural));
						break;
				}
				
				break;
		}
	}
	
	return $timescale_labels;
}

/*
 * If user is targetting start date then timestamps are transformed back to date format.
 */
function mm_analytics_transform_to_date_format($start, $end, $type) {
	$returner = array($start, $end);
	if($type == 'missions:start_date') {
		$returner[0] = date('Y-m-d', $start);
		$returner[1] = date('Y-m-d', $end);
	}
	return $returner;
}

/*
 * Gets all the missions in between the start and end dates according to the date they were posted, their ideal start date, or the date they were completed or cancelled.
 */
function mm_analytics_get_missions_by_dates($start_date, $end_date, $date_type) {
	// Modifies the function attributes so that it knows the name of the metadata it's targetting and matches the time metadata format (date or timestamp).
	$modified_input = mm_analytics_transform_to_date_format($start_date, $end_date, $date_type);
	$start = $modified_input[0];
	$end = $modified_input[1];
	$metadata = mm_analytics_get_metadata_name_from_target_value($date_type);
	
	if($metadata == '') {
		return false;
	}
	
	$options['type'] = 'object';
	$options['subtype'] = 'mission';
	$options['limit'] = 0;
	
	// Time created is an attribute of the entity table in the database and not metadata.
	if($metadata == 'time_created') {
		$options['created_time_lower'] = $start;
		$options['created_time_upper'] = $end;
		
		$missions = elgg_get_entities($options);
	}
	else {
		$options['metadata_name_value_pairs'] = array(
				array('name' => $metadata, 'value' => $start, 'operand' => '>='),
				array('name' => $metadata, 'value' => $end, 'operand' => '<=')
		);
		$options['metadata_name_value_pairs_operator'] = 'AND';
		
		$missions = elgg_get_entities_from_metadata($options);
	}
	
	return $missions;
}

function mm_analytics_get_declinations_by_dates($start_date, $end_date) {
	$options['type'] = 'object';
	$options['subtype'] = 'mission-declination';
	$options['limit'] = 0;
	$options['created_time_lower'] = $start_date;
	$options['created_time_upper'] = $end_date;
	
	return elgg_get_entities($options);
}

function mm_analytics_get_missions_by_posting_and_closure($start_date, $end_date) {
	$options['type'] = 'object';
	$options['subtype'] = 'mission';
	$options['limit'] = 0;
	$options['created_time_upper'] = $end_date;
	$options['metadata_name_value_pairs'] = array(array(
			'name' => 'time_closed', 'operand' => '>=', 'value' => $start_date,
			'name' => 'time_closed', 'operand' => '=', 'value' => null
	));
	$options['metadata_name_value_pairs_operator'] = 'OR';
	
	return elgg_get_entities_from_metadata($options);
}

/*
 * Removes all missions from the set which are not a part of the given department or that departments children.
 */
function mm_analytics_cull_missions_by_department($mission_set, $department) {
	$department_and_children = mo_array_node_and_all_children($department);
	$mission_set_copy = $mission_set;
	foreach($mission_set_copy as $key => $mission) {
		if(!in_array($mission->department, $department_and_children)) {
			unset($mission_set_copy[$key]);
		}
	}
	
	return $mission_set_copy;
}

/*
 * Separates the missions into different series according to the given value.
 */
function mm_analytics_separate_missions_by_values($mission_set, $separator) {
	$returner_array = array();
	if($separator == '' || $separator == 'missions:average_number_of_applicants') {
		$returner_array[0] = $mission_set;
	}
	else {
		// Creates the array of values which determine which bin a mission will occupy and the metadata where these values are stored..
		switch($separator) {
			case 'missions:state':
				$meta_tag = 'state';
				$comparison_array = array('posted', 'cancelled', 'completed');
				break;
			case 'missions:reliability':
				$meta_tag = 'security';
				$comparison_array = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
				break;
			case 'missions:virtual_opportunity':
				$meta_tag = 'remotely';
				$comparison_array = array('on', false);
				break;
			case 'missions:limited_by_department':
				$meta_tag = 'openess';
				$comparison_array = array('on', false);
				break;
			case 'missions:type':
				$meta_tag = 'job_type';
				$comparison_array = explode(',', elgg_get_plugin_setting('opportunity_type_string', 'missions'));
				break;
			case 'missions:reason_to_decline':
				$meta_tag = 'applicant_reason';
				$comparison_array = explode(',', elgg_get_plugin_setting('decline_reason_string', 'missions'));
				break;
			case 'missions:location':
				$meta_tag = 'location';
				$comparison_array = explode(',', elgg_get_plugin_setting('province_string', 'missions'));
				break;
			case 'missions:field_of_work':
				$meta_tag = 'program_area';
				$comparison_array = explode(',', elgg_get_plugin_setting('program_area_string', 'missions'));
				break;
		}
		
		// Creates the bins which the missions will be divided into.
		$count = 0;
		foreach($comparison_array as $comparator) {
			$returner_array[$count] = array();
			$count++;
		}

		// Divides the missions into the bins according to what value their metadata matches.
		foreach($mission_set as $mission) {
			$count = 0;
			foreach($comparison_array as $comparator) {
				if($mission->$meta_tag == $comparison_array[$count]) {
					$returner_array[$count][] = $mission;
				}
				$count++;
			}
		}
	}
	
	return $returner_array;
}

/*
 * Creates labels for the different series.
 */
function mm_analytics_generate_separation_labels($separator) {
	$returner = array();
	switch($separator) {
		case 'missions:state':
			$returner = array('missions:posted', 'missions:cancelled', 'missions:completed');
			break;
		case 'missions:reliability':
			$returner = explode(',', elgg_get_plugin_setting('security_string', 'missions'));
			$returner[0] = 'missions:not_declared';
			break;
		case 'missions:virtual_opportunity':
			$returner = array('missions:virtual_opportunity', 'missions:not_virtual_opportunity');
			break;
		case 'missions:limited_by_department':
			$returner = array('missions:limited_by_department', 'missions:not_limited_by_department');
			break;
		case 'missions:type':
			$returner = explode(',', elgg_get_plugin_setting('opportunity_type_string', 'missions'));
			break;
		case 'missions:reason_to_decline':
			$returner = explode(',', elgg_get_plugin_setting('decline_reason_string', 'missions'));
			break;
		case 'missions:location':
			$returner = explode(',', elgg_get_plugin_setting('province_string', 'missions'));
			break;
		case 'missions:field_of_work':
			$returner = explode(',', elgg_get_plugin_setting('program_area_string', 'missions'));
			break;
		default:
			$returner = array('missions:all_opportunities');
	}
	return $returner;
}

/*
 * Separates the missions into their respective bins.
 */
function mm_analytics_separate_sets_into_bins($mission_set, $timescale_array, $target_lower, $target_upper, $graph_type) {
	$metadata_lower = mm_analytics_get_metadata_name_from_target_value($target_lower);
	$metadata_upper = mm_analytics_get_metadata_name_from_target_value($metadata_upper);
	
	// Creates a set of bins corresponding to the intervals.
	$returner = array();
	$temp_x_array = array();
	for($i=0;$i<(count($timescale_array)-1);$i++) {
		$temp_x_array[] = array();
	}
	
	// Adds an interval bin to each of the series bins.
	foreach($mission_set as $value) {
		$returner[] = $temp_x_array;
	}
	
	foreach($mission_set as $y => $set) {
		foreach($set as $mission) {
			for($i=0;$i<(count($timescale_array)-1);$i++) {
				$lower_bound = $timescale_array[$i];
				$upper_bound = $timescale_array[$i+1];
				
				if($graph_type == 'missions:stacked_graph') {
					$modified_data_by_type = mm_analytics_transform_to_date_format($timescale_array[$i], $timescale_array[$i+1], $target);
					$lower_bound = $modified_data_by_type[0];
					$upper_bound = $modified_data_by_type[1];
				}
				
				if(($mission->$metadata_lower >= $lower_bound || $mission->$metadata_lower == null) && $mission->$metadata_upper < $upper_bound) {
					$returner[$y][$i][] = $mission;
				}
			}
		}
	}
	
	return $returner;
}

/*
 * Gets a set of missions according to the user given value (this is for the histogram).
 */
function mm_analytics_get_missions_by_value($target_value) {
	$mission_set = array();
	
	$options['type'] = 'object';
	$options['subtype'] = 'mission';
	$options['limit'] = 0;
	$options['metadata_name_value_pairs_operator'] = 'AND';
	
	switch($target_value) {
		// The first four cases deal with timestamps describing an elapsed period of time.
		case 'missions:time_to_post_mission':
			$options['metadata_name_value_pairs'] = array(array('name' => 'time_to_post', 'value' => 0, 'operand' => '>'));
			break;
		case 'missions:time_to_fill_mission':
			$options['metadata_name_value_pairs'] = array(array('name' => 'time_to_fill', 'value' => 0, 'operand' => '>'));
			break;
		case 'missions:time_to_complete_mission':
			$options['metadata_name_value_pairs'] = array(array('name' => 'time_to_complete', 'value' => 0, 'operand' => '>'));
			break;
		case 'missions:time_to_cancel_mission':
			$options['metadata_name_value_pairs'] = array(array('name' => 'time_to_cancel', 'value' => 0, 'operand' => '>'));
			break;
			
		// The last four cases deal with time commitments and time intervals of which the intervals are targeted by the user.
		case 'missions:hours_total':
			$options['metadata_name_value_pairs'] = array(
					array('name' => 'time_commitment', 'value' => 0, 'operand' => '>'),
					array('name' => 'time_interval', 'value' => 'missions:total', 'operand' => '=')
			);
			break;
		case 'missions:hours_per_day':
			$options['metadata_name_value_pairs'] = array(
					array('name' => 'time_commitment', 'value' => 0, 'operand' => '>'),
					array('name' => 'time_interval', 'value' => 'missions:per_day', 'operand' => '=')
			);
			break;
		case 'missions:hours_per_week':
			$options['metadata_name_value_pairs'] = array(
					array('name' => 'time_commitment', 'value' => 0, 'operand' => '>'),
					array('name' => 'time_interval', 'value' => 'missions:per_week', 'operand' => '=')
			);
			break;
		case 'missions:hours_per_month':
			$options['metadata_name_value_pairs'] = array(
					array('name' => 'time_commitment', 'value' => 0, 'operand' => '>'),
					array('name' => 'time_interval', 'value' => 'missions:per_month', 'operand' => '=')
			);
			break;
			
		default:
			$options['metadata_name_value_pairs'] = 'INVALID_TARGET';
	}
	
	if($options['metadata_name_value_pairs'] != 'INVALID_TARGET') {
		$mission_set = elgg_get_entities_from_metadata($options);
	}
	return $mission_set;
}

/*
 * Returns the metadata name according to the user given value.
 */
function mm_analytics_get_metadata_name_from_target_value($target_value) {
	$metadata = '';
	
	switch($target_value) {
		case 'missions:date_posted':
			$metadata = 'time_created';
			break;
		case 'missions:start_date':
			$metadata = 'start_date';
			break;
		case 'missions:closure_date':
			$metadata = 'time_closed';
			break;
		case 'missions:time_to_post_mission':
			$metadata = 'time_to_post';
			break;
		case 'missions:time_to_fill_mission':
			$metadata = 'time_to_fill';
			break;
		case 'missions:time_to_complete_mission':
			$metadata = 'time_to_complete';
			break;
		case 'missions:time_to_cancel_mission':
			$metadata = 'time_to_cancel';
			break;
		case 'missions:hours_total':
		case 'missions:hours_per_day':
		case 'missions:hours_per_week':
		case 'missions:hours_per_month':
			$metadata = 'time_commitment';
			break;
		default:
			$metadata = 'time_created';
	}
	
	return $metadata;
}


/*
 * Creates the increments of the x-axis which also define the boundaries of each bin.
 */
function mm_analytics_generate_time_scale_bins($number_of_bins, $target_value, $mission_set) {
	$timescale_bins = array();
	$metadata = mm_analytics_get_metadata_name_from_target_value($target_value);
	
	$max_value = -1;
	$min_value = -1;
	// Find the maximum and minimum values of the mission set metadata which define the range.
	foreach($mission_set as $mission) {
		if($max_value == -1 || $mission->$metadata > $max_value) {
			$max_value = $mission->$metadata;
		}
		if($min_value == -1 || $mission->$metadata < $min_value) {
			$min_value = $mission->$metadata;
		}
	}
	if($max_value == $min_value) {
		$min_value = 0;
	}
	$max_value = $max_value + 1;
	
	if($max_value > 0 && $min_value >= 0) {
		$max_time = ceil($max_value / 86400);
		$min_time = floor($min_value / 86400);
		$return_to_timestamp = 86400;
		$_SESSION['missions_analytics_histogram_time_unit_for_axis'] = 'DAY';
		if(($max_time - $min_time) < $number_of_bins) {
			$max_time = ceil($max_value / 3600);
			$min_time = floor($min_value / 3600);
			$return_to_timestamp = 3600;
			$_SESSION['missions_analytics_histogram_time_unit_for_axis'] = 'HOUR';
			if(($max_time - $min_time) < $number_of_bins) {
				$max_time = ceil($max_value / 60);
				$min_time = floor($min_value / 60);
				$return_to_timestamp = 60;
				$_SESSION['missions_analytics_histogram_time_unit_for_axis'] = 'MINUTE';
				if(($max_time - $min_time) < $number_of_bins) {
					$max_time = ceil($max_value);
					$min_time = floor($min_value);
					$return_to_timestamp = 1;
					$_SESSION['missions_analytics_histogram_time_unit_for_axis'] = 'SECOND';
				}
			}
		}
		
		// Determines the increments of the range according to the user given number of bins.
		$bin_step = ceil(($max_time - $min_time) / $number_of_bins);
		$i = 0;
		$timescale_bins[$i] = $min_time;
		while($timescale_bins[$i] < $max_time) {
			$i++;
			$timescale_bins[$i] = (($i * $bin_step) + $min_time);
		}
		
		foreach($timescale_bins as $index => $time) {
			$timescale_bins[$index] = $time * $return_to_timestamp;
		}
	}
	
	return $timescale_bins;
}




/** 
 * Get the top n most requested skills in currently posted micromissions
 * @param int $n the number of skills to return, default: top 10 skills
 * @return array the top $n most requested skills
 */
function getTopSkills( $n = 10 ){

	$top_skills = array();		// the array which will be will be returned
	$all_skills = array();		// will contain all skills as keys with the ammount of time they occur as the value
	$dbprefix = elgg_get_config('dbprefix');

	// Prepare query - we're looking for all skills from currently posted micromissions for now.
	// Most of the analysis of the data (counting the skills, sorting) to get the top $n skills will happen afterwards in PHP.
	$query_string = 
	"SELECT msvs.string AS skill, count(*) AS num 
	/* filter - currently posted opportunities only */
	FROM {$dbprefix}metastrings msnp 
	LEFT JOIN {$dbprefix}metadata mdp ON msnp.id = mdp.name_id 
	LEFT JOIN {$dbprefix}metastrings msvp ON msvp.id = mdp.value_id 
	/* ensure we are only dealing with opportunities */
	LEFT JOIN {$dbprefix}entities e ON mdp.entity_guid = e.guid 
	LEFT JOIN {$dbprefix}entity_subtypes st ON e.subtype = st.id 
	/* now we can get the key required skills from each of these opportunities */
	LEFT JOIN {$dbprefix}metadata mds ON e.guid = mds.entity_guid 
	LEFT JOIN {$dbprefix}metastrings msns ON mds.name_id = msns.id 
	LEFT JOIN {$dbprefix}metastrings msvs ON mds.value_id = msvs.id 
	WHERE msnp.string = 'state' AND msvp.string = 'posted' AND st.subtype = 'mission' AND msns.string = 'key_skills' 
	GROUP BY skill HAVING skill <> ''";

	// now run the query
	$result = get_data($query_string);

	// Get an array of distinct skills with along with their occurance frequency
	foreach ( $result as $row ) {
		// allows handling of the cases where there are multiple skills
		$skill_array = explode( ',', $row->skill );
		foreach ( $skill_array as $skill ) {
			// clean up the string
			$skill_string = trim($skill);
			$all_skills[$skill_string] = $all_skills[$skill_string] + $row->num;		// add to occurance of this skill the number of opportunities that had this set of skills
		}
	}

	arsort($all_skills);		// sort by occurance frequency (stored in the array values)

	// Get top $n skills
	$i = 0;
	foreach ($all_skills as $key => $value) {
		$top_skills[$key] = $value;
		$i+=1;
		if ($i >= $n)
			break;
	}

	return $top_skills;
}
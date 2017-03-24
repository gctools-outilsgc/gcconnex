<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$graph_type = $vars['graph_type'];
$start_date = $vars['start_date'];
$end_date = $vars['end_date'];
$interval = $vars['interval'];
$target_date = $vars['target_mission_date'];
$department_guid = $vars['department_guid'];
$role_type = $vars['role_type'];
$job_type = $vars['job_type'];
$status = $vars['status'];
$separator = $vars['separator'];

$bin_number = $vars['bin_number'];
$target_value = $vars['target_value'];

$error_returner = '';
$min_tick_size = 1;
$time_format = false;

// Graph type needs to be set or nothing gets generated.
if($graph_type == '') {
	$error_returner = elgg_echo('missions:error:analytics:select_graph_type');
}
else {
	// Formats the department guid so it can be searched for in the database.
	if(elgg_entity_exists($department_guid)) {
		$department_identifier = 'MOrg:' . $department_guid;
	}

	$target = '';
	if($graph_type == 'missions:stacked_graph') {
		$target = $target_date;
		$time_interval = $interval;

		if($separator == 'missions:average_number_of_applicants' || $separator == 'missions:reason_to_decline') {
			$target = 'missions:date_posted';
		}

		// Sets start and end date to default if the user did not enter any dates.
		if($start_date == '') {
			$start_date = '2016-06-19';
		}
		if($end_date == '') {
			$end_date = date('Y-m-d', time());
		}

		// Creates an array of timestamps which will separate the missions.
		$timescale_array = mm_analytics_generate_time_scale_timestamps($start_date, $end_date, $interval);

		// Gets the set of missions between the start date and end date. The search checks against the user given target date.
		if($separator == 'missions:reason_to_decline') {
			$mission_set = mm_analytics_get_declinations_by_dates($timescale_array[0], $timescale_array[count($timescale_array) - 1]);
		}
		else if($separator == 'missions:average_number_of_applicants') {
			$mission_set = mm_analytics_get_missions_by_posting_and_closure($timescale_array[0], $timescale_array[count($timescale_array) - 1]);
		}
		else {
			$mission_set = mm_analytics_get_missions_by_dates($timescale_array[0], $timescale_array[count($timescale_array) - 1], $target);
		}

		// Removes the missions that are not within the department or that department's children.
		if($department_identifier != '' && $separator != 'missions:reason_to_decline') {
			$mission_set = mm_analytics_cull_missions_by_department($mission_set, $department_identifier);
		}

		if ($role_type != '') {
			$mission_set = mm_analytics_cull_missions_by_role_type($mission_set, $role_type);
		}

		if ($job_type != '') {
			$mission_set = mm_analytics_cull_missions_by_job_type($mission_set, $job_type);
		}

		if ($status != '') {
			$mission_set = mm_analytics_cull_missions_by_status($mission_set, $status);
		}

		// Separates the missions according to the user given separator into different series. These series are later stacked upon each other in the graph.
		$mission_set = mm_analytics_separate_missions_by_values($mission_set, $separator);

		// Some additional bar options which control bar width and the x-axis label alignment.
		switch ($time_interval) {
			case 'missions:year':
			case 'missions:fiscal_year':
				$bar_width = 365 * 24 * 60 * 60 * 900;
				$min_tick_size = [1, 'year'];
				break;

			case 'missions:quarter':
				$bar_width = 91.25 * 24 * 60 * 60 * 900;
				$min_tick_size = [3, 'month'];
				$time_format = 'Q%q %Y';
				break;

			case 'missions:month':
				$bar_width = 30 * 24 * 60 * 60 * 900;
				$min_tick_size = [1, 'month'];
				break;

			case 'missions:week':
				$bar_width = 7 * 24 * 60 * 60 * 900;
				$min_tick_size = [7, 'day'];
				break;

			case 'missions:day':
				$bar_width = 1 * 24 * 60 * 60 * 900;
				$min_tick_size = [1, 'day'];
				break;

			default:
				$bar_width = 1;
		}
		$alignment = 'center';
	}
	else if($graph_type == 'missions:histogram') {
		$target = $target_value;
		$time_interval = $target;

		// Gets the missions according to the user given target value.
		$mission_set = mm_analytics_get_missions_by_value($target);

		// Removes the missions that are not within the department or that department's children.
		if($department_identifier != '') {
			$mission_set = mm_analytics_cull_missions_by_department($mission_set, $department_identifier);
		}

		if ($role_type != '') {
			$mission_set = mm_analytics_cull_missions_by_role_type($mission_set, $role_type);
		}

		if ($job_type != '') {
			$mission_set = mm_analytics_cull_missions_by_job_type($mission_set, $job_type);
		}

		if ($status != '') {
			$mission_set = mm_analytics_cull_missions_by_status($mission_set, $status);
		}

		// Creates an array of number which will separate the missions into bins.
		$timescale_array = mm_analytics_generate_time_scale_bins($bin_number, $target, $mission_set);

		$mission_set = array($mission_set);

		$bar_width = 0.9;
		$alignment = 'left';
	}

	// Creates an array of labels (which appear on the x-axis) corresponding to the boundaries of each bin.
	$bin_labels = mm_analytics_generate_bin_labels($timescale_array, $time_interval, $graph_type);

	// Creates the labels for each series.
	$bar_labels = mm_analytics_generate_separation_labels($separator);

	$target_lower = $target;
	$target_upper = $target;

	if($separator == 'missions:average_number_of_applicants') {
		$relation_set = array(array());
		foreach($mission_set[0] as $mission) {
			$relations_from_missions = get_entity_relationships($mission->guid);
			foreach($relations_from_missions as $relation) {
				if($relation->relationship == 'mission_accepted' ||
						$relation->relationship == 'mission_offered' ||
						$relation->relationship == 'mission_applied') {
					array_push($relation_set[0], $relation);
				}
			}
		}
		$relation_set = mm_analytics_separate_sets_into_bins($relation_set, $timescale_array, $target_lower, $target_upper, $graph_type);
		$target_lower = 'missions:closure_date';
		$target_upper = 'missions:date_posted';
	}

	// Separates the missions into their respectives bins.
	$mission_set = mm_analytics_separate_sets_into_bins($mission_set, $timescale_array, $target_lower, $target_upper, $graph_type);

	// Transforms the separated set of missions into a format readable by flot.
	$mission_set_final = array();
	$is_set_empty = true;
	foreach($mission_set as $y => $bar) {
		$mission_set_final[$y] = array('label' => elgg_echo($bar_labels[$y]), 'data' => array());
		foreach($bar as $x => $time) {
			if($separator == 'missions:average_number_of_applicants') {
				$applicant_count = count($relation_set[$y][$x]);
				$mission_count = count($mission_set[$y][$x]);

				if($mission_count == 0) {
					$value = 0;
				}
				else {
					$value = round(($applicant_count / $mission_count), 2);
				}
			}
			else {
				$value = count($mission_set[$y][$x]);
			}

			$x_label = $x;
			if ($graph_type == 'missions:stacked_graph') {
				$x_label = $bin_labels[$x][1];
			}

			$mission_set_final[$y]['data'][] = array($x_label, $value);
			if($value > 0 && $is_set_empty) {
				$is_set_empty = false;
			}
		}
	}

	// Creates the x-axis for the graph and an array of percentages detailing what portion of the bar a series occupies.
	$ticks_array = array();
	$percentages = array();
	$error_message = '';
	foreach($bin_labels as $x => $label) {
		$current_bin_label = $label;
		if ($graph_type == 'missions:stacked_graph') {
			$current_bin_label = $label[0];
		}
		$ticks_array[$x] = array($x, $current_bin_label);

		$total_x = 0;
		foreach($mission_set as $y => $bar) {
			$total_x += count($bar[$x]);
		}

		foreach($mission_set as $y => $bar) {
			$x_label = $label;
			if ($graph_type == 'missions:stacked_graph') {
				$x_label = $x_label[1];
			}

			if($total_x > 0) {
				$percentages[elgg_echo($bar_labels[$y])][$x_label] = array($total_x, 100 * round((count($bar[$x]) / $total_x), 4));
			}
			else {
				$percentages[elgg_echo($bar_labels[$y])][$x_label] = 0;
			}
		}
	}

	if($is_set_empty) {
		$error_returner = elgg_echo('missions:error:analytics:no_opportunities_in_data');
	}
	else {
		if(empty($ticks_array)) {
			$error_returner = elgg_echo('missions:error:analytics:no_intervals_in_x_axis');
		}
	}

	$json_returner['data'] = $mission_set_final;
	$json_returner['ticks'] = $ticks_array;
	// Creates the flot options.
	$json_returner['options'] = array(
			'series' => array(
					'bars' => array(
							'show' => true,
							'barWidth' => $bar_width,
							'align' => $alignment,
							'lineWidth' => 0,
							'fillColor' => array('colors' => array(array('opacity' => 1), array('opacity' => 1)))
					),
					'stack' => true
			),
			'colors' => array('rgb(2,63,165)', 'rgb(187,119,132)', 'rgb(17,198,56)', 'rgb(239,151,8)', 'rgb(156,222,214)'),
			'xaxis' => array(
					'show' => true,
					'ticks' => $ticks_array,
					'minTickSize' => $min_tick_size,
					'color' => 'rgb(255,255,255)'
			),
			'yaxis' => array('minTickSize' => 1, 'tickDecimals' => 0),
			'grid' => array('hoverable' => true),
			'legend' => array('sorted' => 'reverse')
	);
	$json_returner['percentages'] = $percentages;
	if ($graph_type == 'missions:stacked_graph') {
			$json_returner['options']['xaxis']['mode'] = 'time';
			$json_returner['options']['xaxis']['monthNames'] = array(
				elgg_echo("missions:january_short"),
				elgg_echo("missions:february_short"),
				elgg_echo("missions_march_short"),
				elgg_echo("missions:april_short"),
				elgg_echo("missions:may_short"),
				elgg_echo("missions:june_short"),
				elgg_echo("missions:july_short"),
				elgg_echo("missions:august_short"),
				elgg_echo("missions:september_short"),
				elgg_echo("missions:october_short"),
				elgg_echo("missions:november_short"),
				elgg_echo("missions:december_short")
			);
			unset($json_returner['options']['xaxis']['ticks']);

			$json_returner['options']['zoom'] = array( 'interactive' => true );
			$json_returner['options']['pan'] = array( 'interactive' => true );
			$json_returner['options']['yaxis']['zoomRange'] = false;
			$json_returner['options']['yaxis']['panRange'] = false;

			$json_returner['options']['xaxis']['panRange'] = array(
				($timescale_array[0] * 1000) - $bar_width,
				($timescale_array[count($timescale_array)-1] * 1000) + $bar_width
			);

			$json_returner['options']['xaxis']['zoomRange'] = array(
				$bar_width * 4 , null
			);

			// $json_returner['options']['selection'] = array(
			// 		'mode' => 'xy'
			// );
	}
	if ($time_format !== false) {
			$json_returner['options']['xaxis']['timeformat'] = $time_format;
	}
}

$json_returner['error_returned'] = $error_returner;

// Returns the results as a JSON entity.
echo json_encode($json_returner);

<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * A regex which returns true if the input is a phone number.
 * Regular expression created by Eric Holmes (http://ericholmes.ca/php-phone-number-validation-revisited/)
 * Valid:
 * 5555555555
 * 555-555-5555
 * 555 555 5555
 * 1(555) 555-5555
 * 1 (555) 555-5555
 * 1-555-555-5555
 * Invalid:
 * 5
 * 555-5555
 * 1-(555)-555-5555
 */
function mm_is_valid_phone_number($number)
{
	$regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";

	return preg_match($regex, (string) $number);
}

/*
 * A regex which checks that no numbers are in the expression.
 * Valid:
 * Eileen
 * Eileen Williamson
 * Valid but Wrong:
 * %$@#%$#&/:'.']}
 * Invalid:
 * 4Wesley
 * Wes7ley
 * Wesley9
 */
function mm_is_valid_person_name($name)
{
	$regex = "/^[^0-9]+$/";

	return preg_match($regex, $name);
}

/*
 * A regex which checks that only numbers are in the expression.
 * Valid:
 * 5
 * 673445
 * Invalid:
 * 532K351
 * @578(532)
 */
function mm_is_guid_number($num)
{
	$regex = "/^[0-9]*$/";

	return preg_match($regex, $num);
}

/*
 * A regex which checks the time format.
 * Valid:
 * 1:00
 * 23:59
 * 25:33
 * Invalid:
 * ab:ss
 * 2300
 */
function mm_is_valid_time($time) {
	$regex = '/[0-2][0-9][:][0-6][0-9]$/';

	return preg_match($regex, $time);
}

/*
 * A regex which checks the date format.
 */
function mm_is_valid_date($date) {
	$regex = '/^((19|20)\d\d)-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/';
	return preg_match($regex, $date);
}

/*
 * Tests all days of the week given the form input.
 */
function mm_validate_time_all(&$input_array)
{
	$err = '';

	$err .= mm_validate_time('mon', $input_array);
	$err .= mm_validate_time('tue', $input_array);
	$err .= mm_validate_time('wed', $input_array);
	$err .= mm_validate_time('thu', $input_array);
	$err .= mm_validate_time('fri', $input_array);
	$err .= mm_validate_time('sat', $input_array);
	$err .= mm_validate_time('sun', $input_array);

	return $err;
}

/*
 * Tests a the start time and duration of the given day of the week.
 * Also defaults the minutes to '00' if the hour is set and the minute value is null.
 */
function mm_validate_time($day, $input_array)
{
	/*$start_hour = $input_array[$day . '_start_hour'];
	$start_min = $input_array[$day . '_start_min'];
	$duration_hour = $input_array[$day . '_duration_hour'];
	$duration_min = $input_array[$day . '_duration_min'];
	$day_full = elgg_echo('missions:' . $day);
	$err = '';

	if ($_SESSION['language'] == 'fr') {
		$day_full = strtolower($day_full);
	}

	// If one hour value is not empty then the other cannot be empty and the associated minute value cannot be NULL.
	if (! empty($start_hour)) {
		if (empty($duration_hour) && empty($duration_min)) {
			$err .= elgg_echo('missions:duration_must_be_set') . $day_full . ".\n";
		}
		if (empty($start_min)) {
			$input_array[$day . '_start_min'] = '00';
			$start_min = '00';
		}
	}
	if (! empty($duration_hour) || ! empty($duration_min)) {
		if (empty($start_hour)) {
			$err .= elgg_echo('missions:start_hour_must_be_set') . $day_full . ".\n";
		}
		if (empty($duration_hour)) {
			$input_array[$day . '_duration_hour'] = '0';
			$duration_hour = '0';
		}
		if (empty($duration_min)) {
			$input_array[$day . '_duration_min'] = '00';
			$duration_min = '00';
		}
	}*/

	$err = '';
	$day_full = elgg_echo('missions:' . $day);
	$start = $input_array[$day . '_start'];
	$duration = $input_array[$day . '_duration'];

	if(!mm_is_valid_time($start) && $start) {
		$err .= elgg_echo('missions:invalid_start_time_format') . $day_full . ".\n";
	}
	if(substr($start, 0, 1) == '2' && substr($start, 1, 1) >= 4) {
		$err .= elgg_echo('missions:hours_exceeded', array($day_full)) . "\n";
	}
	if(!$duration && $start) {
		$err .= elgg_echo('missions:duration_must_be_set') . $day_full . ".\n";
	}

	if(!mm_is_valid_time($duration) && $duration) {
		$err .= elgg_echo('missions:invalid_duration_time_format') . $day_full . ".\n";
	}
	if(!$start && $duration) {
		$err .= elgg_echo('missions:start_time_must_be_set') . $day_full . ".\n";
	}

	return $err;
}

/*
 * Error checks the input values found in the first post mission form.
 */
 function mm_first_post_error_check($input_array) {
 	$err = '';

 	$name_and_email_limit = 100;

 	// Checks if the name field is empty then checks to see that there are no numbers in the name.
 	if (trim($input_array['name']) == '') {
 		$err .= elgg_echo('missions:error:name_needs_input') . "\n";

 		if(strlen($input_array['name']) > $name_and_email_limit) {
 			$err .= elgg_echo('missions:error:exceeds_string_length', array(elgg_echo('missions:your_name'), $name_and_email_limit)) . "\n";
 		}
 	}
 	/*else {
 		if (!mm_is_valid_person_name($input_array['name'])) {
 			$err .= elgg_echo('missions:error:name_no_numbers') . "\n";
 		}
 	}*/

 	// Checks if the department is empty.
 	if (!mo_get_last_input_node($input_array) && !$input_array['department']) {
 		$err .= elgg_echo('missions:error:department_needs_input') . "\n";
 	}

 	// Checks if the email a valid email address according to a function defined above.
 	if($input_array['email'] == '') {
 		$err .= elgg_echo('missions:error:email_needs_input') . "\n";
 	}
 	else {
	 	if (!filter_var($input_array['email'], FILTER_VALIDATE_EMAIL)) {
	 		$err .= elgg_echo('missions:error:email_invalid') . "\n";
	 	}
	 	else {
	 		if(strlen($input_array['email']) > $name_and_email_limit) {
		 		$err .= elgg_echo('missions:error:exceeds_string_length', array(elgg_echo('missions:your_email'), $name_and_email_limit)) . "\n";
		 	}
		 	else {
		 		$returned_users = get_user_by_email($input_array['email']);
			 	if(count($returned_users) == 0) {
			 		$err .= elgg_echo('missions:error:email_not_on_gcconnex', array($input_array['email'])) . "\n";
			 	}
		 	}
	 	}

	 	// Checks if the phone number is a valid phone number according to a function defined above.
	 	if (!mm_is_valid_phone_number($input_array['phone']) && !empty($input_array['phone'])) {
	 		$err .= elgg_echo('missions:error:phone_invalid') . "\n";
	 	}
 	}

 	return $err;
 }

 /*
  * Error checks the input values found in the second post mission form.
  */
 function mm_second_post_error_check($input_array) {
 	$err = '';

 	// Checks to see if these input fields are empty.
 	if (trim($input_array['job_title']) == '') {
 		$err .= elgg_echo('missions:error:opportunity_title_needs_input') . "\n";
 	}

 	$job_title_limit = 200;
 	if(strlen($input_array['job_title']) > $job_title_limit) {
 		$err .= elgg_echo('missions:error:exceeds_string_length', array(elgg_echo('missions:opportunity_title'), $job_title_limit)) . "\n";
 	}

 	if (empty($input_array['job_type'])) {
 		$err .= elgg_echo('missions:error:opportunity_type_needs_input') . "\n";
 	}

 	$date_type_array = array('start_date', 'completion_date', 'deadline');
 	foreach($date_type_array as $date_type) {
 		if (trim($input_array[$date_type]) == '' && $date_type != 'completion_date') {
 			$err .= elgg_echo('missions:error:' . $date_type . '_needs_input') . "\n";
 		}
 		else {
 			$date_before = $input_array[$date_type];
 			if($date_before != '') {
	 			if(!mm_is_valid_date($date_before)) {
		 			$err .= elgg_echo('missions:error:' . $date_type . '_not_formatted_properly') . "\n";
	 			}
	 			else {
		 			$timestamp = strtotime($date_before);
		 			$date_after = date('Y-m-d', $timestamp);
		 			if(!$timestamp || $date_after != $date_before) {
		 				$err .= elgg_echo('missions:error:' . $date_type . '_not_date') . "\n";
		 			}
	 			}
 			}
 		}
 	}

 	// Checks to see if the completion date comes before the end date.
 	$date_start = strtotime($input_array['start_date']);
 	$date_end = strtotime($input_array['completion_date']);
 	$date_dead = strtotime($input_array['deadline']);

 	if(trim($date_end) != '') {
	 	if ($date_end < $date_start) {
	 		$err .= elgg_echo('missions:error:start_after_end') . "\n";
	 	}

	 	if ($date_end < $date_dead) {
	 		$err .= elgg_echo('missions:error:deadline_after_end') . "\n";
	 	}
 	}
 	//Nick - Increasing limit from 2k to 5k as per JIRA 239
 	$description_limit = 8000;
 	if(strlen($input_array['description']) > $description_limit) {
 		$err .= elgg_echo('missions:error:exceeds_string_length', array(elgg_echo('missions:opportunity_description'), $description_limit)) . "\n";
 	}

 	return $err;
 }

 /*
  * Error checks the input values found in the Third post mission form.
  */
 function mm_third_post_error_check($input_array) {
 	$err = '';


 	// Checks to see if location is empty.
 	if (empty($input_array['location'])) {
 		$err .= elgg_echo('missions:error:location_needs_input') . "\n";
 	}

 	// Checks to see if time commitment is empty.
 	if (trim($input_array['time_commitment']) == '') {
 		$err .= elgg_echo('missions:error:time_commitment_needs_input') . "\n";
 	}
 	else {
 		if(!is_numeric($input_array['time_commitment'])) {
	 		$err .= elgg_echo('missions:error:time_commitment_not_number') . "\n";
	 	}
	 	else {
		 	if($input_array['time_commitment'] >= 100) {
		 		$err .= elgg_echo('missions:error:excessive_time_commitment') . "\n";
		 	}
		 	if($input_array['time_commitment'] <= 0) {
		 		$err .= elgg_echo('missions:error:negative_time_commitment') . "\n";
		 	}
	 	}
 	}

 	return $err;
 }

 /*
  * Checks that any day start or duration values are present in the input array.
  */
 function mm_check_days_for_start_or_duration($input) {
 	$input_type = '';
 	$days_values = array('mon_start','mon_duration','tue_start','tue_duration','wed_start','wed_duration',
 			'thu_start','thu_duration','fri_start','fri_duration','sat_start','sat_duration','sun_start','sun_duration');

 	if(is_array($input)) {
 		$input_type = 'array';
 	}

 	if(elgg_instanceof($input, 'object', 'mission')) {
 		$input_type = 'mission';
 	}

 	if($input_type == '') {
 		return false;
 	}
 	else {
	 	foreach($days_values as $day_value) {
	 		if($input_type == 'array') {
	 			if($input[$day_value] != '') {
	 				return true;
	 			}
	 		}
	 		else if($input_type == 'mission') {
	 			if($input->$day_value != '') {
	 				return true;
	 			}
	 		}
	 	}
 	}

 	return false;
 }

 /*
  * An extra check that runs if a days start or duration values are not empty.
  * The timezone cannot be empty in that case.
  */
 function mm_third_post_special_error_check($input_array) {
 	$err = '';
 	$days = array('mon','tue','wed','thu','fri','sat','sun');

 	$timezone_needed = mm_check_days_for_start_or_duration($input_array);

 	if($timezone_needed) {
 		if(trim($input_array['timezone']) == '') {
 			$err .= elgg_echo('missions:error:timezone_needs_input') . "\n";
 		}
 	}

 	return $err;
 }

<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to edit the content of a mission.
 */
elgg_make_sticky_form('editfill');
$edit_form = elgg_get_sticky_values('editfill');

$mission = get_entity(get_input('hidden_guid'));

$err = '';

// Does all the error checking that the post opportunity activity does.
$err .= mm_first_post_error_check($edit_form);
$err .= mm_second_post_error_check($edit_form);
$err .= mm_third_post_error_check($edit_form);
$err .= mm_validate_time_all($edit_form);

if ($err != '') {
    register_error($err);
    forward(REFERER);
} else {
	// Same saving methodology as the post opportunity.
	$mission->title = $edit_form['job_title'];
	$mission->description = $edit_form['description'];
	
	$mission->name = $edit_form['name'];
	
	$department_string = mo_get_last_input_node($edit_form);
	$department_paths = mo_string_all_ancestors($department_string);
	$mission->department = $department_string;
	$mission->department_path_english = $department_paths['english_path'];
	$mission->department_path_french = $department_paths['french_path'];
	
	$mission->email = $edit_form['email'];
	$mission->phone = $edit_form['phone'];
	$mission->job_title = $edit_form['job_title'];
	$mission->job_type = $edit_form['job_type'];
    $mission->number = $edit_form['number'];
    $mission->start_date = $edit_form['start_date'];
    $mission->completion_date = $edit_form['completion_date'];
    $mission->deadline = $edit_form['deadline'];
    $mission->descriptor = $edit_form['descriptor'];
    $mission->remotely = $edit_form['remotely'];
    $mission->security = $edit_form['security'];
    $mission->location = $edit_form['location'];
    $mission->timezone = $edit_form['timezone'];
    $mission->time_commitment = $edit_form['time_commitment'];
    $mission->time_interval = $edit_form['time_interval'];
    
    $count = 0;
    $key_skills = '';
    foreach($edit_form as $key => $value) {
    	if(!(strpos($key, 'skill') === false) && $value) {
    		if($count == 0) {
    			$key_skills .= $value;
    		}
    		else {
    			$key_skills .= ', ' . $value;
    		}
    		$count++;
    	}
    }
    $mission->key_skills = $key_skills;
    
    $mission->english = mm_pack_language($edit_form['lwc_english'], $edit_form['lwe_english'], $edit_form['lop_english'], 'english');
    $mission->french = mm_pack_language($edit_form['lwc_french'], $edit_form['lwe_french'], $edit_form['lop_french'], 'french');
    
    /*$mission->mon_start = mm_pack_time($edit_form['mon_start_hour'], $edit_form['mon_start_min'], 'mon_start');
    $mission->mon_duration = mm_pack_time($edit_form['mon_duration_hour'], $edit_form['mon_duration_min'], 'mon_duration');
    $mission->tue_start = mm_pack_time($edit_form['tue_start_hour'], $edit_form['tue_start_min'], 'tue_start');
    $mission->tue_duration = mm_pack_time($edit_form['tue_duration_hour'], $edit_form['tue_duration_min'], 'tue_duration');
    $mission->wed_start = mm_pack_time($edit_form['wed_start_hour'], $edit_form['wed_start_min'], 'wed_start');
    $mission->wed_duration = mm_pack_time($edit_form['wed_duration_hour'], $edit_form['wed_duration_min'], 'wed_duration');
    $mission->thu_start = mm_pack_time($edit_form['thu_start_hour'], $edit_form['thu_start_min'], 'thu_start');
    $mission->thu_duration = mm_pack_time($edit_form['thu_duration_hour'], $edit_form['thu_duration_min'], 'thu_duration');
    $mission->fri_start = mm_pack_time($edit_form['fri_start_hour'], $edit_form['fri_start_min'], 'fri_start');
    $mission->fri_duration = mm_pack_time($edit_form['fri_duration_hour'], $edit_form['fri_duration_min'], 'fri_duration');
    $mission->sat_start = mm_pack_time($edit_form['sat_start_hour'], $edit_form['sat_start_min'], 'sat_start');
    $mission->sat_duration = mm_pack_time($edit_form['sat_duration_hour'], $edit_form['sat_duration_min'], 'sat_duration');
    $mission->sun_start = mm_pack_time($edit_form['sun_start_hour'], $edit_form['sun_start_min'], 'sun_start');
    $mission->sun_duration = mm_pack_time($edit_form['sun_duration_hour'], $edit_form['sun_duration_min'], 'sun_duration');*/
    $mission->mon_start = $edit_form['mon_start'];
    $mission->mon_duration = $edit_form['mon_duration'];
    $mission->tue_start = $edit_form['tue_start'];
    $mission->tue_duration = $edit_form['tue_duration'];
    $mission->wed_start = $edit_form['wed_start'];
    $mission->wed_duration = $edit_form['wed_duration'];
    $mission->thu_start = $edit_form['thu_start'];
    $mission->thu_duration = $edit_form['thu_duration'];
    $mission->fri_start = $edit_form['fri_start'];
    $mission->fri_duration = $edit_form['fri_duration'];
    $mission->sat_start = $edit_form['sat_start'];
    $mission->sat_duration = $edit_form['sat_duration'];
    $mission->sun_start = $edit_form['sun_start'];
    $mission->sun_duration = $edit_form['sun_duration'];
    
    $mission->save();
    
    elgg_clear_sticky_form('editfill');
    forward(REFERER);
}
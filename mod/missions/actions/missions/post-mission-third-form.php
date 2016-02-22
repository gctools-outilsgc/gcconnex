<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action evaluates the data from the form for errors.
 * It then saves this data and all data from the previous two pages as metadata attached to a new object.
 * This object has the subtype of 'mission'.
 */
elgg_make_sticky_form('thirdfill');
elgg_make_sticky_form('ldropfill');
elgg_make_sticky_form('tdropfill');

$first_form = elgg_get_sticky_values('firstfill');
$second_form = elgg_get_sticky_values('secondfill');
$third_form = elgg_get_sticky_values('thirdfill');

$err = '';

// Error checking function.
$err .= mm_third_post_error_check($third_form);

// A specialized function for checking for errors in the time fields
$err .= mm_validate_time_all($third_form);

// Error reporting for bad user input
if ($err != '') {
    register_error($err);
    forward(REFERER);
} else {
    // $third_form = combine_time_table_from_array($third_form);
    
    // Creation of an ELGGObject of subtype Mission
    $mission = new ElggObject();
    $mission->subtype = 'mission';
    $mission->title = $second_form['job_title'];
    $mission->description = $second_form['description'];
    $mission->access_id = ACCESS_LOGGED_IN;
    $mission->owner_guid = elgg_get_logged_in_user_guid();
    
    // Attaches the form data as metadata to the object
    $mission->name = $first_form['name'];
    
   	$department_string = mo_get_last_input_node($first_form);
	$department_paths = mo_string_all_ancestors($department_string);
	$mission->department = $department_string;
	$mission->department_path_english = $department_paths['english_path'];
	$mission->department_path_french = $department_paths['french_path'];
    
    $mission->email = $first_form['email'];
    $mission->phone = $first_form['phone'];
    
    $mission->job_title = $second_form['job_title'];
    $mission->job_type = $second_form['job_type'];
    $mission->number = $second_form['number'];
    $mission->start_date = $second_form['start_date'];
    $mission->completion_date = $second_form['completion_date'];
    $mission->deadline = $second_form['deadline'];
    $mission->descriptor = $second_form['description'];
    
    $mission->remotely = $third_form['remotely'];
    //$mission->flexibility = $third_form['flexibility'];
    $mission->security = $third_form['security'];
    $mission->location = $third_form['location'];
    $mission->time_commitment = $third_form['time_commitment'];
    $mission->time_interval = $third_form['time_interval'];
    $mission->timezone = $third_form['timezone'];
    
    $count = 0;
    $key_skills = '';
    foreach($third_form as $key => $value) {
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
    
    $mission->english = mm_pack_language($third_form['lwc_english'], $third_form['lwe_english'], $third_form['lop_english'], 'english');
    $mission->french = mm_pack_language($third_form['lwc_french'], $third_form['lwe_french'], $third_form['lop_french'], 'french');
    
    /*$mission->mon_start = mm_pack_time($third_form['mon_start_hour'], $third_form['mon_start_min'], 'mon_start');
    $mission->mon_duration = mm_pack_time($third_form['mon_duration_hour'], $third_form['mon_duration_min'], 'mon_duration');
    $mission->tue_start = mm_pack_time($third_form['tue_start_hour'], $third_form['tue_start_min'], 'tue_start');
    $mission->tue_duration = mm_pack_time($third_form['tue_duration_hour'], $third_form['tue_duration_min'], 'tue_duration');
    $mission->wed_start = mm_pack_time($third_form['wed_start_hour'], $third_form['wed_start_min'], 'wed_start');
    $mission->wed_duration = mm_pack_time($third_form['wed_duration_hour'], $third_form['wed_duration_min'], 'wed_duration');
    $mission->thu_start = mm_pack_time($third_form['thu_start_hour'], $third_form['thu_start_min'], 'thu_start');
    $mission->thu_duration = mm_pack_time($third_form['thu_duration_hour'], $third_form['thu_duration_min'], 'thu_duration');
    $mission->fri_start = mm_pack_time($third_form['fri_start_hour'], $third_form['fri_start_min'], 'fri_start');
    $mission->fri_duration = mm_pack_time($third_form['fri_duration_hour'], $third_form['fri_duration_min'], 'fri_duration');
    $mission->sat_start = mm_pack_time($third_form['sat_start_hour'], $third_form['sat_start_min'], 'sat_start');
    $mission->sat_duration = mm_pack_time($third_form['sat_duration_hour'], $third_form['sat_duration_min'], 'sat_duration');
    $mission->sun_start = mm_pack_time($third_form['sun_start_hour'], $third_form['sun_start_min'], 'sun_start');
    $mission->sun_duration = mm_pack_time($third_form['sun_duration_hour'], $third_form['sun_duration_min'], 'sun_duration');*/
    $mission->mon_start = $third_form['mon_start'];
    $mission->mon_duration = $third_form['mon_duration'];
    $mission->tue_start = $third_form['tue_start'];
    $mission->tue_duration = $third_form['tue_duration'];
    $mission->wed_start = $third_form['wed_start'];
    $mission->wed_duration = $third_form['wed_duration'];
    $mission->thu_start = $third_form['thu_start'];
    $mission->thu_duration = $third_form['thu_duration'];
    $mission->fri_start = $third_form['fri_start'];
    $mission->fri_duration = $third_form['fri_duration'];
    $mission->sat_start = $third_form['sat_start'];
    $mission->sat_duration = $third_form['sat_duration'];
    $mission->sun_start = $third_form['sun_start'];
    $mission->sun_duration = $third_form['sun_duration'];
    
    $mission->state = 'posted';
    
    // Sends the object and all its metadata to the database
    $mission->save();
    
    // Creates a relationships between the user (manager) and the mission.
    add_entity_relationship($mission->owner_guid, 'mission_posted', $mission->guid);
    
    // Add to the river so it can be seen on the main page.
    elgg_create_river_item(array(
        'view' => 'river/object/mission/create',
        'action_type' => 'create',
        'subject_guid' => $mission->owner_guid,
        'object_guid' => $mission->getGUID()
    ));
    //add_to_river('river/object/mission/create', 'create', $mission->owner_guid, $mission->getGUID());
    
    // Clears all the sticky forms that have been in use so far.
    elgg_clear_sticky_form('firstfill');
    elgg_clear_sticky_form('secondfill');
    elgg_clear_sticky_form('thirdfill');
    elgg_clear_sticky_form('ldropfill');
    elgg_clear_sticky_form('tdropfill');
    
    unset($_SESSION['tab_context']);
    
    forward(elgg_get_site_url() . 'missions/main');
}
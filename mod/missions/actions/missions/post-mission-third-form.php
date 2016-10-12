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
$_SESSION['mission_duplicating_override_third'] = true;

$first_form = elgg_get_sticky_values('firstfill');
$second_form = elgg_get_sticky_values('secondfill');
$third_form = elgg_get_sticky_values('thirdfill');

$err = '';

// Error checking function.
$err .= mm_first_post_error_check($first_form);
$err .= mm_second_post_error_check($second_form);
$err .= mm_third_post_error_check($third_form);

// A specialized function for checking for errors in the time fields
$err .= mm_validate_time_all($third_form);

if($err == '') {
	$err .= mm_third_post_special_error_check($third_form);
}

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

    // If the organization tree is loaded, then the custom dropdown values will be processed and stored.
    if(mo_get_tree_root()) {
	   	$department_string = mo_get_last_input_node($first_form);
		$department_paths = mo_string_all_ancestors($department_string);
		$mission->department = $department_string;
		$mission->department_path_english = $department_paths['english_path'];
		$mission->department_path_french = $department_paths['french_path'];
    }
    // If the organization tree is not loaded, then the basic free text entry will be stored.
    else {
    	$mission->department = $first_form['department'];
		$mission->department_path_english = $first_form['department'];
		$mission->department_path_french = $first_form['department'];
    }

    $mission->email = $first_form['email'];
    $mission->phone = $first_form['phone'];

    $accounts = get_user_by_email($first_form['email']);
    $mission->account = array_pop($accounts)->guid;

    $mission->job_title = $second_form['job_title'];
    $mission->job_type = $second_form['job_type'];
	// Stores the value of program area selected unless it is other.
    if($second_form['job_area'] != 'missions:other') {
    	$mission->program_area = $second_form['job_area'];
    }
	// When other is selected, the free text entry is stored instead.
    else {
    	$mission->program_area = $second_form['other_text'];
    }
    $mission->number = $second_form['number'];
    $mission->start_date = $second_form['start_date'];
    $mission->completion_date = $second_form['completion_date'];
    $mission->deadline = $second_form['deadline'];
    $mission->descriptor = $second_form['description'];
    $mission->openess = $second_form['openess'];

		//Nick - Adding group and level to the mission meta data
		if($second_form['group']){
			$mission->gl_group = $second_form['group'];
			$mission->gl_level = $second_form['level'];
		}

    $mission->remotely = $third_form['remotely'];
    //$mission->flexibility = $third_form['flexibility'];
    $mission->security = $third_form['security'];
    $mission->location = $third_form['location'];
    $mission->time_commitment = $third_form['time_commitment'];
    $mission->time_interval = $third_form['time_interval'];
    $mission->timezone = $third_form['timezone'];

    // Stores the multiple skill fields in a comma separated string.
    $count = 0;
    $key_skills = '';
    $skill_array = array();
    foreach($third_form as $key => $value) {
    	if(!(strpos($key, 'skill') === false) && $value) {
    		$skill_array[$count] = $value;
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
    $mission->version = elgg_get_plugin_setting('mission_version', 'missions');

    $mission->time_to_post = time() - $_SESSION['mission_creation_begin_timestamp'];

    // Sends the object and all its metadata to the database
    $mission->save();

    $mission->meta_guid = $mission->guid;

    $mission->save();

    // Creates a relationships between the user (manager) and the mission.
    add_entity_relationship($mission->account, 'mission_posted', $mission->guid);

    // Add to the river so it can be seen on the main page.
    elgg_create_river_item(array(
        'view' => 'river/object/mission/create',
        'action_type' => 'create',
        'subject_guid' => $mission->owner_guid,
        'object_guid' => $mission->getGUID()
    ));
    //add_to_river('river/object/mission/create', 'create', $mission->owner_guid, $mission->getGUID());

    $_SESSION['mission_skill_match_array'] = $skill_array;
    unset($_SESSION['mission_duplicating_override_first']);
    unset($_SESSION['mission_duplicating_override_second']);
    unset($_SESSION['mission_duplicating_override_third']);

    if(count($skill_array) == 0) {
		elgg_clear_sticky_form('firstfill');
		elgg_clear_sticky_form('secondfill');
		elgg_clear_sticky_form('thirdfill');
		elgg_clear_sticky_form('ldropfill');
		elgg_clear_sticky_form('tdropfill');
    	system_message(elgg_echo('missions:succesfully_posted', array($mission->job_title)));
    	forward(elgg_get_site_url() . 'missions/main');
    }
    else {
	    if($third_form['hidden_java_state'] == 'noscript') {
	    	// Required action security tokens.
	    	$ts = time();
	    	$token = generate_action_token($ts);
	    	set_input('__elgg_ts', $ts);
	    	set_input('__elgg_token', $token);

	    	action('missions/post-mission-skill-match');
	    }
	    else {
		    $_SESSION['mission_skill_match_is_interlude'] = true;
		    system_message(elgg_echo('missions:saved_beginning_skill_match', array($key_skills)));
		    forward(REFERER);
	    }
    }


    /*
    // Finds a list of users who have the same skills that were input in the third form.
    $user_skill_match = array();
    foreach($skill_array as $skill) {
    	$options['type'] = 'object';
    	$options['subtype'] = 'MySkill';
    	$options['attribute_name_value_pairs'] = array(
    			'name' => 'title',
    			'value' => '%' . $skill . '%',
    			'operand' => 'LIKE',
    			'case_sensitive' => false
    	);
    	$skill_match = elgg_get_entities_from_attributes($options);

    	foreach($skill_match as $key => $value) {
    		$skill_match[$key] = $value->owner_guid;
    	}

    	if(empty($user_skill_match)) {
    		$user_skill_match = $skill_match;
    	}
    	else {
    		$user_skill_match = array_intersect($user_skill_match, $skill_match);
    	}
    }

    // Turns the user GUIDs into user entities.
    foreach($user_skill_match as $key => $value) {
    	$user_skill_match[$key] = get_entity($value);
    }

    $_SESSION['mission_search_switch'] = 'candidate';
    $_SESSION['candidate_count'] = count($user_skill_match);
    $_SESSION['candidate_search_set'] = $user_skill_match;

    // Clears all the sticky forms that have been in use so far.
    elgg_clear_sticky_form('firstfill');
    elgg_clear_sticky_form('secondfill');
    elgg_clear_sticky_form('thirdfill');
    elgg_clear_sticky_form('ldropfill');
    elgg_clear_sticky_form('tdropfill');

    unset($_SESSION['tab_context']);

    // If the list of users with matching skills returned any results then those results are displayed.
    if(count($user_skill_match) > 0) {
    	forward(elgg_get_site_url() . 'missions/display-search-set');
    }
    else {
    	forward(elgg_get_site_url() . 'missions/main');
    }
    */
}
?>

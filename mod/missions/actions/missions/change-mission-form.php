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

if($err == '') {
	$err .= mm_third_post_special_error_check($edit_form);
}

if ($err != '') {
    register_error($err);
    forward(REFERER);
} else {
	// Same saving methodology as the post opportunity.
	$mission->title = $edit_form['job_title'];
	$mission->description = $edit_form['description'];

	$mission->name = $edit_form['name'];

	// If the organization tree is loaded, then the custom dropdown values will be processed and stored.
	if(mo_get_tree_root()) {
		$department_string = mo_get_last_input_node($edit_form);
		$department_paths = mo_string_all_ancestors($department_string);
		$mission->department = $department_string;
		$mission->department_path_english = $department_paths['english_path'];
		$mission->department_path_french = $department_paths['french_path'];
	}
	// If the organization tree is not loaded, then the basic free text entry will be stored.
	else {
		$mission->department = $edit_form['department'];
		$mission->department_path_english = $edit_form['department'];
		$mission->department_path_french = $edit_form['department'];
	}

	$mission->email = $edit_form['email'];
	$mission->phone = $edit_form['phone'];
	$mission->job_title = $edit_form['job_title'];
	$mission->job_type = $edit_form['job_type'];
	// Stores the value of program area selected unless it is other.
	if($edit_form['job_area'] != 'missions:other') {
		$mission->program_area = $edit_form['job_area'];
	}
	// When other is selected, the free text entry is stored instead.
	else {
		$mission->program_area = $edit_form['other_text'];
	}

	//Nick - adding group and level
	if($edit_form['group']){
		$mission->gl_group = $edit_form['group'];
		$mission->gl_level = $edit_form['level'];
	}

    $mission->number = $edit_form['number'];
    $mission->start_date = $edit_form['start_date'];
    $mission->completion_date = $edit_form['completion_date'];
    $mission->deadline = $edit_form['deadline'];
    $mission->descriptor = $edit_form['description'];
    $mission->openess = $edit_form['openess'];
    $mission->remotely = $edit_form['remotely'];
    $mission->security = $edit_form['security'];
    $mission->location = $edit_form['location'];
    $mission->timezone = $edit_form['timezone'];
    $mission->time_commitment = $edit_form['time_commitment'];
    $mission->time_interval = $edit_form['time_interval'];

    // Stores the multiple skill fields in a comma separated string.
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

    $mission->meta_guid = $mission->guid;
    $mission->version = elgg_get_plugin_setting('mission_version', 'missions');

    $mission->save();

    elgg_clear_sticky_form('editfill');
    system_message(elgg_echo('missions:changes_have_been_saved', array($mission->job_title)));
    forward(REFERER);
}

<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action takes the input from the application form and constructs an email using the input and user profile data.
 */
$mid = $_SESSION['mid_act'];
unset($_SESSION['mid_act']);
$email_body = get_input('email_body');
$manager_permission = get_input('manager_permission');
$email_manager = get_input('email_manager');
$manager_email = get_input('email');

if(!$manager_permission) {
	register_error(elgg_echo('missions:error:please_obtain_permission'));
	forward(REFERER);
}
else {
	$mission = get_entity($mid);
	$applicant = elgg_get_logged_in_user_entity();
	
	if($email_manager == 'on') {
		// Checks if the input email is valid.
		if(!filter_var($manager_email, FILTER_VALIDATE_EMAIL)) {
			register_error('missions:error:email_invalid');
			forward(REFERER);
		}
		else {
			// Sends a premade email.
			$subject = elgg_echo('missions:notify_supervisor');
			
			$message = $mission->job_title;
			$message .= "\r\n";
			$message .= elgg_echo('missions:formatted:date_interval', array($mission->start_date, $mission->completion_date));
			$message .= "\r\n";
			$message .= elgg_echo('missions:formatted:time_commit', array($mission->time_commitment, $mission->time_interval));
			$message .= "\r\n";
			$message .= $mission->description;
			
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
			$headers .= 'From: ' . $applicant->email . "\r\n";
			
			mail($manager_email, $subject, $message, $headers);
		}
	}
	
	// To separate different sections of the email.
	$divider = "<br>" . '--------------------------------------------------' . "<br>";
	
	// Setting up the email head.
	$subject = elgg_echo('missions:application_to') . $mission->job_title;
	
	$body = '';
	$body .= elgg_echo('missions:see_full_profile') . ': '; 
	$body .= elgg_view('output/url', array(
	    'href' => $applicant->getURL(),
	    'text' => $applicant->username
	)) . "<br>";
	
	$body .= elgg_echo('missions:see_full_mission') . ': '; 
	$body .= elgg_view('output/url', array(
	    'href' => $mission->getURL(),
	    'text' => $mission->title
	)) . "<br>";
	
	$body .= $divider;
	
	$body .= $email_body;
	$body .= $divider;
	
	// Lists all educations of the applicant.
	$education_list = $applicant->education;
	if(!is_array($education_list)) {
	    $education_list = array_filter(array($education_list));
	}
	if(!empty($education_list)) {
	    foreach ($education_list as $education) {
	        $education = get_entity($education);
	        $education_ending = date("F", mktime(null, null, null, $education->enddate)) . ', ' . $education->endyear;
	        if ($education->ongoing == 'true') {
	            $education_ending = 'Present';
	        }
	        $education_beginning = date("F", mktime(null, null, null, $education->startdate)) . ', ' . $education->startyear;
	        
	        // TODO: This section should be in the language files eventually.
	        $body .= '<b><font size="4">' . $education->school . ':</font></b>' . "<br>";
	        $body .= $education_beginning . ' - ' . $education_ending . "<br>";
	        $body .= '<b>' . $education->degree . ':</b> ' . $education->field . "<br>";
	    }
	    $body .= $divider;
	}
	
	//Lists all work experiences of the applicant.
	$experience_list = $applicant->work;
	if(!is_array($experience_list)) {
	    $experience_list = array_filter(array($experience_list));
	}
	if(!empty($experience_list)) {
	    foreach ($experience_list as $experience) {
	        $experience = get_entity($experience);
	        $experience_ending = date("F", mktime(null, null, null, $experience->enddate)) . ', ' . $experience->endyear;
	        if ($experience->ongoing == 'true') {
	            $experience_ending = 'Present';
	        }
	        $experience_beginning = date("F", mktime(null, null, null, $experience->startdate)) . ', ' . $experience->startyear;
	        
	        // TODO: This section should be in the language files eventually.
	        $body .= '<b><font size="4">' . $experience->organization . ':</font></b>' . "<br>";
	        $body .= $experience_beginning . ' - ' . $experience_ending . "<br>";
	        $body .= '<b>' . $experience->title . '</b>' . "<br>";
	        $body .= $experience->responsibilities . "<br>";
	    }
	    $body .= $divider;
	}
	
	// Lists all skills of the applicant.
	$skill_list = $applicant->gc_skills;
	if(!is_array($skill_list)) {
	    $skill_list = array_filter(array($skill_list));
	}
	if(!empty($skill_list)) {
	    foreach ($skill_list as $skill) {
	        $skill = get_entity($skill);
	        $body .= '<b>' . $skill->title . '</b>' . "<br>";
	    }
	    $body .= $divider;
	}
	
	// Lists all language proficiencies of the applicant.
	$english_skills = $applicant->english;
	$french_skills = $applicant->french;
	if(!empty($english_skills)) {
		// TODO: This section should be in the language files eventually.
	    $body .= '<b><font size="4">' . elgg_echo('missions:english') . ':</font></b>' . "<br>";
	    $body .= elgg_echo('missions:written_comprehension') . '(' . $english_skills[0] . ') ';
	    $body .= elgg_echo('missions:written_expression') . '(' . $english_skills[1] . ') ';
	    $body .= elgg_echo('missions:oral_proficiency') . '(' . $english_skills[2] . ') ';
	}
	if(!empty($french_skills)) {
		// TODO: This section should be in the language files eventually.
	    $body .= "<br>" . '<b><font size="4">' . elgg_echo('missions:french') . ':</font></b>' . "<br>";
	    $body .= elgg_echo('missions:written_comprehension') . '(' . $french_skills[0] . ') ';
	    $body .= elgg_echo('missions:written_expression') . '(' . $french_skills[1] . ') ';
	    $body .= elgg_echo('missions:oral_proficiency') . '(' . $french_skills[2] . ') ';
	}
	
	$body .= elgg_view('output/url', array(
	    	'href' => elgg_get_site_url() . 'missions/mission-offer/' . $mission->guid . '/' . $applicant->guid,
	    	'text' => elgg_echo('missions:offer')
	));
	
	mm_notify_user($mission->owner_guid, $applicant->guid, $subject, $body);
	
	if(!check_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid) && !check_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid)) {
		add_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
	}
	
	// Opt in applicant if they are not opted in yet.
	if($applicant->opt_in_missions != 'gcconnex_profile:opt:yes') {
		$applicant->opt_in_missions = 'gcconnex_profile:opt:yes';
		$applicant->save();
	}
	
	system_message(elgg_echo('missions:you_have_applied_to_mission', array($mission->job_title)));
	
	elgg_clear_sticky_form('applicationfill');
	forward(elgg_get_site_url() . 'missions/main');
}
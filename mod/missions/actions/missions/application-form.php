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
$mission_email_body = get_input('mission_email_body');
//$manager_permission = get_input('manager_permission');
$manager_permission = true;
$email_manager = get_input('email_manager');
$manager_email = get_input('email');
$mission = get_entity($mid);
$applicant = elgg_get_logged_in_user_entity();
$mmdep = trim( explode('/', $mission->department_path_english)[0] );

if(!$manager_permission) {
	register_error(elgg_echo('missions:error:please_obtain_permission'));
	forward(REFERER);
}
elseif ( $mission->openess && stripos( $applicant->department, $mmdep ) === false ) {	// Check restriction by department
	register_error( elgg_echo( 'missions:error:department_restricted', array($mmdep, $applicant->department) ) );
	forward(REFERER);
}
else {
	
	if($email_manager == 'on') {
		// Checks if the input email is valid.
		if(!filter_var($manager_email, FILTER_VALIDATE_EMAIL)) {
			register_error(elgg_echo('missions:error:email_invalid'));
			forward(REFERER);
		}
		else {
			// Sends a premade email.
			$subject = elgg_echo('missions:notify_supervisor');
			
			$message .= elgg_echo('missions:supervisor_notice_sentence', array($applicant->name, $mission->job_title)) . '<br><br>';
			$message .= elgg_echo('missions:applicant_name') . ': ' . $applicant->name . '<br>';
			$message .= elgg_echo('missions:department') . ': ' . $applicant->department . '<br>';
			$message .= elgg_echo('missions:location') . ': ' . $applicant->location . '<br>';
			$message .= elgg_echo('missions:applicant_phone') . ': ' . $applicant->phone . '<br><br>';
			
			$message .= elgg_echo('missions:opportunity_title') . ': ' . $mission->job_title . '<br>';
			$message .= elgg_echo('missions:opportunity_type') . ': ' . elgg_echo($mission->job_type) . '<br>';
			$message .= elgg_echo('missions:manager_name') . ': ' . $mission->name . '<br>';
			$message .= elgg_echo('missions:manager_email') . ': ' . $mission->email . '<br>';
			$message .= elgg_echo('missions:ideal_start_date') . ': ' . $mission->start_date . '<br>';
			$message .= elgg_echo('missions:ideal_completion_date') . ': ' . $mission->completion_date . '<br>';
			$message .= elgg_echo('missions:time_commitment') . ': ' . $mission->time_commitment . ' ' . elgg_echo($mission->time_interval) . '<br>';
			$message .= elgg_echo('missions:opportunity_description') . ': ' . $mission->descriptor . '<br>';
			
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From: ' . $applicant->email . "\r\n";
			
			mail($manager_email, $subject, $message, $headers);
		}
	}
	
	// To separate different sections of the email.
	$divider = '--------------------------------------------------' . "<br>";
	
	// Setting up the email head.
	$subject = elgg_echo('missions:application_to') . $mission->job_title;
	
	$body = '';
	
	$body .= elgg_echo('missions:application_notice_sentence', array($applicant->name, $mission->job_title)) . '<br>';
	$body .= $divider;
	
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
	
	$body .= $mission_email_body . '<br>';
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
	    $body .= '<b><font size="4">' . elgg_echo('missions:english') . ':</font></b>' . "<br>";
	    $body .= elgg_echo('missions:written_comprehension') . '(' . $english_skills[0] . ') ';
	    $body .= elgg_echo('missions:written_expression') . '(' . $english_skills[1] . ') ';
	    $body .= elgg_echo('missions:oral_proficiency') . '(' . $english_skills[2] . ') ';
	}
	if(!empty($french_skills)) {
	    $body .= "<br>" . '<b><font size="4">' . elgg_echo('missions:french') . ':</font></b>' . "<br>";
	    $body .= elgg_echo('missions:written_comprehension') . '(' . $french_skills[0] . ') ';
	    $body .= elgg_echo('missions:written_expression') . '(' . $french_skills[1] . ') ';
	    $body .= elgg_echo('missions:oral_proficiency') . '(' . $french_skills[2] . ') ';
	}
	
	// Sends the application via email and notification.
	$body .= elgg_view('output/url', array(
	    	'href' => elgg_get_site_url() . 'missions/mission-offer/' . $mission->guid . '/' . $applicant->guid,
	    	'text' => elgg_echo('missions:offer')
	));
	
	mm_notify_user($mission->guid, $applicant->guid, $subject, $body);
	
	// Creates an applied relationship between user and mission if there is no relationship there already.
	if(!check_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid) && !check_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid)) {
		add_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
	}
	
	// Opt in applicant if they are not opted in yet.
	if(!check_if_opted_in($applicant)) {
		$applicant->opt_in_missions = 'gcconnex_profile:opt:yes';
		$applicant->save();
	}
	
	system_message(elgg_echo('missions:you_have_applied_to_mission', array($mission->job_title, $mission->name)));
	
	elgg_clear_sticky_form('applicationfill');
	forward(elgg_get_site_url() . 'missions/main');
}
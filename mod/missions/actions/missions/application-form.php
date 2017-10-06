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
$manager_permission = true;
$email_manager = get_input('email_manager');
$manager_email = get_input('email');
$mission = get_entity($mid);
$applicant = elgg_get_logged_in_user_entity();
$mmdep = trim( explode('/', $mission->department_path_english)[0] );
$french_follows = elgg_echo('cp_notify:french_follows',array());
$email_notification_footer_en = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'en');
$email_notification_footer_fr = elgg_echo('cp_notify:footer2',array(elgg_get_site_url()."settings/notifications/{$username_link}".'?utm_source=notification&utm_medium=site'),'fr');
$email_notification_header = elgg_echo('cp_notification:email_header',array(),'en') . ' | ' . elgg_echo('cp_notification:email_header',array(),'fr');

$cal_month = array(
                    1 => elgg_echo('gcconnex_profile:month:january','fr'),
                    2 => elgg_echo('gcconnex_profile:month:february','fr'),
                    3 => elgg_echo('gcconnex_profile:month:march','fr'),
                    4 => elgg_echo('gcconnex_profile:month:april','fr'),
                    5 => elgg_echo('gcconnex_profile:month:may','fr'),
                    6 => elgg_echo('gcconnex_profile:month:june','fr'),
                    7 => elgg_echo('gcconnex_profile:month:july','fr'),
                    8 => elgg_echo('gcconnex_profile:month:august','fr'),
                    9 => elgg_echo('gcconnex_profile:month:september','fr'),
                    10 => elgg_echo('gcconnex_profile:month:october','fr'),
                    11 => elgg_echo('gcconnex_profile:month:november','fr'),
                    12 => elgg_echo('gcconnex_profile:month:december','fr')
                );

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
			$subject = elgg_echo('missions:notify_supervisor','en').' | '.elgg_echo('missions:notify_supervisor','fr');
			
			$supervisor_en .= elgg_echo('missions:supervisor_notice_sentence', array($applicant->name, $mission->job_title),'en') . '<br><br>';
			$supervisor_fr .= elgg_echo('missions:supervisor_notice_sentence', array($applicant->name, $mission->job_title),'fr') . '<br><br>';

			$body_en .= '<b>'.elgg_echo('missions:applicant_name','en') . '</b>: ' . $applicant->name . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:department','en') . '</b>: ' . $applicant->department . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:location','en') . '</b>: ' . $applicant->location . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:applicant_phone','en') . '</b>: ' . $applicant->phone . '<br><br>';
			
			$body_en .= '<b>'.elgg_echo('missions:opportunity_title','en') . '</b>: ' . $mission->job_title . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:opportunity_type','en') . '</b>: ' . elgg_echo($mission->job_type) . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:manager_name','en') . '</b>: ' . $mission->name . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:manager_email','en') . '</b>: ' . $mission->email . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:ideal_start_date','en') . '</b>: ' . $mission->start_date . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:ideal_completion_date','en') . '</b>: ' . $mission->completion_date . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:time_commitment','en') . '</b>: ' . $mission->time_commitment . ' ' . elgg_echo($mission->time_interval) . '<br>';
			$body_en .= '<b>'.elgg_echo('missions:opportunity_description','en') . '</b>: ' . $mission->descriptor . '<br>';

			$body_fr .= '<b>'.elgg_echo('missions:applicant_name','fr') . '</b>: ' . $applicant->name . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:department','fr') . '</b>: ' . $applicant->department . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:location','fr') . '</b>: ' . $applicant->location . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:applicant_phone','fr') . '</b>: ' . $applicant->phone . '<br><br>';
			
			$body_fr .= '<b>'.elgg_echo('missions:opportunity_title','fr') . '</b>: ' . $mission->job_title . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:opportunity_type','fr') . '</b>: ' . elgg_echo($mission->job_type) . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:manager_name','fr') . '</b>: ' . $mission->name . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:manager_email','fr') . '</b>: ' . $mission->email . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:ideal_start_date','fr') . '</b>: ' . $mission->start_date . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:ideal_completion_date','fr') . '</b>: ' . $mission->completion_date . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:time_commitment','fr') . '</b>: ' . $mission->time_commitment . ' ' . elgg_echo($mission->time_interval) . '<br>';
			$body_fr .= '<b>'.elgg_echo('missions:opportunity_description','fr') . '</b>: ' . $mission->descriptor . '<br>';
			
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From: ' . $applicant->email . "\r\n";


$message = "<html>
<body>
	<!-- beginning of email template -->
	<div width='100%' background-color='#fcfcfc'>
		<div>
			<div>

		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header}
		        </div>

		     	<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>

		        <div style='height:1px; background-color:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        		<span style='font-size:12px; font-weight: normal;'>{$french_follows}</span><br/>

		        </div>



		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>

		        	<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif';>
		        		<strong> {$supervisor_en} </strong>
		        	</h4>

		        	{$body_en}

		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notification_footer_en}</div>
                </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>

		       		<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif;'>
		       			<strong> {$supervisor_fr} </strong>
		       		</h4>

		       		{$body_fr}
		       		

		        </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                   <div>{$email_notification_footer_fr}</div>
                </div>

		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'> </div>

			</div>
		</div>
	</div>
</body>
</html>";

			
			mail($manager_email, $subject, $message, $headers);
		}
	}
	
	// Setting up the email head.
	$subject = elgg_echo('missions:application_to','en') . $mission->job_title.' | '.elgg_echo('missions:application_to','fr') . $mission->job_title;
	$body = '';
	
	$title_applicant_en .= elgg_echo('missions:application_notice_sentence_title', array($applicant->name, $mission->job_title),'en') ;
	$title_applicant_fr .= elgg_echo('missions:application_notice_sentence_title', array($applicant->name, $mission->job_title),'fr') ;

	$content_applicant_en .= elgg_echo('missions:application_notice_sentence', 'en') . '<br>';
	$content_applicant_fr .= elgg_echo('missions:application_notice_sentence', 'fr') . '<br>';
	
	$content_applicant_en .= '<br>'.elgg_echo('missions:see_full_profile','en') . ': '; 
	$content_applicant_fr .= '<br>'.elgg_echo('missions:see_full_profile','fr') . ': '; 

	$username = elgg_view('output/url', array(
	    'href' => $applicant->getURL(),
	    'text' => $applicant->username
	)) . "<br>";

	$content_applicant_en .= $username;
	$content_applicant_fr .= $username;
	
	$content_applicant_en .= elgg_echo('missions:see_full_mission','en') . ': '; 
	$content_applicant_fr .= elgg_echo('missions:see_full_mission','fr') . ': '; 

	$mission_title = elgg_view('output/url', array(
	    'href' => $mission->getURL(),
	    'text' => $mission->title
	)) . "<br>";

	$content_applicant_en .= $mission_title;
	$content_applicant_fr .= $mission_title;
	
	$content_applicant_en .=  '<br>'.elgg_echo('missions:from_message',array($applicant->username),'en').'<br><span style="font-style: italic;">'.$mission_email_body . '</span><br>';
	$content_applicant_fr .=  '<br>'.elgg_echo('missions:from_message',array($applicant->username),'fr').'<br><span style="font-style: italic;">'.$mission_email_body . '</span><br>';

	// Lists all educations of the applicant.
	$education_list = $applicant->education;
	if(!is_array($education_list)) {
	    $education_list = array_filter(array($education_list));
	}
	if(!empty($education_list)) {
	    foreach ($education_list as $education) {
	        $education = get_entity($education);
	        $education_ending_en = date("F", mktime(null, null, null, $education->enddate)) . ', ' . $education->endyear;
	        $education_ending_fr = $cal_month[$education->enddate] . ', ' . $education->endyear;

	        if ($education->ongoing == 'true') {
	            $education_ending_en = 'Present';
	            $education_ending_fr = 'Présent';
	        }

	        $education_beginning_en = date("F", mktime(null, null, null, $education->startdate)) . ', ' . $education->startyear;
	        $education_beginning_fr = $cal_month[$education->startdate] . ', ' . $education->startyear;
 
	        // TODO: This section should be in the language files eventually.
	        $content_applicant_en .= '<br><b><font size="4">' . $education->school . ':</font></b>' . "<br>";
	        $content_applicant_en .=  $education_beginning_en . ' - ' . $education_ending_en . "<br>";
	        $content_applicant_en .= '<b>' . $education->degree . ':</b> ' . $education->field . "<br>";

	        $content_applicant_fr .= '<br><b><font size="4">' . $education->school . ':</font></b>' . "<br>";
	        $content_applicant_fr .=  $education_beginning_fr . ' - ' . $education_ending_fr . "<br>";
	        $content_applicant_fr .= '<b>' . $education->degree . ':</b> ' . $education->field . "<br>";
	    }
	}
	
	//Lists all work experiences of the applicant.
	$experience_list = $applicant->work;
	if(!is_array($experience_list)) {
	    $experience_list = array_filter(array($experience_list));
	}
	if(!empty($experience_list)) {
	    foreach ($experience_list as $experience) {
	        $experience = get_entity($experience);
	        $experience_ending_en = date("F", mktime(null, null, null, $experience->enddate)) . ', ' . $experience->endyear;
	        $experience_ending_fr = $cal_month[$experience->enddate] . ', ' . $experience->endyear;
	        if ($experience->ongoing == 'true') {
	            $experience_ending_en = 'Present';
	            $experience_ending_fr = 'Présent';
	        }
	        $experience_beginning_en = date("F", mktime(null, null, null, $experience->startdate)) . ', ' . $experience->startyear;
	        $experience_beginning_fr =  $cal_month[$experience->startdate] . ', ' . $experience->startyear;
	        
	        // TODO: This section should be in the language files eventually.
	        $content_applicant_en .= '<br><b><font size="4">' . $experience->organization . ':</font></b>' . "<br>";
	        $content_applicant_en .= $experience_beginning_en . ' - ' . $experience_ending_en . "<br>";
	        $content_applicant_en .= '<b>' . $experience->title . '</b>' . "<br>";
	        $content_applicant_en .= $experience->responsibilities . "<br><br>";

	        $content_applicant_fr .= '<br><b><font size="4">' . $experience->organization . ':</font></b>' . "<br>";
	        $content_applicant_fr .= $experience_beginning_fr . ' - ' . $experience_ending_fr . "<br>";
	        $content_applicant_fr .= '<b>' . $experience->title . '</b>' . "<br>";
	        $content_applicant_fr .= $experience->responsibilities . "<br><br>";
	    }
	}
	
	// Lists all skills of the applicant.
	$skill_list = $applicant->gc_skills;
	if(!is_array($skill_list)) {
	    $skill_list = array_filter(array($skill_list));
	}
	if(!empty($skill_list)) {
	    foreach ($skill_list as $skill) {
	        $skill = get_entity($skill);
	        $content_applicant_en .= '<b>' . $skill->title . '</b>' . "<br>";
	        $content_applicant_fr .= '<b>' . $skill->title . '</b>' . "<br>";
	    }
	}
	
	// Sends the application via email and notification.
	$content_applicant_en .= elgg_view('output/url', array(
	    	'href' => elgg_get_site_url() . 'missions/mission-offer/' . $mission->guid . '/' . $applicant->guid,
	    	'text' => '<br>'.elgg_echo('missions:offer','en')
	));

	$content_applicant_fr .= elgg_view('output/url', array(
	    	'href' => elgg_get_site_url() . 'missions/mission-offer/' . $mission->guid . '/' . $applicant->guid,
	    	'text' => '<br>'.elgg_echo('missions:offer','fr')
	));

$body = "<html>
<body>
	<!-- beginning of email template -->
	<div width='100%' background-color='#fcfcfc'>
		<div>
			<div>

		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 12px; color: #055959'>
		        	{$email_notification_header}
		        </div>

		     	<div width='100%' style='padding: 0 0 0 10px; color:#ffffff; font-family: sans-serif; font-size: 35px; line-height:38px; font-weight: bold; background-color:#047177;'>
		        	<span style='padding: 0 0 0 3px; font-size: 20px; color: #ffffff; font-family: sans-serif;'>GCconnex</span>
		        </div>

		        <div style='height:1px; background-color:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		     	<div width='100%' style='padding:30px 30px 10px 30px; font-size:12px; line-height:22px; font-family:sans-serif;'>

	        		<span style='font-size:12px; font-weight: normal;'>{$french_follows}</span><br/>

		        </div>



		        <div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px; '>

		        	<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif';>
		        		<strong> {$title_applicant_en} </strong>
		        	</h4>

		        	{$content_applicant_en}

		        </div>
                <div style='margin-top:15px; padding: 5px; color: #6d6d6d; border-bottom: 1px solid #ddd;'>
                    <div>{$email_notification_footer_en}</div>
                </div>

		       	<div width='100%' style='padding:30px 30px 30px 30px; color:#153643; font-family:sans-serif; font-size:16px; line-height:22px;'>

		       		<h4 style='padding: 0px 0px 5px 0px; font-family:sans-serif;'>
		       			<strong> {$title_applicant_fr} </strong>
		       		</h4>

		       		{$content_applicant_fr}
		       		

		        </div>
                    <div style='margin-top:15px; padding: 5px; color: #6d6d6d;'>
                   <div>{$email_notification_footer_fr}</div>
                </div>

		        <div style='height:1px; background:#bdbdbd; border-bottom:1px solid #ffffff'></div>

		        <div align='center' width='100%' style='background-color:#f5f5f5; padding:20px 30px 15px 30px; font-family: sans-serif; font-size: 16px; color: #055959'> </div>

			</div>
		</div>
	</div>
</body>
</html>";
	
	mm_notify_user($mission->guid, $applicant->guid, $subject,$title_applicant_en,$title_applicant_fr, $content_applicant_en, $content_applicant_fr);
	
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
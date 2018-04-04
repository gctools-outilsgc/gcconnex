<?php
/*
 * Exposes API endpoints for Opportunity entities
 */

elgg_ws_expose_function(
	"get.opportunity",
	"get_opportunity",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.opportunities",
	"get_opportunities",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves opportunities based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"apply.post",
	"apply_post",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true, 'default' => ""),		
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"withdraw.post",
	"withdraw_post",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true, 'default' => ""),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"accept.post",
	"accept_post",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

function get_opportunity($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Opportunity was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'mission')) {
		return "Invalid opportunity. Please try a different GUID";
	}



	$opportunities = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'mission',
		'guid' => $guid
	));
	$opportunity = json_decode($opportunities)[0];

	$opportunity->title = gc_explode_translation($opportunity->title, $lang);

	$likes = elgg_get_annotations(array(
		'guid' => $opportunity->guid,
		'annotation_name' => 'likes'
	));
	$opportunity->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $opportunity->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$opportunity->liked = count($liked) > 0;

	$opportunity->comments = get_entity_comments($opportunity->guid);

	$opportunity->userDetails = get_user_block($opportunity->owner_guid, $lang);
	$opportunity->description = gc_explode_translation($opportunity->description, $lang);

	$opportunityObj = get_entity($opportunity->guid);
	$opportunity->jobtype = elgg_echo($opportunityObj->job_type);
	$opportunity->roletype = elgg_echo($opportunityObj->role_type);
	//$opportunity->programArea = elgg_echo('missions:program_area') . ": " . elgg_echo($opportunityObj->program_area); //This should work and translate to user lang but doesnt
	$opportunity->programArea = elgg_echo($opportunityObj->program_area);
	$opportunity->numOpportunities = $opportunityObj->number;
	$opportunity->idealStart = $opportunityObj->start_date;
	$opportunity->idealComplete = $opportunityObj->complete_date;
	$opportunity->deadline = $opportunityObj->deadline;
	$opportunity->oppVirtual = $opportunityObj->remotely;
	$opportunity->oppOnlyIn = $opportunityObj->openess;
	$opportunity->location = elgg_echo($opportunityObj->location);
	$opportunity->security = elgg_echo($opportunityObj->security);
	$opportunity->skills = $opportunityObj->key_skills;
	//$opportunity->participants = $opportunityObj->;
	//$opportunity->applicants = $opportunityObj->;
	$opportunity->timezone = elgg_echo($opportunityObj->timezone);
	$opportunity->timecommitment = $opportunityObj->time_commitment;
	$opportunity->department = $opportunityObj->department;
	$opportunity->state = $opportunityObj->state;

	//Language metadata
	$unpacked_array = mm_unpack_mission($opportunityObj);
	$unpacked_language = '';
	if (! empty($unpacked_array['lwc_english']) || ! empty($unpacked_array['lwc_french'])) {
  	$unpacked_language .= '<b>' . elgg_echo('missions:written_comprehension') . ': </b>';
  	if (! empty($unpacked_array['lwc_english'])) {
      $unpacked_language .= '<span name="mission-lwc-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lwc_english'])) . '</span> ';
  	}
  	if (! empty($unpacked_array['lwc_french'])) {
      $unpacked_language .= '<span name="mission-lwc-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french'])) . '</span>';
  	}
		$unpacked_language .= '<br>';
	}
	if (! empty($unpacked_array['lwe_english']) || ! empty($unpacked_array['lwe_french'])) {
		$unpacked_language .= '<b>' . elgg_echo('missions:written_expression') . ': </b>';
		if (! empty($unpacked_array['lwe_english'])) {
	  	$unpacked_language .= '<span name="mission-lwe-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lwe_english'])) . '</span> ';
	 	}
	  if (! empty($unpacked_array['lwe_french'])) {
	  	$unpacked_language .= '<span name="mission-lwe-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lwe_french'])) . '</span>';
	  }
	  	$unpacked_language .= '<br>';
	}
	if (! empty($unpacked_array['lop_english']) || ! empty($unpacked_array['lop_french'])) {
		$unpacked_language .= '<b>' . elgg_echo('missions:oral_proficiency') . ': </b>';
		if (! empty($unpacked_array['lop_english'])) {
			$unpacked_language .= '<span name="mission-lop-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lop_english'])) . '</span> ';
		}
		if (! empty($unpacked_array['lop_french'])) {
			$unpacked_language .= '<span name="mission-lop-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lop_french'])) . '</span>';
		}
		$unpacked_language .= '<br>';
	}
	if (empty($unpacked_language)) {
		$unpacked_language = '<span name="no-languages">' . elgg_echo('missions:none_required') . '</span>';
	}
	$opportunity->languageRequirements = $unpacked_language;

	//scheduling metadata
	$unpacked_time = '';
	if ($opportunityObj->mon_start) {
		$unpacked_time .= '<b>' . elgg_echo('missions:mon') . ': </b>';
	 	$unpacked_time .= $opportunityObj->mon_start . elgg_echo('missions:to') .  $opportunityObj->mon_duration . '<br>';
	}
	if ($opportunityObj->tue_start) {
		$unpacked_time .= '<b>' . elgg_echo('missions:tue') . ': </b>';
		$unpacked_time .= '<span name="mission-tue-start">' . $opportunityObj->tue_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-tue-duration">' . $opportunityObj->tue_duration . '</span><br>';
	}
	if ($opportunityObj->wed_start) {
		$unpacked_time .= '<b>' . elgg_echo('missions:wed') . ': </b>';
		$unpacked_time .=  $opportunityObj->wed_start  . elgg_echo('missions:to') . $opportunityObj->wed_duration . '<br>';
	}
	if ($opportunityObj->thu_start) {
		$unpacked_time .= '<b>' . elgg_echo('missions:thu') . ': </b>';
		$unpacked_time .= '<span name="mission-thu-start">' . $opportunityObj->thu_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-thu-duration">' . $opportunityObj->thu_duration . '</span><br>';
	}
	if ($opportunityObj->fri_start) {
	  $unpacked_time .= '<b>' . elgg_echo('missions:fri') . ': </b>';
	  $unpacked_time .= '<span name="mission-fri-start">' . $opportunityObj->fri_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-fri-duration">' . $opportunityObj->fri_duration . '</span><br>';
	}
	if ($opportunityObj->sat_start) {
	  $unpacked_time .= '<b>' . elgg_echo('missions:sat') . ': </b>';
	  $unpacked_time .= '<span name="mission-sat-start">' . $opportunityObj->sat_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-sat-duration">' . $opportunityObj->sat_duration . '</span><br>';
	}
	if ($opportunityObj->sun_start) {
	  $unpacked_time .= '<b>' . elgg_echo('missions:sun') . ': </b>';
	  $unpacked_time .= '<span name="mission-sun-start">' . $opportunityObj->sun_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-sun-duration">' . $opportunityObj->sun_duration . '</span><br>';
	}
	if (empty($unpacked_time)) {
	  $unpacked_time = '<span name="no-times">' . elgg_echo('missions:none_required') . '</span>';
	}
	$opportunity->schedulingRequirements = $unpacked_time;

	
	return $opportunity;
}

function get_opportunities($user, $limit, $offset, $filters, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$filter_data = json_decode($filters);
	if (!empty($filter_data)) {
		$params = array(
			'type' => 'object',
			'subtype' => 'mission',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->type) {
			$params['metadata_name'] = 'job_type';
			$params['metadata_value'] = $filter_data->type;
		}

		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");
			$params['wheres'] = array("(oe.title LIKE '%" . $filter_data->name . "%' OR oe.description LIKE '%" . $filter_data->name . "%')");
		}

		if ($filter_data->mine) {
			$all_opportunities = elgg_list_entities_from_relationship($params);
		} else {
			$all_opportunities = elgg_list_entities_from_metadata($params);
		}
	} else {
		$all_opportunities = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'mission',
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$opportunities = json_decode($all_opportunities);

	foreach ($opportunities as $opportunity) {
		$opportunityObj = get_entity($opportunity->guid);
		$opportunity->title = gc_explode_translation($opportunity->title, $lang);
	
		$likes = elgg_get_annotations(array(
			'guid' => $opportunity->guid,
			'annotation_name' => 'likes'
		));
		$opportunity->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $opportunity->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		if($opportunity->owner_guid != $user_entity->guid){
			
			if($opportunityObj->state != 'completed' && $opportunityObj->state != 'cancelled'){
				$relationship_count = elgg_get_entities_from_relationship(array(
					'relationship' => 'mission_accepted',
					'relationship_guid' => $opportunity->guid,
					'count' => true
				));	
				if($relationship_count < $opportunityObj->number) {
				
					$opportunity->apply = 'mission_apply'; // user can apply
				}
					
				if(check_entity_relationship($opportunity->guid, 'mission_tentative', $user_entity->guid)) {
					//console.log($opportunity->title);
					$opportunity->apply = 'tentative'; // user can accecpt offer
				}
				if(check_entity_relationship($opportunity->guid, 'mission_offered', $user_entity->guid)) {
					$opportunity->apply = 'offered'; // user can accecpt offer
					
				}
				if(check_entity_relationship($opportunity->guid, 'mission_accepted', $user_entity->guid) ||
				check_entity_relationship($opportunity->guid, 'mission_applied', $user_entity->guid)) {
					$opportunity->apply = 'withdraw'; // user can accecpt offer
				
				}
			}else{
				$opportunity->apply = 'close';
			}
		}
			
		$opportunity->liked = count($liked) > 0;
		$opportunity->jobtype = elgg_echo($opportunityObj->job_type);
		$opportunity->roletype = elgg_echo($opportunityObj->role_type);
		$opportunity->deadline = $opportunityObj->deadline;
		$opportunity->programArea = elgg_echo($opportunityObj->program_area);
		$opportunity->owner = ($opportunityObj->getOwnerEntity() == $user_entity);
		$opportunity->iconURL = $opportunityObj->getIconURL();
		$opportunity->userDetails = get_user_block($opportunity->owner_guid, $lang);
		$opportunity->description = clean_text(gc_explode_translation($opportunity->description, $lang));
		$opportunity->state = $opportunityObj->state;

	}

	return $opportunities;
}



function apply_post($user,$message,$guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Opportunity was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'mission')) {
		return "Invalid opportunity. Please try a different GUID";
	}

	// Creates an applied relationship between user and mission if there is no relationship there already.
	if(!check_entity_relationship($entity->guid, 'mission_accepted', $user_entity->guid) && !check_entity_relationship($entity->guid, 'mission_tentative', $user_entity->guid)) {
		add_entity_relationship($entity->guid, 'mission_applied', $user_entity->guid);
		$message_info = elgg_echo('missions:you_have_applied_to_mission', array($entity->job_title, $entity->name));

		$title_applicant_en = elgg_echo('missions:application_notice_sentence_title', array($user_entity->name, $entity->job_title),'en') ;
		$title_applicant_fr = elgg_echo('missions:application_notice_sentence_title', array($user_entity->name, $entity->job_title),'fr') ;
		
		$content_applicant_en = elgg_echo('missions:application_notice_sentence', 'en') . '<br>';
		$content_applicant_fr = elgg_echo('missions:application_notice_sentence', 'fr') . '<br>';
		$content_applicant_en .= '<br>'.elgg_echo('missions:see_full_profile','en') . ': '; 
		$content_applicant_fr .= '<br>'.elgg_echo('missions:see_full_profile','fr') . ': '; 
	
		$content_applicant_en .= '<a href="'.$user_entity->getURL().'">'.$user_entity->username.'<a/><br>';
		$content_applicant_fr .= '<a href="'.$user_entity->getURL().'">'.$user_entity->username.'<a/><br>';
		
		$content_applicant_en .= elgg_echo('missions:see_full_mission','en') . ': '; 
		$content_applicant_fr .= elgg_echo('missions:see_full_mission','fr') . ': '; 
	
		$content_applicant_en .= '<a href="'.$entity->getURL().'">'.$entity->job_title.'<a/><br>';
		$content_applicant_fr .= '<a href="'.$entity->getURL().'">'.$entity->job_title.'<a/><br>';
		
		$content_applicant_en .=  '<br>'.elgg_echo('missions:from_message',array($user_entity->username),'en').'<br><span style="font-style: italic;">'.$message . '</span><br>';
		$content_applicant_fr .=  '<br>'.elgg_echo('missions:from_message',array($user_entity->username),'fr').'<br><span style="font-style: italic;">'.$message . '</span><br>';
	
		// Lists all educations of the applicant.
		$education_list = $user_entity->education;
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
		$experience_list = $user_entity->work;
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
		$skill_list = $user_entity->gc_skills;
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
				'href' => elgg_get_site_url() . 'missions/mission-offer/' . $entity->guid . '/' . $user_entity->guid,
				'text' => '<br>'.elgg_echo('missions:offer','en')
		));
	
		$content_applicant_fr .= elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'missions/mission-offer/' . $entity->guid . '/' . $user_entity->guid,
				'text' => '<br>'.elgg_echo('missions:offer','fr')
		));
	
		$subject = elgg_echo('missions:application_to','en') . $entity->job_title.' | '.elgg_echo('missions:application_to','fr') . $entity->job_title;

		mm_notify_user($entity->guid, $user_entity->guid, $subject,$title_applicant_en,$title_applicant_fr, $content_applicant_en, $content_applicant_fr);
		
	}
	
	// Opt in applicant if they are not opted in yet.
	if(!check_if_opted_in($user_entity)) {
		$user_entity->opt_in_missions = 'gcconnex_profile:opt:yes';
		$user_entity->save();
	}
	return $message_info;

}

function withdraw_post($user,$message,  $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Opportunity was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'mission')) {
		return "Invalid opportunity. Please try a different GUID";
	}

	// Deletes the tentative relationship between mission and applicant.
if(check_entity_relationship($entity->guid, 'mission_tentative', $user_entity->guid)) {
	$message_return = 'missions:declination_has_been_sent';
	remove_entity_relationship($entity->guid, 'mission_tentative', $user_entity->guid);
}
if(check_entity_relationship($entity->guid, 'mission_applied', $user_entity->guid)) {
	$message_return = 'missions:withdrawal_has_been_sent';
	remove_entity_relationship($entity->guid, 'mission_applied', $user_entity->guid);
}
if(check_entity_relationship($entity->guid, 'mission_offered', $user_entity->guid)) {
	$message_return = 'missions:declination_has_been_sent';
	remove_entity_relationship($entity->guid, 'mission_offered', $user_entity->guid);
}
if(check_entity_relationship($entity->guid, 'mission_accepted', $user_entity->guid)) {
	$message_return = 'missions:withdrawal_has_been_sent';
	remove_entity_relationship($entity->guid, 'mission_accepted', $user_entity->guid);
  mm_complete_mission_inprogress_reports($entity, true);
}

$reason = array('workload', 'interest', 'engagement', 'approval');
if (in_array($message,$reason)){
	$reasonEn = elgg_echo('missions:decline:'.$message,'en');
	$reasonFr = elgg_echo('missions:decline:'.$message,'fr');
}else{
	$reasonEn = $message;
	$reasonFr = $message;
}

$mission_link = '<a href="'.$entity->getURL().'" >'.elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')).' </a>';
$subject = elgg_echo('missions:applicant_leaves', array($user_entity->name),'en')." | ". elgg_echo('missions:applicant_leaves', array($user_entity->name),'fr');

$withdrawnEn .= elgg_echo('missions:applicant_leaves_more', array($user_entity->name),'en') . $mission_link . '.' . "\n";
$withdrawnReasonEn .= elgg_echo('missions:reason_given', array($reasonEn),'en');

$withdrawnFr .= elgg_echo('missions:applicant_leaves_more', array($user_entity->name),'fr') . $mission_link . '.' . "\n";
$withdrawnReasonFr .= elgg_echo('missions:reason_given', array($reasonFr),'fr');

mm_notify_user($entity->guid, $user_entity->guid, $subject, $withdrawnEn, $withdrawnFr,$withdrawnReasonEn ,$withdrawnReasonFr );


	return elgg_echo($message_return, array($entity->job_title));
	

}

function accept_post($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Opportunity was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'mission')) {
		return "Invalid opportunity. Please try a different GUID";
	}

	if(check_entity_relationship($entity->guid, 'mission_offered', $user_entity->guid)) {

		remove_entity_relationship($entity->guid, 'mission_offered', $user_entity->guid);
		add_entity_relationship($entity->guid, 'mission_accepted', $user_entity->guid);
	}
	$mission_link = '<a href="'.$entity->getURL().'">'.$entity->title.'</a>';

		// notify participant
		$subject = elgg_echo('missions:participating_in', array(elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'en').' | '.elgg_echo('missions:participating_in', array(elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))),'fr');
		$message_en = elgg_echo('missions:participating_in_more', array($user_entity->name),'en') . $mission_link . '.';
		$message_fr = elgg_echo('missions:participating_in_more', array($user_entity->name),'fr') . $mission_link . '.';

		mm_notify_user($user_entity->guid, $entity->guid, $subject, '','',$message_en,$message_fr);

		// notify owner
		$subject = elgg_echo( 'missions:participating_in2', array($user_entity->name),'en').' | '.elgg_echo( 'missions:participating_in2', array($user_entity->name),'fr');
		$message_en = elgg_echo('missions:participating_in2_more', array($user_entity->name),'en') . $mission_link . '.';
		$message_fr = elgg_echo('missions:participating_in2_more', array($user_entity->name),'fr') . $mission_link . '.';

		mm_notify_user($entity->guid, $user_entity->guid, $subject, '','',$message_en,$message_fr);
	
	return elgg_echo('missions:now_participating_in_mission', array($entity->job_title));
}

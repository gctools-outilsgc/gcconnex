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

elgg_ws_expose_function(
	"create.opportinities1",
	"create_opportinities1",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"formData" => array('type' => 'array', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"create.opportinities2",
	"create_opportinities2",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"formData" => array('type' => 'array', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"create.opportinities3",
	"create_opportinities3",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"formData" => array('type' => 'array', 'required' => true),	
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

function create_opportinities1($user, $formData, $lang)
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



	elgg_make_sticky_form('firstfill');
	$_SESSION['mission_duplicating_override_first'] = true;
	unset($_SESSION['mission_uncheck_post_mission_disclaimer']);
	
	$err = '';
	
	$first_form = elgg_get_sticky_values('firstfill');

	$first_form['name'] = $formData["name"];
	$first_form['department'] = $formData["departement"];
	$first_form['email'] = $formData["email"];
	$first_form['phone'] = $formData["phone"];
	$first_form['disclaimer'] = $formData["agree"];

	// Error checking function.
$err .= mm_first_post_error_check($first_form);
	if ($err == '') {
		$_SESSION['missions_pass_department_to_second_form'] = mo_get_last_input_node($first_form);
		forward(elgg_get_site_url() . 'missions/mission-post/step-two');
	} else {
		error_log('error in first form: '.$err);
	}


	return $formData["name"];
}


function create_opportinities2($user, $formData, $lang)
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

	elgg_make_sticky_form('secondfill');
	$_SESSION['mission_duplicating_override_second'] = true;
	
	$err = '';
	$first_form = elgg_get_sticky_values('firstfill');
	$second_form = elgg_get_sticky_values('secondfill');

	$second_form['job_title'] = $formData["name"];
	$second_form['role_type'] = $formData["offert"];
	$second_form['job_type'] = $formData["type"];
	$second_form['job_area'] = $formData["program"];
	$second_form['number'] = $formData["num_opt"];
	$second_form['start_date'] = $formData["start_date"];
	$second_form['completion_date'] = $formData["completion_date"];
	$second_form['deadline'] = $formData["deadline"];
	$second_form['description'] = $formData["description"];
	
	// Error checking function.
	$err .= mm_first_post_error_check($first_form);
	$err .= mm_second_post_error_check($second_form);
	
	if ($err == '') {
		forward(elgg_get_site_url() . 'missions/mission-post/step-three');
	} else {
		error_log('error in first form: '.$err);
	}
	


	error_log('first :'.print_r($first_form,true));
	error_log('second :'.print_r($second_form,true));
	return $formData["title"];
}

function create_opportinities3($user, $formData,$lang)
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

elgg_make_sticky_form('thirdfill');
elgg_make_sticky_form('ldropfill');
elgg_make_sticky_form('tdropfill');
$_SESSION['mission_duplicating_override_third'] = true;

$first_form = elgg_get_sticky_values('firstfill');
$second_form = elgg_get_sticky_values('secondfill');
$third_form = elgg_get_sticky_values('thirdfill');







$err = '';

// Error checking function.
$first_form['name'] = $first_form['formData']["name"];
$first_form['department'] = $first_form['formData']["departement"];
$first_form['email'] = $first_form['formData']["email"];
$first_form['phone'] = $first_form['formData']["phone"];
$first_form['disclaimer'] = $first_form['formData']["agree"];

 $err .= mm_first_post_error_check($first_form);
 $second_form['job_title'] = $second_form['formData']["title"];
 $second_form['role_type'] = $second_form['formData']["offert"];
 $second_form['job_type'] = $second_form['formData']["type"];
 $second_form['job_area'] = $second_form['formData']["program"];
 $second_form['number'] = $second_form['formData']["num_opt"];
 $second_form['start_date'] = $second_form['formData']["start_date"];
 $second_form['completion_date'] = $second_form['formData']["completion_date"];
 $second_form['deadline'] = $second_form['formData']["deadline"];
 $second_form['description'] = $second_form['formData']["description"];
 error_log(print_r($second_form,true));

 $err .= mm_second_post_error_check($second_form);

 $third_form['key_skills'] = $third_form['formData']["skills"];
 $third_form['time_commitment'] = $third_form['formData']["hours"];
 $third_form['time_interval'] = $third_form['formData']["repetition"];
 $third_form['timezone'] = $third_form['formData']["timezone"];
 $third_form['mon_start'] = $third_form['formData']["mon_start"];
 $third_form['mon_duration'] = $third_form['formData']["mon_duration"];
 $third_form['tue_start'] = $third_form['formData']["tue_start"];
 $third_form['tue_duration'] = $third_form['formData']["tue_duration"];
 $third_form['wed_start'] = $third_form['formData']["wed_start"];
 $third_form['wed_duration'] = $third_form['formData']["wed_duration"];
 $third_form['thu_start'] = $third_form['formData']["thu_start"];
 $third_form['thu_duration'] = $third_form['formData']["thu_duration"];
 $third_form['fri_start'] = $third_form['formData']["fri_start"];
 $third_form['fri_duration'] = $third_form['formData']["fri_duration"];
 $third_form['sat_start'] = $third_form['formData']["sat_start"];
 $third_form['sat_duration'] = $third_form['formData']["sat_duration"];
 $third_form['sun_start'] = $third_form['formData']["sun_start"];
 $third_form['sun_duration'] = $third_form['formData']["sun_duration"];
 $third_form['remotely'] = $third_form['formData']["remotly"];
 $third_form['location'] = $third_form['formData']["location"];
 $third_form['security'] = $third_form['formData']["security"];

 $err .= mm_third_post_error_check($third_form);

// A specialized function for checking for errors in the time fields
$err .= mm_validate_time_all($third_form);

 if($err == '') {
 	$err .= mm_third_post_special_error_check($third_form);
 }
 if ($err != '') {
	error_log('error in first form: '.$err);
	return $err;

}else {

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
//Compare email and username for user with more than one account
		foreach ($accounts as $key) {
			if($key->name == $first_form['name']){
				$guid_account[] = $key;
			}
		}

		if($guid_account){
			    $mission->account = array_pop($guid_account)->guid;
		}else{
			    $mission->account = array_pop($accounts)->guid;
		}


    $mission->job_title = $second_form['job_title'];
    $mission->role_type = $second_form['role_type'];
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

    // Generate an analytics record to track "posted".
    $analytics_record = new ElggObject();
    $analytics_record->subtype = 'mission-posted';
    $analytics_record->title = 'Mission Posted Report';
    $analytics_record->mission_guid = $mission->guid;
    $analytics_record->access_id = ACCESS_LOGGED_IN;
    $analytics_record->save();

    // Creates a relationships between the user (manager) and the mission.
    add_entity_relationship($mission->account, 'mission_posted', $mission->guid);

    // Add to the river so it can be seen on the main page.
    elgg_create_river_item(array(
        'view' => 'river/object/mission/create',
        'action_type' => 'create',
        'subject_guid' => $mission->owner_guid,
        'object_guid' => $mission->getGUID()
    ));

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
    	return elgg_echo('missions:succesfully_posted', array($mission->job_title));
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
	
return 'Post with success ';
}

	
}
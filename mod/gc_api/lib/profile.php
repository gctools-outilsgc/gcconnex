<?php

elgg_ws_expose_function("get.profile","get_api_profile", array("id" => array('type' => 'string')),
	'provide user GUID number and all profile information is returned',
               'GET', false, false);

function get_api_profile($id){
	global $CONFIG;
	//$string = "User was not found. Please try a different GUID, username, or email address";
	if (is_numeric($id)){
		$user_entity = get_user($id);
		//$string = $user_entity->username;
	}
	else{
		if (strpos($id, '@')){
			$user_entity = get_user_by_email($id);
			if (is_array($user_entity)){
				if (count($user_entity)>1)
					//$string = "Found more than 1 user, please use username or GUID";
					return "Found more than 1 user, please use username or GUID";
				else{
					$user_entity = $user_entity[0];
					//$string = $user_entity->username;
				}
			}
		}else{
			$user_entity = get_user_by_username($id);
			//$string = $user_entity->username;
		}
		
		
	}
	if (!$user_entity)
		return "User was not found. Please try a different GUID, username, or email address";
	
	//$user['test'] = $CONFIG->view_types;

	$user['id'] = $user_entity->guid;

	$user['username'] = $user_entity->username;

	//get and store user display name
	$user['dispalyName'] = $user_entity->name;

	//get and store URL for profile
	$user['profileURL'] = $user_entity->getURL();

	//get and store URL of profile avatar
	$user['iconURL'] = $user_entity->geticon();

	
	$user['jobTitle'] = $user_entity->job;

	$user['department'] = $user_entity->department;

	$user['telephone'] = $user_entity->phone;

	$user['mobile'] = $user_entity->mobile;

	$user['Website'] = $user_entity->website;

	if ($user_entity->facebook)
		$user['links']['facebook'] = "http://www.facebook.com/".$user_entity->facebook;
	if($user_entity->google)
		$user['links']['google'] = "http://www.google.com/".$user_entity->google;
	if($user_entity->github)
		$user['links']['github'] = "https://github.com/".$user_entity->github;
	if($user_entity->twitter)
		$user['links']['twitter'] = "https://twitter.com/".$user_entity->twitter;
	if($user_entity->linkedin)
		$user['links']['linkedin'] = "http://ca.linkedin.com/in/".$user_entity->linkedin;
	if($user_entity->pinterest)
		$user['links']['pinterest'] = "http://www.pinterest.com/".$user_entity->pinterest;
	if($user_entity->tumblr)
		$user['links']['tumblr'] = "https://www.tumblr.com/blog/".$user_entity->tumblr;
	if($user_entity->instagram)
		$user['links']['instagram'] = "http://instagram.com/".$user_entity->instagram;
	if($user_entity->flickr)
		$user['links']['flickr'] = "http://flickr.com/".$user_entity->flickr;
	if($user_entity->youtube)
		$user['links']['youtube'] = "http://www.youtube.com/".$user_entity->youtube;

	////////////////////////////////////////////////////////////////////////////////////
	//about me
	////////////////////////////////////////////////////////////////////////
	$aboutMeMetadata = elgg_get_metadata(array('guids'=>array($user['id']),'limit'=>0,'metadata_names'=>array('description')));
	
	if ($aboutMeMetadata[0]->access_id==2)
		$user['about_me'] = $aboutMeMetadata[0]->value;
	
	/////////////////////////////////////////////////////////////////////////////////
	//eductation
	//////////////////////////////////////////////////////////////////////
	$eductationEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'education',
		'type' => 'object',
		'limit' => 0
		));
	$i=0;
	foreach ($eductationEntity as $school){
		if($school->access_id==2){

			$user['education']['item_'.$i]['school_name'] = $school->school;
			
			$user['education']['item_'.$i]['start_date'] = buildDate($school->startdate, $school->startyear);
			
			if($school->ongoing == "false"){
				$user['education']['item_'.$i]['end_date'] = buildDate($school->enddate,$school->endyear);
			}else{
				$user['education']['item_'.$i]['end_date'] = "present/actuel";
			}
			$user['education']['item_'.$i]['degree'] = $school->degree;
			$user['education']['item_'.$i]['field_of_study'] = $school->field;
			$i++;
		}
	}
	////////////////////////////////////////////////////////
	//experience
	//////////////////////////////////////
	$experienceEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'experience',
		'type' => 'object',
		'limit' => 0
		));
	$i=0;
	foreach ($experienceEntity as $job){
		//$user['job'.$i++] = "test";
		if($job->access_id == 2){
			$jobMetadata = elgg_get_metadata(array(
				'guid' => $job->guid,
				'limit' => 0
				));
			//foreach ($jobMetadata as $data)
			//	$user['job'][$i++][$data->name] = $data->value;

			$user['experience']['item_'.$i]['job_title'] = $job->title;
			$user['experience']['item_'.$i]['organization'] = $job->organization;
			$user['experience']['item_'.$i]['start_date'] = buildDate($job->startdate, $job->startyear);
			if ($job->ongoing == "false"){
				$user['experience']['item_'.$i]['end_date'] = buildDate($job->enddate, $job->endyear);
			}else{
				$user['experience']['item_'.$i]['end_date'] = "present/actuel";
			}
			$user['experience']['item_'.$i]['responsibilities'] = $job->responsibilities;
			//$user['experience']['item_'.$i]['colleagues'] = $job->colleagues;
			$j = 0;
			if (is_array($job->colleagues)){
				foreach($job->colleagues as $friend){
					$friendEntity = get_user($friend);
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["id"] = $friendEntity->guid;
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["username"] = $friendEntity->username;
	
					//get and store user display name
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["displayName"] = $friendEntity->name;
	
					//get and store URL for profile
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["profileURL"] = $friendEntity->getURL();
	
					//get and store URL of profile avatar
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["iconURL"] = $friendEntity->geticon();
					$j++;
				}
			}elseif(!is_null($job->colleagues)){
				$friendEntity = get_user($job->colleagues);
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["id"] = $friendEntity->guid;
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["username"] = $friendEntity->username;
	
				//get and store user display name
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["displayName"] = $friendEntity->name;
		
				//get and store URL for profile
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["profileURL"] = $friendEntity->getURL();
	
				//get and store URL of profile avatar
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["iconURL"] = $friendEntity->geticon();
					
			}
			$i++;
		}
	}
	/////////////////////////////////////////////////////////
	//Skills
	///////////////////////////////////////////////////////
	$skillsEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'MySkill',
		'type' => 'object',
		'limit' => 0
		));
	$i=0;
	foreach($skillsEntity as $skill){
		$user['skills']['item_'.$i]['skill'] = $skill->title;
		//$user['skills']['item_'.$i]['endorsements'] = $skill->endorsements;
		$j = 0;
		if(is_array($skill->endorsements)){
			foreach($skill->endorsements as $friend){
				$friendEntity = get_user($friend);
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["id"] = $friendEntity->guid; 
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["username"] = $friendEntity->username;
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["displayName"] = $friendEntity->name;
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["profileURL"] = $friendEntity->getURL();
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["iconURL"] = $friendEntity->geticon();
				$j++;
			}
		}elseif(!is_null($skill->endorsements)){
			$friendEntity = get_user($skill->endorsements);
			$user['skills']['item_'.$i]['endorsements']["user_".$j]["id"] = $friendEntity->guid; 
			$user['skills']['item_'.$i]['endorsements']["user_".$j]["username"] = $friendEntity->username;
			$user['skills']['item_'.$i]['endorsements']["user_".$j]["displayName"] = $friendEntity->name;
			$user['skills']['item_'.$i]['endorsements']["user_".$j]["profileURL"] = $friendEntity->getURL();
			$user['skills']['item_'.$i]['endorsements']["user_".$j]["iconURL"] = $friendEntity->geticon();
		}
		$i++;
	}
	/////////////////////////////////////////////////////////////////////////////////////////
	//Language
	////////////////////////////////////////////////////////////////////
	$user['language']["format"] = "Written Comprehension / Written Expression / Oral Proficiency";
	$languageMetadata =  elgg_get_metadata(array(
		'guid'=>$user['id'],
		'limit'=>0,
		'metadata_name'=>'english'
		));
	if (!is_null($languageMetadata)){
		$i = 0;
		foreach($languageMetadata as $grade){
			if($grade->access_id == 2){
				
				if($i < 3)
					$user['language']["english"]['level'] .= $grade->value;
				if($i<2){
					$user['language']["english"]['level'].=" / ";
				}
				if($i == 3)
					$user['language']["english"]['expire'] = $grade->value;
			}
			$i++;
		}
	}
	$languageMetadata =  elgg_get_metadata(array(
		'guid'=>$user['id'],
		'limit'=>0,
		'metadata_name'=>'french'
		));
	if (!is_null($languageMetadata)){
		$i = 0;
		foreach($languageMetadata as $grade){
			if($grade->access_id == 2){
				if ($i<3)
					$user['language']["french"]['level'] .= $grade->value;
				if($i<2){
					$user['language']["french"]['level'] .= " / ";
				}
				if($i == 3)
					$user['language']["french"]['expire'] = $grade->value;
			}
			$i++;
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////
	//portfolio
	///////////////////////////////////////////////////////////////////
	$portfolioEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'portfolio',
		'type' => 'object',
		'limit' => 0
		));
	$i=0;
	foreach($portfolioEntity as $portfolio){
		if($grade->access_id == 2){
			$user['portfolio']['item_'.$i]['title'] = $portfolio->title;
			$user['portfolio']['item_'.$i]['link'] = $portfolio->link;
			if($portfolio->datestamped == "on")
				$user['portfolio']['item_'.$i]['date'] = $portfolio->publishdate;
			$user['portfolio']['item_'.$i]['description'] = $portfolio->description;
		}
	}

	$user['dateJoined'] = date("Y-m-d H:i:s",$user_entity->time_created);

	$user['lastActivity'] = date("Y-m-d H:i:s",$user_entity->last_action);

	$user['lastLogin'] = date("Y-m-d H:i:s",$user_entity->last_login);



	return $user;
}

function buildDate($month, $year){
	switch($month){
		case 1:
			$string = "01/";
		case 2:
			$string = "02/";
		case 3:
			$string = "03/";
		case 4:
			$string = "04/";
		case 5:
			$string = "05/";
		case 6:
			$string = "06/";
		case 7:
			$string = "07/";
		case 8:
			$string = "08/";
		case 9:
			$string = "09/";
		case 10:
			$string = "10/";
		case 11:
			$string = "11/";
		case 12:
			$string = "12/";
	}	
	return $string.$year;

}
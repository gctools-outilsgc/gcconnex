<?php

elgg_ws_expose_function("get.profile","get_api_profile", array("id" => array('type' => 'string')),
	'provide user GUID number and all profile information is returned',
               'GET', false, false);

elgg_ws_expose_function("push.profile","profilePush", array("id" => array('type' => 'string'), "data" => array('type'=>'string')),
	'update a user profile based on id passed',
               'GET', true, false);

function get_api_profile($id){
	global $CONFIG;
	//$string = "User was not found. Please try a different GUID, username, or email address";
	$user_entity = getUserFromID($id);
	if (!$user_entity)
		return "User was not found. Please try a different GUID, username, or email address";
	
	//$user['test'] = $CONFIG->view_types;

	$user['id'] = $user_entity->guid;

	$user['username'] = $user_entity->username;

	//get and store user display name
	$user['displayName'] = $user_entity->name;

	$user['email'] = $user_entity->email;

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
	usort($experienceEntity, "sortDate");
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
	elgg_set_ignore_access(true);
	if($user_entity->skill_access == ACCESS_PUBLIC)
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
	elgg_set_ignore_access(false);
	/////////////////////////////////////////////////////////////////////////////////////////
	//Language
	////////////////////////////////////////////////////////////////////
	//$user['language']["format"] = "Written Comprehension / Written Expression / Oral Proficiency";
	/*$languageMetadata =  elgg_get_metadata(array(
		'guid'=>$user['id'],
		'limit'=>0,
		'metadata_name'=>'english'
		));
	if (!is_null($languageMetadata)){
		if($languageMetadata[0]->access_id == 2){
			$user['language']["format"] = "Written Comprehension / Written Expression / Oral Proficiency";
		}
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
	}*/
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

function profilePush($id, $data){
	$user_entity = getUserFromID($id);
	if (!$user_entity){
		return "Not a valid user";
	}
	$userDataObj = json_decode($data, true);
	if (json_last_error() !== 0){
		return "invalid JSON format of data";
	}

	/*
{ 
	"name": {
		"firstName": "Troy",
		"lastName": "Lawson"
	},
	"title": "GCconnex King",
	"classification": {
		"group": "CS",
		"level": "03"
	},
	"department":{
		"en": "Treasury Board of Canada Secretariat",
		"fr":	"Secrétariat Conseil du Trésor du Canada"
	},
	"branch":{
		"en": "Information Management and Technology Directorate",
		"fr": "Direction générale de la gestion d'information et de la technologie"
	},
	"sector":{
		"en": "Corporate Services Sector",
		"fr": "Secteur des services ministériels"
	},
	"location":{
		"en": {
			"street": "140 O'Connor St",
			"city": "Ottawa",
			"province": "Ontario",
			"postalCode": "K1A 0R5",
			"country": "Canada",
			"building": "L'Esplanade Laurier",
			"floor": "6",
			"officeNum": "06062"
		},
		"fr": {
			"street": "140, rue O'Connor",
			"city": "Ottawa",
			"province": "Ontario",
			"postalCode": "K1A 0R5",
			"country": "Canada",
			"building": "L'Esplanade Laurier",
			"floor": "6",
			"officeNum": "06062"			
		}
	},
	"phone": "613-979-0315",
	"mobile": "613-979-0315",
	"email": "Troy.Lawson@tbs-sct.gc.ca",
	"secondLanguage": {
		"firstLang": "en",
		"secondLang": {
			"lang": "fr",
			"writtenComp": {
				"level": "B",
				"expire": "2016-12-29"
			},
			"writtenExpression": {
				"level": "C",
				"expire": "2016-12-29"
			},
			"oral": {
				"level": "B",
				"expire": "2016-12-29"
			}
			
		}
	}
}
	*
	*
	*/
	foreach ($userDataObj as $field => $value){
		switch($field){
			case 'name':
				//error_log(json_encode($value));
				$nameData = json_decode(json_encode($value), true);

				$name = $nameData["firstName"].' '.$nameData["lastName"];
				//error_log($name);
				$user_entity->set('name', $name);
				break;
			case 'title':
				//error_log($user_entity->language);
				//error_log(json_encode($value));
				$langaugeData = json_decode(json_encode($value), true);
				if ($user_entity->language === 'fr'){
					$user_entity->set('job', $langaugeData['fr'].' / '.$langaugeData['en']);
				}
				else{
					$user_entity->set('job', $langaugeData['en'].' / '.$langaugeData['fr']);
				}
				
				break;
			case 'classification':
				//error_log(json_encode($value));
				$user_entity->set('classification', json_encode($value));
				break;
			case 'department':
				//error_log(json_encode($value));
				$deptData = json_decode(json_encode($value), true);
				if ($user_entity->language === 'fr'){
					$user_entity->set('department', $deptData['fr'].' / '.$deptData['en']);
				}
				else{
					$user_entity->set('department', $deptData['en'].' / '.$deptData['fr']);
				}


				break;
			case 'branch':
				//error_log(json_encode($value));
				break;
			case 'sector':
				//error_log(json_encode($value));
				break;
			case 'location':
				//error_log(json_encode($value));
				//error_log(json_encode($value["en"]));
				//error_log(json_encode($value["fr"]));
				$user_entity->set('addressString', json_encode($value["en"]));
				$user_entity->set('addressStringFr', json_encode($value["fr"]));
				break;
			case 'phone':
				//error_log(json_encode($value));
				$user_entity->set('phone', $value);
				break;
			case 'mobile':
				//error_log(json_encode($value));
				$user_entity->set('mobile', $value);
				break;
			case 'email':
				//error_log(json_encode($value));
				$user_entity->set('email', $value);
				break;
			case 'secondLanguage':
				//error_log(json_encode($value));
				//$user->english = $english;
            	//$user->french = $french;
				$user_entity->set('english', $value["ENG"]);
				$user_entity->set('french', $value["FRA"]);
            	$user_entity->set('officialLanguage', $value["firstLanguage"]);

				break;
		}
	}
	$user_entity->save();
	return 'success';
}

function getUserFromID($id){
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
	return $user_entity;
}

function buildDate($month, $year){
	switch($month){
		case 1:
			$string = "01/";
			break;
		case 2:
			$string = "02/";
			break;
		case 3:
			$string = "03/";
			break;
		case 4:
			$string = "04/";
			break;
		case 5:
			$string = "05/";
			break;
		case 6:
			$string = "06/";
			break;
		case 7:
			$string = "07/";
			break;
		case 8:
			$string = "08/";
			break;
		case 9:
			$string = "09/";
			break;
		case 10:
			$string = "10/";
			break;
		case 11:
			$string = "11/";
			break;
		case 12:
			$string = "12/";
			break;
	}	
	return $string.$year;

}
<?php

//global $CONFIG;
//error_log($CONFIG->dbhost.' '.$CONFIG->dbuser.' '.$CONFIG->dbpass.' '.$CONFIG->dbname);

elgg_ws_expose_function("get.profile","get_api_profile", array("id" => array('type' => 'string')),
	'provide user GUID number and all profile information is returned',
               'GET', false, false);

elgg_ws_expose_function("profile.update","profileUpdate", array("id" => array('type' => 'string'), "data" => array('type'=>'string')),
	'update a user profile based on id passed',
               'POST', true, false);

elgg_ws_expose_function("profile.create","profileCreate", array("data" => array('type'=>'string')),
	'Create a new user profile, issue a password reset on the newly created profile and pre-populate profile fields based on data passed in. Returns guid of newly created user',
               'POST', true, false);

function get_api_profile($id){
	//global $CONFIG;
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

function profileUpdate($id, $data){
	global $CONFIG;
	$response['error'] = 0;
	$user_entity = getUserFromID($id);
	if (!$user_entity){
		$response['error'] = 1;
		$response['message'] = 'Invalid user id, username, or email';
		return $response;
		//return "Not a valid user";
	}
	
	if ($data == ''){
		$response['error'] = 2;
		$response['message'] = 'data must be a string representing a JSON object.';
		return $response;
	}
	$userDataObj = json_decode($data, true);
	if (json_last_error() !== 0){
		$response['error'] = 2;
		$response['message'] = 'invalid JSON - data was unable to be parsed';
		return $response;
		//return "invalid JSON format of data";
	}
	
	//error_log(json_encode($userDataObj));
	/*
{ 
	"name": {
		"firstName": "Troy",
		"lastName": "Lawson"
	},
	"title": {
		"en": "GCconnex King",
		"fr": "le King"
	},
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
		//error_log('in loop');
		switch($field){
			case 'name':
			elgg_set_ignore_access(true);
			
				//error_log(json_encode($value));
				$nameData = json_decode(json_encode($value), true);
				if (!isset($nameData["firstName"])&&!isset($nameData["lastName"])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing first and last name';
						return $response;

				}
				if (!isset($nameData["firstName"])||!isset($nameData["lastName"])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing first or last name';
						return $response;

				}
				

				$name = $nameData["firstName"].' '.$nameData["lastName"];
				//error_log($name);
				//$user_entity->set('name', $name);
				//$owner = get_entity($id);
				if (elgg_strlen($name) > 50) {
					register_error(elgg_echo('user:name:fail'));

				} elseif ($user_entity->name != $name) {
										
					//$user=get_user($user_entity->guid);
					$user_entity->name= $name;
					$user_entity->save();
					
				}
				elgg_set_ignore_access(false);
				break;
			case 'title':
				
				$titleData = json_decode(json_encode($value), true);
				if (!isset($titleData['fr'])&&!isset($titleData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing french and english title';
						return $response;

				}
				if (!isset($titleData['fr'])||!isset($titleData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing french or english title';
						return $response;

				}
				
				if ($user_entity->language === 'fr'){
					$user_entity->set('job', $titleData['fr'].' / '.$titleData['en']);
				}
				else{
					$user_entity->set('job', $titleData['en'].' / '.$titleData['fr']);
				}
				
				break;
			case 'classification':
				//error_log(json_encode($value));
				$classificationData = json_decode(json_encode($value), true);
				if (!isset($classificationData['group'])&&!isset($classificationData['level'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing classification group and level';
						return $response;

				}
				if (!isset($classificationData['group'])||!isset($classificationData['level'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing classification group or level';
						return $response;

				}
				
				$user_entity->set('classification', json_encode($value));
				break;
			case 'department':
				$deptData = json_decode(json_encode($value), true);
				if (!isset($deptData['fr'])&&!isset($deptData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - department format';
						return $response;

				}
				if (!isset($deptData['fr'])||!isset($deptData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing french or english department';
						return $response;

				}
				

				$obj = elgg_get_entities(array(
   					'type' => 'object',
   					'subtype' => 'dept_list',
   					'owner_guid' => 0
				));
				$deptListEn = json_decode($obj[0]->deptsEn, true);
				$provinces = array();
				$provinces['pov-alb'] = 'Government of Alberta';
				$provinces['pov-bc'] = 'Government of British Columbia';
				$provinces['pov-man'] = 'Government of Manitoba';
				$provinces['pov-nb'] = 'Government of New Brunswick';
				$provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
				$provinces['pov-ns'] = 'Government of Nova Scotia';
				$provinces['pov-nwt'] = 'Government of Northwest Territories';
				$provinces['pov-nun'] = 'Government of Nunavut';
				$provinces['pov-ont'] = 'Government of Ontario';
				$provinces['pov-pei'] = 'Government of Prince Edward Island';
				$provinces['pov-que'] = 'Government of Quebec';
				$provinces['pov-sask'] = 'Government of Saskatchewan';
				$provinces['pov-yuk'] = 'Government of Yukon';
				$deptAndProvincesEn = array_merge($deptListEn,$provinces);


				$deptListFr = json_decode($obj[0]->deptsFr, true);
				$provinces = array();
				$provinces['pov-alb'] = "Gouvernement de l'Alberta";
				$provinces['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
				$provinces['pov-man'] = 'Gouvernement du Manitoba';
				$provinces['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
				$provinces['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
				$provinces['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
				$provinces['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
				$provinces['pov-nun'] = 'Gouvernement du Nunavut';
				$provinces['pov-ont'] = "Gouvernement de l'Ontario";
				$provinces['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
				$provinces['pov-que'] = 'Gouvernement du Québec';
				$provinces['pov-sask'] = 'Gouvernement de Saskatchewan';
				$provinces['pov-yuk'] = 'Gouvernement du Yukon';
				$deptAndProvincesFr = array_merge($deptListFr,$provinces);

				if(!in_array($deptData['en'], $deptAndProvincesEn)){
						$response['error'] = 5;
						$response['message'] = 'invalid english department name. valid names: '.json_encode($deptAndProvincesEn);
						return $response;
				}

				if(!in_array($deptData['fr'], $deptAndProvincesFr)){
						$response['error'] = 5;
						$response['message'] = 'invalid french department name. valid names: '.json_encode($deptAndProvincesFr);
						return $response;
				}
				//error_log(json_encode($value));
				
				if ($user_entity->language === 'fr'){
					$user_entity->set('department', $deptData['fr'].' / '.$deptData['en']);
				}
				else{
					$user_entity->set('department', $deptData['en'].' / '.$deptData['fr']);
				}


				break;
			case 'branch':
				$branchData = json_decode(json_encode($value), true);
				if (!isset($branchData['en'])&&!isset($branchData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english and french branch name';
						return $response;

				}
				if (!isset($branchData['en'])||!isset($branchData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english or french branch name';
						return $response;

				}
				
				$user_entity->set('branch', json_encode($value));
				break;
			case 'sector':
				$sectorData = json_decode(json_encode($value), true);
				if (!isset($sectorData['en'])&&!isset($sectorData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english and french sector name';
						return $response;

				}
				if (!isset($sectorData['en'])||!isset($sectorData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english or french sector name';
						return $response;

				}
				
				$user_entity->set('sector', json_encode($value));
				break;
			case 'location':
				if (!isset($value['en'])){
						$response['error'] = 4;
						$response['message'] = 'missing english location data';
						return $response;

				}
				$locationData = json_decode(json_encode($value['en']), true);
				if(!isset($locationData['street'])&&!isset($locationData['city'])&&!isset($locationData['province'])&&!isset($locationData['postalCode'])&&!isset($locationData['country'])&&!isset($locationData['building'])&&!isset($locationData['floor'])&&!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'invalid location data';
						return $response;
				}
				if(!isset($locationData['street'])||!isset($locationData['city'])||!isset($locationData['province'])||!isset($locationData['postalCode'])||!isset($locationData['country'])||!isset($locationData['building'])||!isset($locationData['floor'])||!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'missing location data';
						return $response;
				}
				
				if (!isset($value['fr'])){
						$response['error'] = 4;
						$response['message'] = 'missing french location data';
						return $response;

				}
				$locationData = json_decode(json_encode($value['fr']), true);
				if(!isset($locationData['street'])&&!isset($locationData['city'])&&!isset($locationData['province'])&&!isset($locationData['postalCode'])&&!isset($locationData['country'])&&!isset($locationData['building'])&&!isset($locationData['floor'])&&!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'invalid location data';
						return $response;
				}
				if(!isset($locationData['street'])||!isset($locationData['city'])||!isset($locationData['province'])||!isset($locationData['postalCode'])||!isset($locationData['country'])||!isset($locationData['building'])||!isset($locationData['floor'])||!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'missing location data';
						return $response;
				}
				
				$user_entity->set('addressString', json_encode($value["en"]));
				$user_entity->set('addressStringFr', json_encode($value["fr"]));
				break;
			case 'phone':
				
				$user_entity->set('phone', $value);
				break;
			case 'mobile':
				
				$user_entity->set('mobile', $value);
				break;
			case 'email':
				
				elgg_set_ignore_access(true);
				$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname)or die(mysqli_error($connection));
				//error_log($CONFIG->dbhost.' '.$CONFIG->dbuser.' '.$CONFIG->dbpass.' '.$CONFIG->dbname);
				mysqli_select_db($connection,$CONFIG->dbname);
				$emaildomain = explode('@',filter_var($value, FILTER_SANITIZE_EMAIL));
				$query = "SELECT count(*) AS num FROM email_extensions WHERE ext ='".$emaildomain[1]."'";
			
				$result = mysqli_query($connection, $query)or die(mysqli_error($connection));
				$result = mysqli_fetch_array($result);
		
				$emailgc = explode('.',$emaildomain[1]);
				$gcca = $emailgc[count($emailgc) - 2] .".".$emailgc[count($emailgc) - 1];
		
				mysqli_close($connection);

				$resulting_error = "";

				//if ($toc[0] != 1)
				//{
				//throw new RegistrationException(elgg_echo('gcRegister:toc_error'));
				//	$resulting_error .= elgg_echo('gcRegister:toc_error').'<br/>';
				//}
				//error_log('num - '.is_null($result));
				// if domain doesn't exist in database, check if it's a gc.ca domain
				if ($result['num'][0] <= 0) 
				{
					if ($gcca !== 'gc.ca')
						//throw new RegistrationException(elgg_echo('gcRegister:email_error'));
						$resulting_error .= elgg_echo('gcRegister:invalid_email');
			
				}


				if ($resulting_error !== "")
				{
					//throw new RegistrationException($resulting_error);
					///error_log($resulting_error);
						$response['error'] = 3;
						$response['message'] = 'invalid email or email domain - must be a valid Government of Canada email address';
						return $response;
				}
				$user_entity->set('email', $value);
				$user_entity->save();
				
				elgg_set_ignore_access(false);
				break;
			case 'secondLanguage':
				
				$user_entity->set('english', $value["ENG"]);
				$user_entity->set('french', $value["FRA"]);
            	$user_entity->set('officialLanguage', $value["firstLanguage"]);

				break;
		}
	}
	
	$user_entity->save();
	return 'success';
}

function profileCreate($data){
	global $CONFIG;
	// check email for duplicate
	// get email and create username
	// create account
	// send password reset email
	// fill in profile data
	if ($data == ''){
		$response['error'] = 2;
		$response['message'] = 'data must be a string representing a JSON object.';
		return $response;
	}
	$userDataObj = json_decode($data, true);
	if (json_last_error() !== 0){
		$response['error'] = 2;
		$response['message'] = 'invalid JSON - data was unable to be parsed';
		return $response;
		//return "invalid JSON format of data";
	}

	///////////////////////////////////////////////////////////////////
	//error check data field
	///////////////////////////////////////////////////////////////////
	foreach ($userDataObj as $field => $value){
		//error_log('in loop');
		switch($field){
			case 'name':
			
			
				//error_log(json_encode($value));
				$nameData = json_decode(json_encode($value), true);
				if (!isset($nameData["firstName"])&&!isset($nameData["lastName"])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing first and last name';
						return $response;

				}
				if (!isset($nameData["firstName"])||!isset($nameData["lastName"])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing first or last name';
						return $response;

				}
				

				$name = $nameData["firstName"].' '.$nameData["lastName"];
				
				break;
			case 'title':
				
				$titleData = json_decode(json_encode($value), true);
				if (!isset($titleData['fr'])&&!isset($titleData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing french and english title';
						return $response;

				}
				if (!isset($titleData['fr'])||!isset($titleData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing french or english title';
						return $response;

				}
				
				
				
				break;
			case 'classification':
				//error_log(json_encode($value));
				$classificationData = json_decode(json_encode($value), true);
				if (!isset($classificationData['group'])&&!isset($classificationData['level'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing classification group and level';
						return $response;

				}
				if (!isset($classificationData['group'])||!isset($classificationData['level'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing classification group or level';
						return $response;

				}
				
				break;
			case 'department':
				$deptData = json_decode(json_encode($value), true);
				if (!isset($deptData['fr'])&&!isset($deptData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - department format';
						return $response;

				}
				if (!isset($deptData['fr'])||!isset($deptData['en'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing french or english department';
						return $response;

				}
				

				$obj = elgg_get_entities(array(
   					'type' => 'object',
   					'subtype' => 'dept_list',
   					'owner_guid' => 0
				));
				$deptListEn = json_decode($obj[0]->deptsEn, true);
				$provinces = array();
				$provinces['pov-alb'] = 'Government of Alberta';
				$provinces['pov-bc'] = 'Government of British Columbia';
				$provinces['pov-man'] = 'Government of Manitoba';
				$provinces['pov-nb'] = 'Government of New Brunswick';
				$provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
				$provinces['pov-ns'] = 'Government of Nova Scotia';
				$provinces['pov-nwt'] = 'Government of Northwest Territories';
				$provinces['pov-nun'] = 'Government of Nunavut';
				$provinces['pov-ont'] = 'Government of Ontario';
				$provinces['pov-pei'] = 'Government of Prince Edward Island';
				$provinces['pov-que'] = 'Government of Quebec';
				$provinces['pov-sask'] = 'Government of Saskatchewan';
				$provinces['pov-yuk'] = 'Government of Yukon';
				$deptAndProvincesEn = array_merge($deptListEn,$provinces);


				$deptListFr = json_decode($obj[0]->deptsFr, true);
				$provinces = array();
				$provinces['pov-alb'] = "Gouvernement de l'Alberta";
				$provinces['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
				$provinces['pov-man'] = 'Gouvernement du Manitoba';
				$provinces['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
				$provinces['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
				$provinces['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
				$provinces['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
				$provinces['pov-nun'] = 'Gouvernement du Nunavut';
				$provinces['pov-ont'] = "Gouvernement de l'Ontario";
				$provinces['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
				$provinces['pov-que'] = 'Gouvernement du Québec';
				$provinces['pov-sask'] = 'Gouvernement de Saskatchewan';
				$provinces['pov-yuk'] = 'Gouvernement du Yukon';
				$deptAndProvincesFr = array_merge($deptListFr,$provinces);

				if(!in_array($deptData['en'], $deptAndProvincesEn)){
						$response['error'] = 5;
						$response['message'] = 'invalid english department name. valid names: '.json_encode($deptAndProvincesEn);
						return $response;
				}

				if(!in_array($deptData['fr'], $deptAndProvincesFr)){
						$response['error'] = 5;
						$response['message'] = 'invalid french department name. valid names: '.json_encode($deptAndProvincesFr);
						return $response;
				}
				

				break;
			case 'branch':
				$branchData = json_decode(json_encode($value), true);
				if (!isset($branchData['en'])&&!isset($branchData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english and french branch name';
						return $response;

				}
				if (!isset($branchData['en'])||!isset($branchData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english or french branch name';
						return $response;

				}
				
				
				break;
			case 'sector':
				$sectorData = json_decode(json_encode($value), true);
				if (!isset($sectorData['en'])&&!isset($sectorData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english and french sector name';
						return $response;

				}
				if (!isset($sectorData['en'])||!isset($sectorData['fr'])){
						$response['error'] = 4;
						$response['message'] = 'invalid data format - missing english or french sector name';
						return $response;

				}
				
				
				break;
			case 'location':
				if (!isset($value['en'])){
						$response['error'] = 4;
						$response['message'] = 'missing english location data';
						return $response;

				}
				$locationData = json_decode(json_encode($value['en']), true);
				if(!isset($locationData['street'])&&!isset($locationData['city'])&&!isset($locationData['province'])&&!isset($locationData['postalCode'])&&!isset($locationData['country'])&&!isset($locationData['building'])&&!isset($locationData['floor'])&&!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'invalid location data';
						return $response;
				}
				if(!isset($locationData['street'])||!isset($locationData['city'])||!isset($locationData['province'])||!isset($locationData['postalCode'])||!isset($locationData['country'])||!isset($locationData['building'])||!isset($locationData['floor'])||!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'missing location data';
						return $response;
				}
				
				if (!isset($value['fr'])){
						$response['error'] = 4;
						$response['message'] = 'missing french location data';
						return $response;

				}
				$locationData = json_decode(json_encode($value['fr']), true);
				if(!isset($locationData['street'])&&!isset($locationData['city'])&&!isset($locationData['province'])&&!isset($locationData['postalCode'])&&!isset($locationData['country'])&&!isset($locationData['building'])&&!isset($locationData['floor'])&&!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'invalid location data';
						return $response;
				}
				if(!isset($locationData['street'])||!isset($locationData['city'])||!isset($locationData['province'])||!isset($locationData['postalCode'])||!isset($locationData['country'])||!isset($locationData['building'])||!isset($locationData['floor'])||!isset($locationData['officeNum'])){
						$response['error'] = 4;
						$response['message'] = 'missing location data';
						return $response;
				}
				
				
				break;
			
			case 'email':
				
				
				$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname)or die(mysqli_error($connection));
				//error_log($CONFIG->dbhost.' '.$CONFIG->dbuser.' '.$CONFIG->dbpass.' '.$CONFIG->dbname);
				mysqli_select_db($connection,$CONFIG->dbname);
				$emaildomain = explode('@',filter_var($value, FILTER_SANITIZE_EMAIL));

				$query = "SELECT count(*) AS num FROM email_extensions WHERE ext ='".$emaildomain[1]."'";
			
				$result = mysqli_query($connection, $query)or die(mysqli_error($connection));
				$result = mysqli_fetch_array($result);
		
				$emailgc = explode('.',$emaildomain[1]);
				$gcca = $emailgc[count($emailgc) - 2] .".".$emailgc[count($emailgc) - 1];
		
				mysqli_close($connection);

				$resulting_error = "";

				
				// if domain doesn't exist in database, check if it's a gc.ca domain
				if ($result['num'][0] <= 0) 
				{
					if ($gcca !== 'gc.ca')
						//throw new RegistrationException(elgg_echo('gcRegister:email_error'));
						$resulting_error .= elgg_echo('gcRegister:invalid_email');
			
				}


				if ($resulting_error !== "")
				{
					//throw new RegistrationException($resulting_error);
					///error_log($resulting_error);
						$response['error'] = 3;
						$response['message'] = 'invalid email or email domain - must be a valid Government of Canada email address';
						return $response;
				}
				
				break;
			
		}
	}


	//check for existing email
	$email = $userDataObj['email'];
	if(get_user_by_email($email)){
		$response['error'] = 1;
		$response['message'] = 'user with email already exists. please use profile.update call to update existing account';
		return $response;
	}
	//make usernaem based on email
	$username = strstr(strtolower($email),'@', true);

	$username = explode('.', $username);
	foreach ($username as $u=>$v){
		$username[$u] = ucfirst($v);
		//error_log($u);
	}
	$username = implode('.',$username);

	//check system for username. if is a username, append number or add number
	while(get_user_by_username($username)){
		if (is_numeric(substr($username, -1))){
			$num = substr($username, -1)+1;
			$username = substr($username, 0,strlen($username)-1).$num;
		}else{
			$username.='2';
		}
	}
	$tempPass = generateRandomString();
	
	//check for name data and prepair display name

	
	//register user using data passed
	$userGUID = register_user($username, $tempPass, $name, $userDataObj['email']);
	if ($userGUID==false){
		$response['error'] = 1;
		$response['message'] = 'Failed creating account';
		return $response;
	}
	//error_log($userGUID);

	$user_entity = get_user($userGUID);

	foreach ($userDataObj as $field => $value){
		//error_log('in loop');
		switch($field){
			
			case 'title':
				
				$titleData = json_decode(json_encode($value), true);
				
				if ($user_entity->language === 'fr'){
					$user_entity->set('job', $titleData['fr'].' / '.$titleData['en']);
				}
				else{
					$user_entity->set('job', $titleData['en'].' / '.$titleData['fr']);
				}
				
				break;
			case 'classification':
				//error_log(json_encode($value));
				$classificationData = json_decode(json_encode($value), true);
				
				$user_entity->set('classification', json_encode($value));
				break;
			case 'department':
				$deptData = json_decode(json_encode($value), true);
	
				
				if ($user_entity->language === 'fr'){
					$user_entity->set('department', $deptData['fr'].' / '.$deptData['en']);
				}
				else{
					$user_entity->set('department', $deptData['en'].' / '.$deptData['fr']);
				}


				break;
			case 'branch':
				$branchData = json_decode(json_encode($value), true);
				
				$user_entity->set('branch', json_encode($value));
				break;
			case 'sector':
				$sectorData = json_decode(json_encode($value), true);
				
				$user_entity->set('sector', json_encode($value));
				break;
			case 'location':

				$user_entity->set('addressString', json_encode($value["en"]));
				$user_entity->set('addressStringFr', json_encode($value["fr"]));
				break;
			case 'phone':
				
				$user_entity->set('phone', $value);
				break;
			case 'mobile':
				
				$user_entity->set('mobile', $value);
				break;


		}
	}
	//save user
	$user_entity->save();
	//send password reset to user
	send_new_password_request($userGUID);
	return array(
		"guid"=> $userGUID,
		"message" => "user added"
		);
}
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
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
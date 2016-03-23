<?php

elgg_ws_expose_function("search.user.skills","search_user_api_skills", array("skills" => array('type' => 'string')),
	'list of skills is returned',
               'GET', false, false);

function search_user_api_skills($skillsString){
	global $CONFIG;
	$users = array();
	$skillArray = array();
	$skillList = json_decode($skillsString);
	if(json_last_error() != JSON_ERROR_NONE){
		return 'Error parsing skill list, must be valid JSON array syntax';
	}
	//$result = 'nothing';
	$i = 0;
	foreach($skillList as $sl){
	
		elgg_set_ignore_access(true);
		$skillArray['skill_'.$i]['name'] = $sl;
		
		$url = elgg_get_plugins_path()."b_extended_profile/actions/b_extended_profile/";
		$skillsFromFile = file($url."skills.txt");
		//print_r($skillsFromFile, true);
		$skillsFromFile = array_map('trim',$skillsFromFile);
		if (array_search($sl, $skillsFromFile)!==false){
			$sl = $sl."\n";
		}
		error_log('skill-'.$sl);
		$entities = elgg_get_entities(array( 
			'subtype'=>'MySkill',
			'type' => 'object',
			'limit' => 0,
			'joins' => array("INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (e.guid = o.guid)"),
			'wheres' => array("o.title LIKE '$sl'")
		));
		$j = 0;
		foreach ($entities as $e){
			error_log($e->title);
			if ($e->title == $sl){
				//array_push($users, get_userBlock($e->owner_guid));
				$users['user_'.$j] = get_userBlock($e->owner_guid);
				$users['user_'.$j]['skills'] = getSkillsArray($e->owner_guid);
			}
			$j++;
		}
		if ($users)
			$skillArray['skill_'.$i]['users'] = $users;
		//error_log(print_r($users));
		//$result = $entities[0]; 
		$users = array();
		$i++;
		elgg_set_ignore_access(false);
	}
	
	$result["skills"] = $skillArray;
	return $result;
}
function getSkillsArray($uid){
	
	elgg_set_ignore_access(true);
	$skillsEntity = elgg_get_entities(array(
		'owner_guid'=>$uid,
		'subtype'=>'MySkill',
		'type' => 'object',
		'limit' => 0
	));
	if ($skillsEntity){
		$result = array();
		foreach($skillsEntity as $skill){
			array_push($result,$skill->title);
		}
	}	
	
		
	elgg_set_ignore_access(false);
	return $result;
}


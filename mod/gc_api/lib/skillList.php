<?php

elgg_ws_expose_function("get.skills","get_api_skillList", array('count' => array('type' => 'string',
		'required' => false,
		'default' => 'false',
		),
	),
'list of skills is returned',
               'GET', false, false);


function get_api_skillList($isCount){
	$skills = array();
	$data = array();
	if ($isCount!= 'true' && $isCount!= 'false')
		$isCount = 'false';
	error_log('error-'.$isCount);
	$url = elgg_get_plugins_path()."b_extended_profile/actions/b_extended_profile/";
	$skillsFromFile = file($url."skills.txt");
	//print_r($skillsFromFile, true);
	$skillsFromFile = array_map('trim',$skillsFromFile);
	if ($isCount == 'true'){
		$skillsFromFile = array_map('addCount',$skillsFromFile);
	}
	
	elgg_set_ignore_access(true);
	$skillsFromDatabase = elgg_get_entities(array(
		'subtype'=>'MySkill',
		'type' => 'object',
		'limit' => 0
		));
	$i = 0;
	foreach ($skillsFromDatabase as $db){
		if ($isCount == 'true'){
			if (array_search($db->title, array_column($skillsFromFile, 'text')) === false){
				//error_log(array_search($db->title, $skills));
				if(array_search($db->title, array_column($skills, 'text')) === false){
				//if ($isCount)
					$skills[$i++] = addCount($db->title, 1);
				}else{
					$key = array_search($db->title, array_column($skills, 'text'));
					$count = $skills[$key]['count'];
					$skills[$key] = addCount($db->title, $count+1);
					$i++;
				}

			}else{
				$key = array_search($db->title, array_column($skillsFromFile, 'text'));
				$skillsFromFile[$key]['count'] = $skillsFromFile[$key]['count']+1;
			
			}
		}else{
			if (array_search($db->title, $skillsFromFile) === false){
				//error_log(array_search($db->title, $skills));
				if(array_search($db->title, $skills) === false){
				//if ($isCount)
					$skills[$i++] = $db->title;
				}

			}
		}
	}
	
	$skills = array_merge($skills, $skillsFromFile);
	
	$result['skills'] = $skills;
	elgg_set_ignore_access(false);
	return $result;
}
function addCount($n, $c = 0){
	return array('text' => $n, 'count' => $c);
}
<?php

elgg_ws_expose_function(
	"search.user.skills",
	"search_user_api_skills",
	array("skills" => array('type' => 'string')),
	'list of skills is returned',
	'GET',
	false,
	false
);

function search_user_api_skills($skillsString)
{
	global $CONFIG;
	$users = array();
	$skillArray = array();
	$skillList = json_decode($skillsString);
	if (json_last_error() != JSON_ERROR_NONE) {
		return 'Error parsing skill list, must be valid JSON array syntax';
	}
	$i = 0;
	foreach ($skillList as $sl) {
		elgg_set_ignore_access(true);
		$skillArray['skill_'.$i]['name'] = $sl;

		$entities = elgg_get_entities(array(
			'subtype'=>'MySkill',
			'type' => 'object',
			'limit' => 0,
			'joins' => array("INNER JOIN {$CONFIG->dbprefix}objects_entity o ON (e.guid = o.guid)"),
			'wheres' => array("o.title LIKE '%$sl%'")
		));
		$j = 0;
		foreach ($entities as $e) {
			$users['user_'.$j] = get_userBlock($e->owner_guid);
			$users['user_'.$j]['skills'] = getSkillsArray($e->owner_guid);
			$j++;
		}
		if ($users) {
			$skillArray['skill_'.$i]['users'] = $users;
		}
		$users = array();
		$i++;
		elgg_set_ignore_access(false);
	}

	$result["skills"] = $skillArray;
	return $result;
}
function getSkillsArray($uid)
{
	elgg_set_ignore_access(true);
	$skillsEntity = elgg_get_entities(array(
		'owner_guid'=>$uid,
		'subtype'=>'MySkill',
		'type' => 'object',
		'limit' => 0
	));
	if ($skillsEntity) {
		$result = array();
		foreach ($skillsEntity as $skill) {
			array_push($result, trim($skill->title));
		}
	}

	elgg_set_ignore_access(false);
	return $result;
}

<?php

elgg_register_event_handler('init', 'system', 'gccollab_stats_init', 0);

function gccollab_stats_init() {
	elgg_register_page_handler('stats', 'stats_page_handler');
	if( strpos(elgg_get_site_entity()->name, 'collab') !== false ){
		elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'gccollab_stats_public_page');
	}

	elgg_ws_expose_function(
        "member.stats",
        "get_member_data",
        array(
        	"type" => array('type' => 'string', 'required' => true),
        	"lang" => array('type' => 'string', 'required' => false, 'default' => 'en')
        ),
        'Exposes member data for use with dashboard',
        'GET',
        false,
        false
	);

	elgg_ws_expose_function(
        "site.stats",
        "get_site_data",
        array(
        	"type" => array('type' => 'string', 'required' => true),
        	"lang" => array('type' => 'string', 'required' => false, 'default' => 'en')
        ),
        'Exposes site data for use with dashboard',
        'GET',
        false,
        false
	);

	elgg_ws_expose_function(
        "time.stats",
        "get_time_data",
        array(
        	"type" => array('type' => 'string', 'required' => true),
        	"lang" => array('type' => 'string', 'required' => false, 'default' => 'en')
        ),
        'Exposes entity data over time for use with dashboard',
        'GET',
        false,
        false
	);

	elgg_ws_expose_function(
        "group.stats",
        "get_group_data",
        array(
        	"type" => array('type' => 'string', 'required' => true),
        	"group" => array('type' => 'int', 'required' => true),
        	"lang" => array('type' => 'string', 'required' => false, 'default' => 'en')
        ),
        'Exposes group data for use with dashboard',
        'GET',
        false,
        false
	);
}

function gccollab_stats_public_page($hook, $handler, $return, $params){
	$pages = array('stats');
	return array_merge($pages, $return);
}

function stats_page_handler($page) {
	$base = elgg_get_plugins_path() . 'gccollab_stats/pages/gccollab_stats';
	$page = (strpos(elgg_get_site_entity()->name, 'collab') !== false) ? 'gccollab' : 'gcconnex';
	require_once "$base/$page.php";
	return true;
}

function get_member_data($type, $lang) {
	$data = array();
	ini_set("memory_limit", -1);
	elgg_set_ignore_access(true);
	$dbprefix = elgg_get_config('dbprefix');

	switch($type) {

	case 'all':
		$users = elgg_get_entities(array(
			'type' => 'user',
			'limit' => 0
		));

		$data['total'] = count($users);

		if ($lang == 'fr'){
			$users_types = array('federal' => 'féderal', 'academic' => 'milieu universitaire', 'student' => 'étudiant', 'provincial' => 'provincial', 'municipal' => 'municipale', 'international' => 'international', 'ngo' => 'ngo', 'community' => 'collectivité', 'business' => 'entreprise', 'media' => 'média', 'retired' => 'retraité(e)', 'other' => 'autre');

			foreach($users as $key => $obj){
				$data[$users_types[$obj->user_type]] = isset( $data[$users_types[$obj->user_type]] ) ? $data[$users_types[$obj->user_type]] + 1 : 1;
			}
		} else {
			foreach($users as $key => $obj){
				$data[$obj->user_type] = isset( $data[$obj->user_type] ) ? $data[$obj->user_type] + 1 : 1;
			}
		}
		break;

	case 'federal':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'federal'),
			),
			'limit' => 0
		));

		if ($lang == 'fr'){
			$deptObj = elgg_get_entities(array(
			   	'type' => 'object',
			   	'subtype' => 'federal_departments',
			));
			$depts = get_entity($deptObj[0]->guid);
			$federal_departments = json_decode($depts->federal_departments_fr, true);

			foreach($users as $key => $obj){
				$data[$federal_departments[$obj->federal]] = isset( $data[$federal_departments[$obj->federal]] ) ? $data[$federal_departments[$obj->federal]] + 1 : 1;
			}
		} else {
			foreach($users as $key => $obj){
				$data[$obj->federal] = isset( $data[$obj->federal] ) ? $data[$obj->federal] + 1 : 1;
			}
		}
		break;

	case 'academic':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'academic'),
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data[$obj->institution]['total'] = isset( $data[$obj->institution]['total'] ) ? $data[$obj->institution]['total'] + 1 : 1;
			if($obj->university){
				$data[$obj->institution][$obj->university] = isset( $data[$obj->institution][$obj->university] ) ? $data[$obj->institution][$obj->university] + 1 : 1;
			}
			if($obj->college){
				$data[$obj->institution][$obj->college] = isset( $data[$obj->institution][$obj->college] ) ? $data[$obj->institution][$obj->college] + 1 : 1;
			}
		}
		break;

	case 'student':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'student'),
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data[$obj->institution]['total'] = isset( $data[$obj->institution]['total'] ) ? $data[$obj->institution]['total'] + 1 : 1;
			if($obj->university){
				$data[$obj->institution][$obj->university] = isset( $data[$obj->institution][$obj->university] ) ? $data[$obj->institution][$obj->university] + 1 : 1;
			}
			if($obj->college){
				$data[$obj->institution][$obj->college] = isset( $data[$obj->institution][$obj->college] ) ? $data[$obj->institution][$obj->college] + 1 : 1;
			}
			if($obj->highschool){
				$data[$obj->institution][$obj->highschool] = isset( $data[$obj->institution][$obj->highschool] ) ? $data[$obj->institution][$obj->highschool] + 1 : 1;
			}
		}
		break;

	case 'university':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'academic'),
				array('name' => 'institution', 'value' => 'university'),
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->university] = isset( $data[$obj->university] ) ? $data[$obj->university] + 1 : 1;
		}
		break;

	case 'college':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'academic'),
				array('name' => 'institution', 'value' => 'college'),
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->college] = isset( $data[$obj->college] ) ? $data[$obj->college] + 1 : 1;
		}
		break;

	case 'highschool':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'student'),
				array('name' => 'institution', 'value' => 'highschool'),
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->highschool] = isset( $data[$obj->highschool] ) ? $data[$obj->highschool] + 1 : 1;
		}
		break;

	case 'provincial':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'provincial'),
			),
			'limit' => 0
		));

		if ($lang == 'fr'){
			$provObj = elgg_get_entities(array(
			   	'type' => 'object',
			   	'subtype' => 'provinces',
			));
			$provs = get_entity($provObj[0]->guid);
			$provincial_departments = json_decode($provs->provinces_fr, true);

			$minObj = elgg_get_entities(array(
			   	'type' => 'object',
			   	'subtype' => 'ministries',
			));
			$mins = get_entity($minObj[0]->guid);
			$ministries = json_decode($mins->ministries_fr, true);

			foreach($users as $key => $obj){
				$data[$provincial_departments[$obj->provincial]]['total'] = isset( $data[$provincial_departments[$obj->provincial]]['total'] ) ? $data[$provincial_departments[$obj->provincial]]['total'] + 1 : 1;
				$data[$provincial_departments[$obj->provincial]][$ministries[$obj->provincial][$obj->ministry]] = isset( $data[$provincial_departments[$obj->provincial]][$ministries[$obj->provincial][$obj->ministry]] ) ? $data[$provincial_departments[$obj->provincial]][$ministries[$obj->provincial][$obj->ministry]] + 1 : 1;
			}
		} else {
			foreach($users as $key => $obj){
				$data[$obj->provincial]['total'] = isset( $data[$obj->provincial]['total'] ) ? $data[$obj->provincial]['total'] + 1 : 1;
				$data[$obj->provincial][$obj->ministry] = isset( $data[$obj->provincial][$obj->ministry] ) ? $data[$obj->provincial][$obj->ministry] + 1 : 1;
			}
		}
		break;

	case 'municipal':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'municipal')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->municipal] = isset( $data[$obj->municipal] ) ? $data[$obj->municipal] + 1 : 1;
		}
		break;

	case 'international':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'international')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->international] = isset( $data[$obj->international] ) ? $data[$obj->international] + 1 : 1;
		}
		break;

	case 'ngo':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'ngo')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->ngo] = isset( $data[$obj->ngo] ) ? $data[$obj->ngo] + 1 : 1;
		}
		break;

	case 'community':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'community')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->community] = isset( $data[$obj->community] ) ? $data[$obj->community] + 1 : 1;
		}
		break;

	case 'business':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'business')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->business] = isset( $data[$obj->business] ) ? $data[$obj->business] + 1 : 1;
		}
		break;

	case 'media':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'media')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->media] = isset( $data[$obj->media] ) ? $data[$obj->media] + 1 : 1;
		}
		break;

	case 'retired':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'retired')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->retired] = isset( $data[$obj->retired] ) ? $data[$obj->retired] + 1 : 1;
		}
		break;

	case 'other':
		$users = elgg_get_entities_from_metadata(array(
			'type' => 'user',
			'metadata_name_value_pairs' => array(
				array('name' => 'user_type', 'value' => 'other')
			),
			'limit' => 0
		));
		foreach($users as $key => $obj){
			$data['total'] = isset( $data['total'] ) ? $data['total'] + 1 : 1;
			$data[$obj->other] = isset( $data[$obj->other] ) ? $data[$obj->other] + 1 : 1;
		}
		break;

	case 'gcconnex':
	    $query = "SELECT msv.string as department, count(*) as count FROM {$dbprefix}users_entity u LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id WHERE msn.string = 'department' GROUP BY department ORDER BY count DESC LIMIT 25";
		$departments = get_data($query);

		foreach($departments as $key => $obj){
			$data[$obj->department] = (int)$obj->count;
		}
		break;

	default:
		$data = "Please use one of the following `type` parameters: all, federal, academic, student, university, college, highschool, provincial, municipal, international, ngo, community, business, media, retired, other, gcconnex";
		break;

	}

    return $data;
}

function get_site_data($type, $lang) {
	$data = array();
	ini_set("memory_limit", -1);
	elgg_set_ignore_access(true);
	$dbprefix = elgg_get_config('dbprefix');

	switch($type) {

	case 'wireposts':
		$typeid = get_subtype_id('object', 'thewire');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$wireposts = get_data($query);

		foreach($wireposts as $key => $obj){
			$data[] = array($obj->time_created, "", $obj->owner_guid);
		}
		break;

	case 'blogposts':
		$typeid = get_subtype_id('object', 'blog');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$blogposts = get_data($query);

		foreach($blogposts as $key => $obj){
			$data[] = array($obj->time_created, "", "", $obj->owner_guid);
		}
		break;

	case 'comments':
		$typeid = get_subtype_id('object', 'comment');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$comments = get_data($query);

		foreach($comments as $key => $obj){
			$data[] = array($obj->time_created, "", $obj->owner_guid);
		}
		break;

	case 'groupscreated':
		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'group' AND enabled = 'yes'";
		$groupscreated = get_data($query);

		foreach($groupscreated as $key => $obj){
			$data[] = array($obj->time_created, "", "", $obj->owner_guid);
		}
		break;

	case 'groupsjoined':
		$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE relationship = 'member'";
		$groupsjoined = get_data($query);

		foreach($groupsjoined as $key => $obj){
			if ( $obj->time_created ){
				$data[] = array($obj->time_created, $obj->guid_one, $obj->guid_two);
			}
		}
		break;

	case 'likes':
		$likesID = elgg_get_metastring_id("likes");

		$query = "SELECT * FROM {$dbprefix}annotations WHERE name_id = $likesID";
		$likes = get_data($query);

		foreach($likes as $key => $obj){
			$data[] = array($obj->time_created, $obj->owner_guid, "");
		}
		break;

	case 'messages':
		$name_id = elgg_get_metastring_id("fromId");

		$query = "SELECT md.time_created as time_created, ms.string as sender_guid FROM {$dbprefix}metadata md 
					RIGHT JOIN {$dbprefix}metastrings ms ON ms.id = md.value_id
					RIGHT JOIN {$dbprefix}users_entity efrom ON ms.string = efrom.guid
					WHERE md.name_id = {$name_id}";
		$messages = get_data($query);

		foreach($messages as $key => $obj){
			$data[] = array($obj->time_created, "", $obj->sender_guid);
		}
		break;

	case 'optins':
		$optin_types = array(
			"opt_in_missions" => "missions:micro_mission",
			"opt_in_missionCreate" => "missions:micro_mission",
			"opt_in_swap" => "missions:job_swap",
			"opt_in_mentored" => "missions:mentoring",
			"opt_in_mentoring" => "missions:mentoring",
			"opt_in_shadowed" => "missions:job_shadowing",
			"opt_in_shadowing" => "missions:job_shadowing",
			"opt_in_jobshare" => "missions:job_sharing",
			"opt_in_pcSeek" => "missions:peer_coaching",
			"opt_in_pcCreate" => "missions:peer_coaching",
			"opt_in_ssSeek" => "missions:skill_sharing",
			"opt_in_ssCreate" => "missions:skill_sharing",
			"opt_in_rotation" => "missions:job_rotation",
			"opt_in_assignSeek" => "missions:assignment",
			"opt_in_assignCreate" => "missions:assignment",
			"opt_in_deploySeek" => "missions:deployment",
			"opt_in_deployCreate" => "missions:deployment",
			"opt_in_casual_seek" => "missions:casual",
			"opt_in_casual_create" => "missions:casual",
			"opt_in_student_seek" => "missions:student",
			"opt_in_student_create" => "missions:student",
			"opt_in_collaboration_seek" => "missions:collaboration",
			"opt_in_collaboration_create" => "missions:collaboration"
		);

		$yes = elgg_get_metastring_id('gcconnex_profile:opt:yes');

		$map = array();
		foreach ($optin_types as $optin_type => $index) {
			$map[$optin_type] = elgg_get_metastring_id($optin_type);
		}

		$query = "SELECT count(DISTINCT m.entity_guid) as num FROM elggmetadata m WHERE";
		foreach ($optin_types as $optin_type => $index) {
			$temp = $query . " m.name_id={$map[$optin_type]} AND m.value_id={$yes};";
			$result = get_data($temp)[0];
			$count = intval($result->num);

			if($count > 0){
				$string = elgg_echo($index, $lang);
				if(stripos($optin_type, 'create') !== false){
					$string .= " (" . elgg_echo("missions:offering", $lang) . ")";
				}
				if(stripos($optin_type, 'seek') !== false){
					$string .= " (" . elgg_echo("missions:seeking", $lang) . ")";
				}
				if($optin_type == "opt_in_mentored"){
					$string .= " (" . elgg_echo("gcconnex_profile:opt:mentored", $lang) . ")";
				}
				if($optin_type == "opt_in_mentoring"){
					$string .= " (" . elgg_echo("gcconnex_profile:opt:mentoring", $lang) . ")";
				}
				$data[$string] = $count;
			}
		}
		break;

	default:
		$data = "Please use one of the following `type` parameters: wireposts, blogposts, comments, groupscreated, groupsjoined, likes, messages, optins";
		break;

	}

    return $data;
}

function get_time_data($type, $lang) {
	$data = array();
	ini_set("memory_limit", -1);
	elgg_set_ignore_access(true);
	$dbprefix = elgg_get_config('dbprefix');

	switch($type) {

	case 'members':
		$query = "SELECT DISTINCT e.time_created AS time, count(*) AS count, date_format(from_unixtime(e.time_created),'%Y-%m-%d') AS date FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity st ON e.guid = st.guid WHERE e.type = 'user' AND e.enabled = 'yes' GROUP BY date ORDER BY time";
		$data = get_data($query);
		break;

	case 'groups':
		$query = "SELECT DISTINCT e.time_created as time, count(*) as count, date_format(from_unixtime(e.time_created),'%Y-%m-%d') AS date FROM {$dbprefix}entities e WHERE type = 'group' AND e.enabled = 'yes' GROUP BY date ORDER BY time";
		$data = get_data($query);
		break;

	case 'opportunities':
		$typeid = get_subtype_id('object', 'mission');

		$query = "SELECT DISTINCT e.time_created AS time, count(*) AS count, date_format(from_unixtime(e.time_created),'%Y-%m-%d') AS date FROM {$dbprefix}entities e WHERE e.type = 'object' AND e.subtype = {$typeid} AND e.enabled = 'yes' GROUP BY date ORDER BY time";
		$data = get_data($query);
		break;

	default:
		$data = "Please use one of the following `type` parameters: members, groups, opportunities";
		break;

	}

	return $data;
}

function get_group_data($type, $group, $lang) {
	$data = array();
	ini_set("memory_limit", -1);
	elgg_set_ignore_access(true);
	$dbprefix = elgg_get_config('dbprefix');

	switch($type) {

	case 'groupsjoined':
		$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE relationship = 'member' AND guid_two = '" . $group . "'";
		$groupsjoined = get_data($query);

		foreach($groupsjoined as $key => $obj){
			if ( $obj->time_created ){
				$user = get_user($obj->guid_one);
				if($user->username){
					$data[] = array($obj->time_created, $user->username);
				}
			}
		}
		break;

	case 'users':
		$users = elgg_get_entities_from_relationship(array(
			'relationship' => 'member',
			'relationship_guid' => $group,
			'inverse_relationship' => true,
			'type' => 'user',
			'limit' => 0
		));

		if ($lang == 'fr'){
			$users_types = array('federal' => 'féderal', 'academic' => 'milieu universitaire', 'student' => 'étudiant', 'provincial' => 'provincial', 'municipal' => 'municipale', 'international' => 'international', 'ngo' => 'ngo', 'community' => 'collectivité', 'business' => 'entreprise', 'media' => 'média', 'retired' => 'retraité(e)', 'other' => 'autre');

			foreach($users as $key => $obj){
				$data[$users_types[$obj->user_type]] = isset( $data[$users_types[$obj->user_type]] ) ? $data[$users_types[$obj->user_type]] + 1 : 1;
			}
		} else {
			foreach($users as $key => $obj){
				$data[$obj->user_type] = isset( $data[$obj->user_type] ) ? $data[$obj->user_type] + 1 : 1;
			}
		}
		break;

	default:
		$data = "Please use one of the following `type` parameters: groupsjoined, users";
		break;

	}
	
    return $data;
}

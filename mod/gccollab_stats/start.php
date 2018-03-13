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
		$total_query = "SELECT count(e.guid) AS total FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid WHERE e.type = 'user' AND e.enabled = 'yes';";
		$total = get_data($total_query);
		$data['total'] = intval($total[0]->total);

		$all_query = "SELECT msv.string, count(msv.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' GROUP BY msv.string;";
		$all = get_data($all_query);

		if ($lang == 'fr'){
			$users_types = array('federal' => 'féderal', 'academic' => 'milieu universitaire', 'student' => 'étudiant', 'provincial' => 'provincial', 'municipal' => 'municipale', 'international' => 'international', 'ngo' => 'ngo', 'community' => 'collectivité', 'business' => 'entreprise', 'media' => 'média', 'retired' => 'retraité(e)', 'other' => 'autre');

			foreach($all as $obj){
				$data[$users_types[$obj->string]] = intval($obj->count);
			}
		} else {
			foreach($all as $obj){
				$data[$obj->string] = intval($obj->count);
			}
		}
		break;

	case 'federal':
		$query = "SELECT msv2.string as federal, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'federal' AND msn2.string = 'federal' AND msv2.string <> '' GROUP BY msv2.string;";
		$users = get_data($query);

		if ($lang == 'fr'){
			$deptObj = elgg_get_entities(array(
			   	'type' => 'object',
			   	'subtype' => 'federal_departments',
			));
			$depts = get_entity($deptObj[0]->guid);
			$federal_departments = json_decode($depts->federal_departments_fr, true);

			foreach($users as $obj){
				$data[$federal_departments[$obj->federal]] = intval($obj->count);
			}
		} else {
			foreach($users as $obj){
				$data[$obj->federal] = intval($obj->count);
			}
		}
		break;

	case 'academic':
		$all_query = "SELECT msv2.string as institution, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'academic' AND msn2.string = 'institution' GROUP BY msv2.string;";
		$users = get_data($all_query);
		foreach($users as $obj){
			$data[$obj->institution]['total'] = intval($obj->count);
		}

		$university_query = "SELECT msv2.string as university, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'academic' AND msn2.string = 'university' AND msv2.string <> '' GROUP BY msv2.string;";
		$university_users = get_data($university_query);
		foreach($university_users as $obj){
			$data['university'][$obj->university] = intval($obj->count);
		}

		$college_query = "SELECT msv2.string as college, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'academic' AND msn2.string = 'college' AND msv2.string <> '' GROUP BY msv2.string;";
		$college_users = get_data($college_query);
		foreach($college_users as $obj){
			$data['college'][$obj->college] = intval($obj->count);
		}
		break;

	case 'student':
		$all_query = "SELECT msv2.string as student, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'student' AND msn2.string = 'institution' GROUP BY msv2.string;";
		$users = get_data($all_query);
		foreach($users as $obj){
			$data[$obj->student]['total'] = intval($obj->count);
		}

		$university_query = "SELECT msv2.string as university, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'student' AND msn2.string = 'university' AND msv2.string <> '' GROUP BY msv2.string;";
		$university_users = get_data($university_query);
		foreach($university_users as $obj){
			$data['university'][$obj->university] = intval($obj->count);
		}

		$college_query = "SELECT msv2.string as college, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'student' AND msn2.string = 'college' AND msv2.string <> '' GROUP BY msv2.string;";
		$college_users = get_data($college_query);
		foreach($college_users as $obj){
			$data['college'][$obj->college] = intval($obj->count);
		}

		$highschool_query = "SELECT msv2.string as highschool, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'student' AND msn2.string = 'highschool' AND msv2.string <> '' GROUP BY msv2.string;";
		$highschool_users = get_data($highschool_query);
		foreach($highschool_users as $obj){
			$data['highschool'][$obj->highschool] = intval($obj->count);
		}
		break;

	case 'provincial':
		$all_query = "SELECT msv2.string as provincial, count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'provincial' AND msn2.string = 'provincial' AND msv2.string <> '' GROUP BY msv2.string;";
		$users = get_data($all_query);

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

			foreach($users as $obj){
				$data[$provincial_departments[$obj->provincial]]['total'] = intval($obj->count);

				$ministry_query = "SELECT msv3.string as ministry, count(msv3.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metadata md3 ON u.guid = md3.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id LEFT JOIN {$dbprefix}metastrings msn3 ON md3.name_id = msn3.id LEFT JOIN {$dbprefix}metastrings msv3 ON md3.value_id = msv3.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'provincial' AND msv2.string = '" . $obj->provincial . "' AND msn3.string = 'ministry' GROUP BY msv3.string;";
				$ministry_users = get_data($ministry_query);

				foreach($ministry_users as $obj2){
					$data[$provincial_departments[$obj->provincial]][$obj2->ministry] = intval($obj2->count);
				}
			}
		} else {
			foreach($users as $obj){
				$data[$obj->provincial]['total'] = intval($obj->count);

				$ministry_query = "SELECT msv3.string as ministry, count(msv3.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metadata md3 ON u.guid = md3.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id LEFT JOIN {$dbprefix}metastrings msn3 ON md3.name_id = msn3.id LEFT JOIN {$dbprefix}metastrings msv3 ON md3.value_id = msv3.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = 'provincial' AND msv2.string = '" . $obj->provincial . "' AND msn3.string = 'ministry' GROUP BY msv3.string;";
				$ministry_users = get_data($ministry_query);

				foreach($ministry_users as $obj2){
					$data[$obj->provincial][$obj2->ministry] = intval($obj2->count);
				}
			}
		}
		break;

	case 'municipal':
	case 'international':
	case 'ngo':
	case 'community':
	case 'business':
	case 'media':
	case 'retired':
	case 'other':
		$query = "SELECT msv2.string as " . $type . ", count(msv2.string) as count FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metadata md2 ON u.guid = md2.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id LEFT JOIN {$dbprefix}metastrings msn2 ON md2.name_id = msn2.id LEFT JOIN {$dbprefix}metastrings msv2 ON md2.value_id = msv2.id WHERE e.type = 'user' AND e.enabled = 'yes' AND msn.string = 'user_type' AND msv.string = '" . $type . "' AND msn2.string = '" . $type . "' AND msv2.string <> '' GROUP BY msv2.string;";
		$users = get_data($query);

		foreach($users as $obj){
			$data[$obj->$type] = intval($obj->count);
		}
		break;

	case 'gcconnex':
	    $query = "SELECT msv.string as department, count(*) as count FROM {$dbprefix}users_entity u LEFT JOIN {$dbprefix}metadata md ON u.guid = md.entity_guid LEFT JOIN {$dbprefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$dbprefix}metastrings msv ON md.value_id = msv.id WHERE msn.string = 'department' GROUP BY department ORDER BY count DESC LIMIT 25";
		$departments = get_data($query);

		foreach($departments as $obj){
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

		foreach($wireposts as $obj){
			$data[] = array($obj->time_created, "", $obj->owner_guid);
		}
		break;

	case 'blogposts':
		$typeid = get_subtype_id('object', 'blog');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$blogposts = get_data($query);

		foreach($blogposts as $obj){
			$data[] = array($obj->time_created, "", "", $obj->owner_guid);
		}
		break;

	case 'comments':
		$typeid = get_subtype_id('object', 'comment');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$comments = get_data($query);

		foreach($comments as $obj){
			$data[] = array($obj->time_created, "", $obj->owner_guid);
		}
		break;

	case 'groupscreated':
		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'group' AND enabled = 'yes'";
		$groupscreated = get_data($query);

		foreach($groupscreated as $obj){
			$data[] = array($obj->time_created, "", "", $obj->owner_guid);
		}
		break;

	case 'groupsjoined':
		$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE relationship = 'member'";
		$groupsjoined = get_data($query);

		foreach($groupsjoined as $obj){
			if ( $obj->time_created ){
				$data[] = array($obj->time_created, $obj->guid_one, $obj->guid_two);
			}
		}
		break;

	case 'likes':
		$likesID = elgg_get_metastring_id("likes");

		$query = "SELECT * FROM {$dbprefix}annotations WHERE name_id = $likesID";
		$likes = get_data($query);

		foreach($likes as $obj){
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

		foreach($messages as $obj){
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

		$query = "SELECT count(DISTINCT m.entity_guid) as num FROM {$dbprefix}metadata m WHERE";
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
		$query = "SELECT DISTINCT e.time_created AS time, count(*) AS count, date_format(from_unixtime(e.time_created),'%Y-%m-%d') AS date FROM {$dbprefix}entities e JOIN {$dbprefix}users_entity u ON e.guid = u.guid WHERE e.type = 'user' AND e.enabled = 'yes' GROUP BY date ORDER BY time";
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

		foreach($groupsjoined as $obj){
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

			foreach($users as $obj){
				$data[$users_types[$obj->user_type]] = isset( $data[$users_types[$obj->user_type]] ) ? $data[$users_types[$obj->user_type]] + 1 : 1;
			}
		} else {
			foreach($users as $obj){
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

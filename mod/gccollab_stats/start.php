<?php

elgg_register_event_handler('init', 'system', 'gccollab_stats_init', 0);

function gccollab_stats_init() {
	elgg_register_page_handler('stats', 'stats_page_handler');
//	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'gccollab_stats_public_page');

	elgg_ws_expose_function(
        "member.stats",
        "get_member_data",
        array("type" => array('type' => 'string'), "lang" => array('type' => 'string')),
        'Exposes member data for use with dashboard',
        'GET',
        false,
        false
	);

	elgg_ws_expose_function(
        "site.stats",
        "get_site_data",
        array("type" => array('type' => 'string'), "lang" => array('type' => 'string')),
        'Exposes site data for use with dashboard',
        'GET',
        false,
        false
	);
}

/*function gccollab_stats_public_page($hook, $handler, $return, $params){
	$pages = array('stats');
	return array_merge($pages, $return);
}*/

function stats_page_handler($page) {
	$base = elgg_get_plugins_path() . 'gccollab_stats/pages/gccollab_stats';
	require_once "$base/index.php";
	return true;
}

function get_member_data($type, $lang) {
	if(!isset($lang)){ $lang = 'en'; }

	$data = array();
	ini_set("memory_limit", -1);
	elgg_set_ignore_access(true);

	$users = elgg_get_entities(array(
		'type' => 'user',
		'limit' => 0
	));

	/*if ($lang == 'fr'){
		$users_types = array('federal' => 'féderal', 'provincial' => 'provincial', 'academic' => 'milieu universitaire', 'student' => 'étudiant', 'other' => 'autre');

		foreach($users as $key => $obj){
			$data[$users_types[$obj->user_type]]++;
		}
	} else {*/
		foreach($users as $key => $obj){
			$data[$obj->department]++;
		}
	//}

    return $data;
}

function get_site_data($type, $lang) {
	if(!isset($lang)){ $lang = 'en'; }

	$data = array();
	ini_set("memory_limit", -1);
	elgg_set_ignore_access(true);

	if ($type === 'wireposts') {
		$typeid = get_subtype_id('object', 'thewire');
		$dbprefix = elgg_get_config('dbprefix');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$wireposts = get_data($query);

		foreach($wireposts as $key => $obj){
			//$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, "description", $obj->owner_guid);
		}
	} else if ($type === 'blogposts') {
		$typeid = get_subtype_id('object', 'blog');
		$dbprefix = elgg_get_config('dbprefix');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$blogposts = get_data($query);

		foreach($blogposts as $key => $obj){
			//$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, "title", "description", $obj->owner_guid);
		}
	} else if ($type === 'comments') {
		$typeid = get_subtype_id('object', 'comment');
		$dbprefix = elgg_get_config('dbprefix');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$comments = get_data($query);

		foreach($comments as $key => $obj){
			//$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, "description", $obj->owner_guid);
		}
	} else if ($type === 'groupscreated') {
		$dbprefix = elgg_get_config('dbprefix');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'group' AND enabled = 'yes'";
		$groupscreated = get_data($query);

		foreach($groupscreated as $key => $obj){
			//$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, "name", "description", $obj->owner_guid);
		}
	} else if ($type === 'groupsjoined') {
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE relationship = 'member'";
		$groupsjoined = get_data($query);

		foreach($groupsjoined as $key => $obj){
			//$user = get_user($obj->guid_one);
			//$group = get_entity($obj->guid_two);
			if ( $obj->time_created )
				$data[] = array($obj->time_created, $obj->guid_one, $obj->guid_two);
		}
	} else if ($type === 'likes') {
		$dbprefix = elgg_get_config('dbprefix');
		$likesID = elgg_get_metastring_id("likes");

		$query = "SELECT * FROM {$dbprefix}annotations WHERE name_id = $likesID";
		$likes = get_data($query);

		foreach($likes as $key => $obj){
			//$entity = get_entity($obj->entity_guid);
			//$user = get_user($obj->owner_guid);
			//$user_liked = ($entity->title != "" ? $entity->title : ($entity->name != "" ? $entity->name : $entity->description));
			$data[] = array($obj->time_created, $obj->owner_guid, "user_liked");
		}
	} else if ($type === 'messages') {
		$typeid = get_subtype_id('object', 'messages');
		$dbprefix = elgg_get_config('dbprefix');

		$query = "SELECT guid, time_created, owner_guid FROM {$dbprefix}entities WHERE type = 'object' AND subtype = {$typeid} AND enabled = 'yes'";
		$messages = get_data($query);

		foreach($messages as $key => $obj){
			//$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, "title", $obj->owner_guid);
		}
	} 
    return $data;
}
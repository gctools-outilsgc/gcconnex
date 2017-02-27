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
		$wireposts = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'thewire',
			'limit' => 0
		));

		foreach($wireposts as $key => $obj){
			$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, $obj->description, $user->name);
		}
	} else if ($type === 'blogposts') {
		$blogposts = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => 0
		));

		foreach($blogposts as $key => $obj){
			$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, $obj->title, $obj->description, $user->name);
		}
	} else if ($type === 'comments') {
		$comments = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'comment',
			'limit' => 0
		));

		foreach($comments as $key => $obj){
			$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, $obj->description, $user->name);
		}
	} else if ($type === 'groupscreated') {
		$groupscreated = elgg_get_entities(array(
			'type' => 'group',
			'limit' => 0
		));

		foreach($groupscreated as $key => $obj){
			$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, $obj->name, $obj->description, $user->name);
		}
	} else if ($type === 'groupsjoined') {
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT * FROM {$dbprefix}entity_relationships WHERE relationship = 'member'";
		$groupsjoined = get_data($query);

		foreach($groupsjoined as $key => $obj){
			$user = get_user($obj->guid_one);
			$group = get_entity($obj->guid_two);
			$data[] = array($obj->time_created, $user->name, $group->name);
		}
	} else if ($type === 'likes') {
		$likes = elgg_get_annotations(array(
			'annotation_names' => array('likes'),
			'limit' => 0
		));

		foreach($likes as $key => $obj){
			$entity = get_entity($obj->entity_guid);
			$user = get_user($obj->owner_guid);
			$user_liked = ($entity->title != "" ? $entity->title : ($entity->name != "" ? $entity->name : $entity->description));
			$data[] = array($obj->time_created, $user->name, $user_liked);
		}
	} else if ($type === 'messages') {
		$messages = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'messages',
			'limit' => 0
		));

		foreach($messages as $key => $obj){
			$user = get_user($obj->owner_guid);
			$data[] = array($obj->time_created, $obj->title, $user->name);
		}
	} 
    return $data;
}
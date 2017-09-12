<?php
$latestId = get_input('latest');

//main content of page
$db_prefix = elgg_get_config('dbprefix');
$dept = elgg_get_logged_in_user_entity()->department;
$options['joins'] = array("INNER JOIN {$db_prefix}metadata md ON md.entity_guid = rv.subject_guid LEFT JOIN {$db_prefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$db_prefix}metastrings msv ON md.value_id = msv.id");	// we need this to filter by metadata
$options['wheres'] = array("msn.string = \"department\" AND msv.string LIKE \"{$dept}\" AND rv.id > {$latestId}");

//remove friend connections from action types
$actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');
//load user's preference
$filteredItems = array(elgg_get_logged_in_user_entity()->DAconnections);
//filter out preference
$options['action_types'] = array_diff( $actionTypes, $filteredItems);

$options['no_results'] = elgg_echo('river:none');
$activity = elgg_list_river($options);

//echo out the yolo code

echo $activity;

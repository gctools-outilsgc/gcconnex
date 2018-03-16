<?php
/*
 * Exposes API endpoints for Discussion entities
 */

elgg_ws_expose_function(
	"get.discussion",
	"get_discussion",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"thread" => array('type' => 'int', 'required' => false, 'default' => 1),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a discussion & all replies based on user id and discussion id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.discussions",
	"get_discussions",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves discussions based on user id',
	'POST',
	true,
	false
);

function get_discussion($user, $guid, $thread, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Discussion was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, "object", "groupforumtopic")) {
		return "Invalid discussion. Please try a different GUID";
	}



	$discussions = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'groupforumtopic',
		'guid' => $guid
	));
	$discussion = json_decode($discussions)[0];

	$discussion->title = gc_explode_translation($discussion->title, $lang);

	$likes = elgg_get_annotations(array(
		'guid' => $discussion->guid,
		'annotation_name' => 'likes'
	));
	$discussion->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $discussion->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$discussion->liked = count($liked) > 0;

	$discussion->userDetails = get_user_block($discussion->owner_guid, $lang);
	$discussion->description = gc_explode_translation($discussion->description, $lang);

	$discussionsArray = array();
	$discussionsArray[] = $discussion;

	if ($thread) {
		$all_replies = elgg_list_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'discussion_reply',
			'container_guid' => $guid
		));
		$replies = json_decode($all_replies);
		$replies = array_reverse($replies);

		foreach ($replies as $reply) {
			$discussionsArray[] = $reply;
		}
	}

	return $discussionsArray;
}

function get_discussions($user, $limit, $offset, $filters, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$filter_data = json_decode($filters);
	if (!empty($filter_data)) {
		$params = array(
			'type' => 'object',
			'subtype' => 'groupforumtopic',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->mine) {
			$params['owner_guid'] = $user_entity->guid;
		}

		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");
			$params['wheres'] = array("(oe.title LIKE '%" . $filter_data->name . "%' OR oe.description LIKE '%" . $filter_data->name . "%')");
		}

		if ($filter_data->mine) {
			$all_discussions = elgg_list_entities_from_relationship($params);
		} else {
			$all_discussions = elgg_list_entities_from_metadata($params);
		}
	} else {
		$all_discussions = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'groupforumtopic',
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$discussions = json_decode($all_discussions);

	foreach ($discussions as $discussion) {
		$discussion->name = gc_explode_translation($discussion->name, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $discussion->guid,
			'annotation_name' => 'likes'
		));
		$discussion->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $discussion->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$discussion->liked = count($liked) > 0;

		$discussion->userDetails = get_user_block($discussion->owner_guid, $lang);
		$discussion->description = gc_explode_translation($discussion->description, $lang);
	}

	return $discussions;
}

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

elgg_ws_expose_function(
	"get.discussionedit",
	"get_discussion_edit",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a discussion based on guid, returns only information required for edit',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
 "post.discussion",
 "post_discussion",
 array(
	"user" => array('type' => 'string', 'required' => true),
	"title" => array('type' => 'string', 'required' => true),
	"message" => array('type' =>'string', 'required' => true),
	"container_guid" => array('type' =>'string', 'required' => false, 'default' => ''),
	"access" => array('type' =>'int', 'required' => false, 'default' => 2),
	"open" => array('type' =>'int', 'required' => false, 'default' => 1),
	"topic_guid" => array('type' =>'int', 'required' => false, 'default' => 0),
	"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
 ),
 'Posts/Saves a new discussion topic',
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

function get_discussion_edit($user, $guid, $lang)
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
 if ($discussion->owner_guid != $user_entity->getGUID()){
	 return elgg_echo('discussion:error:permissions');
 }

 $discussion->title = json_decode($discussion->title);
 $discussion->description = json_decode($discussion->description);
 //access id?
 //status?
 $container = get_entity($discussion->container_guid);
 $discussion->group->public = $container->isPublicMembership();
 if (!$discussion->group->public && !$container->isMember($user_entity)){
	 return elgg_echo('discussion:error:permissions');
 }

 return $discussion;
}

function post_discussion($user, $title, $message, $container_guid, $access, $open, $topic_guid, $lang)
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

		//check required fields
		$titles = json_decode($title);
		$message = json_decode($message);
		if (!$titles->en && !$titles->fr) { return elgg_echo("discussion:error:missing"); }
		if (!$message->en && !$message->fr) { return elgg_echo("discussion:error:missing");  }
		if (!($titles->en && $message->en) && !($titles->fr && $message->fr)) { return "require-same-lang"; }

		$container = get_entity($container_guid);
		if (!$container || !$container->canWriteToContainer(0, 'object', 'groupforumtopic')) {
			return elgg_echo('discussion:error:permissions');
		}

		//Check if new topic or edit
		$new_topic = true;
		if ($topic_guid > 0) {
		 $new_topic = false;
		}

		if ($new_topic) {
			$topic = new ElggObject();
			$topic->subtype = 'groupforumtopic';
		} else {
			$topic = get_entity($guid);
			if (!elgg_instanceof($topic, 'object', 'groupforumtopic') || !$topic->canEdit()) {
				return elgg_echo('discussion:topic:notfound');
			}
		}

		//french english setup
		$title1 = htmlspecialchars($titles->en, ENT_QUOTES, 'UTF-8');
		$title2 = htmlspecialchars($titles->fr, ENT_QUOTES, 'UTF-8');
		$title =  gc_implode_translation($title1, $title2);
		$desc = gc_implode_translation($message->en, $message->fr);

		if ($access == 1 && !$container->isPublicMembership()){
			$access = 2; //Access cannot be public if group is not public. Default to group only.
		}
		$access_id = $access;
		if ($access_id === 2){
			$access_id = $container->group_acl; //Sets access id to match group only id.
		}


		$topic->title = $title;
		$topic->title2 = $title2;
		$topic->description = $desc;
		$topic->description2 = $message->fr;
		$topic->status = ($open == 1) ? "open" : "closed";
		$topic->access_id = $access_id;
		$topic->container_guid = $container_guid;

		$result = $topic->save();
		if (!$result) {
			return elgg_echo('discussion:error:notsaved');
		}

		//handle results differently for new topics and topic edits
		if ($new_topic) {
			system_message(elgg_echo('discussion:topic:created'));
			elgg_create_river_item(array(
				'view' => 'river/object/groupforumtopic/create',
				'action_type' => 'create',
				'subject_guid' => elgg_get_logged_in_user_guid(),
				'object_guid' => $topic->guid,
			));
		} else {
			system_message(elgg_echo('discussion:topic:updated'));
		}

		return $topic->getURL();
}

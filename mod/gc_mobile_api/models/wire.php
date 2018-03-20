<?php
/*
 * Exposes API endpoints for Wire entities
 */

elgg_ws_expose_function(
	"get.wirepost",
	"get_wirepost",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"thread" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a wire post & all replies based on user id and wire post id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.wireposts",
	"get_wireposts",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s wire posts based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.wirepostsbycolleagues",
	"get_wirepostsbycolleagues",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s colleague\'s wire posts based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.wirepostsbyuser",
	"get_wirepostsbyuser",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s wire posts based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"post.wire",
	"post_wire",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Posts a new wire post based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"reply.wire",
	"reply_wire",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Submits a reply to a wire post based on user id and wire post id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"edit.wire",
	"edit_wire",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Edits a wire post based on user id and wire post id',
	'POST',
	true,
	false
);

function wires_foreach($wire_posts, $user_entity)
{
	foreach ($wire_posts as $wire_post) {
		$wire_post_obj = get_entity($wire_post->guid);
		$reshare = $wire_post_obj->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1))[0];
		$wire_attachements = elgg_get_entities_from_relationship(array(
			'relationship' => 'is_attachment',
			'relationship_guid' => $wire_post->guid,
			'inverse_relationship' => true,
			'limit' => 1
		));

		if ($wire_attachements){
			$wire_post->attachment->guid = $wire_attachements[0]->getGUID();
			$wire_post->attachment->name = $wire_attachements[0]->original_filename;
		}

		$url = "";
		if (!empty($reshare)) {
			$url = $reshare->getURL();
		}

		$text = "";
		if (!empty($reshare->title)) {
			$text = $reshare->title;
		} elseif (!empty($reshare->name)) {
			$text = $reshare->name;
		} elseif (!empty($reshare->description)) {
			$text = elgg_get_excerpt($reshare->description, 140);
		}

		$wire_post->shareURL = $url;
		$wire_post->shareText = gc_explode_translation($text, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $wire_post->guid,
			'annotation_name' => 'likes'
		));
		$wire_post->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $wire_post->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$wire_post->liked = count($liked) > 0;

		$replied = elgg_get_entities_from_metadata(array(
			"metadata_name" => "wire_thread",
			"metadata_value" => $wire_post->wire_thread,
			"type" => "object",
			"subtype" => "thewire",
			"owner_guid" => $user_entity->guid
		));
		$wire_post->replied = count($replied) > 0;

		$wire_post->userDetails = get_user_block($wire_post->owner_guid, $lang);
		$wire_post->description = wire_filter($wire_post->description);
	}

	return $wire_posts;
}

function get_wirepost($user, $guid, $thread, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}


	$entity = get_entity($guid);
	if (!$entity) {
		return "Wire was not found. Please try a different GUID";
	}
	if (!$entity instanceof ElggWire) {
		return "Invalid wire. Please try a different GUID";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$thread_id = $entity->wire_thread;

	if ($thread) {
		$all_wire_posts = elgg_list_entities_from_metadata(array(
			"metadata_name" => "wire_thread",
			"metadata_value" => $thread_id,
			"type" => "object",
			"subtype" => "thewire",
			"limit" => 0,
			"preload_owners" => true
		));
		$wire_posts = json_decode($all_wire_posts);

		$wire_posts = wires_foreach($wire_posts, $user_entity);

	} else {
		$wire_posts = elgg_list_entities(array(
			"type" => "object",
			"subtype" => "thewire",
			"guid" => $guid
		));

		$wire_post = json_decode($wire_posts)[0];

		$wire_posts = wires_foreach($wire_posts, $user_entity);
	}

	return $wire_posts;
}

function get_wireposts($user, $limit, $offset, $filters, $lang)
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
			'subtype' => 'thewire',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->mine) {
			$all_wire_posts = elgg_list_entities_from_relationship($params);
		} else {
			$all_wire_posts = elgg_list_entities_from_metadata($params);
		}
	} else {
		$all_wire_posts = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'thewire',
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$wire_posts = json_decode($all_wire_posts);

	$wire_posts = wires_foreach($wire_posts, $user_entity);

	return $wire_posts;
}

function get_wirepostsbycolleagues($user, $limit, $offset, $lang)
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

	$all_wire_posts = elgg_list_entities_from_relationship(array(
		'type' => 'object',
		'subtype' => 'thewire',
		'relationship' => 'friend',
		'relationship_guid' => $user_entity->guid,
		'relationship_join_on' => 'container_guid',
		'limit' => $limit,
		'offset' => $offset
	));
	$wire_posts = json_decode($all_wire_posts);

	$wire_posts = wires_foreach($wire_posts, $user_entity);

	return $wire_posts;
}

function get_wirepostsbyuser($profileemail, $user, $limit, $offset, $lang)
{
	$user_entity = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$viewer = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$viewer) {
		return "Viewer user was not found. Please try a different GUID, username, or email address";
	}
	if (!$viewer instanceof ElggUser) {
		return "Invalid viewer user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$all_wire_posts = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'thewire',
		'owner_guid' => $user_entity->guid,
		'limit' => $limit,
		'offset' => $offset
	));
	$wire_posts = json_decode($all_wire_posts);

	$wire_posts = wires_foreach($wire_posts, $user_entity);

	return $wire_posts;
}

function post_wire($user, $message, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (trim($message) == "") {
		return elgg_echo("thewire:blank");
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$new_wire = thewire_save_post($message, $user_entity->guid, ACCESS_PUBLIC, 0);
	if (!$new_wire) {
		return elgg_echo("thewire:notsaved");
	}

	return elgg_echo("thewire:posted");
}

function reply_wire($user, $message, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (trim($message) == "") {
		return elgg_echo("thewire:blank");
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$new_wire = thewire_save_post($message, $user_entity->guid, ACCESS_PUBLIC, $guid);
	if (!$new_wire) {
		return elgg_echo("thewire:notsaved");
	}

	return elgg_echo("thewire:posted");
}

function edit_wire($user, $message, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$entity = get_entity($guid);
	if (!$entity) {
		return "Wire was not found. Please try a different GUID";
	}
	if (!$entity instanceof ElggWire) {
		return "Invalid wire. Please try a different GUID";
	}

	if (trim($message) == "") {
		return elgg_echo("thewire:blank");
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$message = htmlspecialchars($message, ENT_NOQUOTES, 'UTF-8');

	$result = elgg_echo("thewire:notsaved");
	if ($entity->canEdit()) {
		$entity->description = $message;
		if ($entity->save()) {
			$result = elgg_echo("thewire:posted");
		}
	}

	return $result;
}

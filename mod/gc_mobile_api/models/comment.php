<?php


elgg_ws_expose_function(
	"get.commentsall",
	"get_comments_all",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Gets comments for given entity (guid), uses limit and offset.',
	'POST',
	true,
	false
);



function get_comments_all($user, $guid, $limit, $offset, $lang)
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
	$subtype = 'nothing';
	if (!$entity) {
		return "Discussion was not found. Please try a different GUID";
	} else if (elgg_instanceof($entity, "object", "groupforumtopic")){
		$subtype = 'discussion_reply';
	} else {
		$subtype = 'comment';
	}

	$all_replies = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => $subtype,
		'container_guid' => $guid,
		'limit' => $limit,
		'offset' => $offset
	));
	$replies = json_decode($all_replies);
	$comments = array();
	foreach ($replies as $reply) {
		$reply->userDetails = get_user_block($reply->owner_guid, $lang);
		$comments[] = $reply;
	}

	return $comments;
}

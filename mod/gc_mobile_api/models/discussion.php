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
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a discussion & all replies based on user id and discussion id',
	'POST',
	true,
	false
);

function get_discussion( $user, $guid, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	$entity = get_entity( $guid );
	if( !$entity ) return "Discussion was not found. Please try a different GUID";
	if( !$entity instanceof ElggDiscussionReply ) return "Invalid discussion. Please try a different GUID";

	if( !elgg_is_logged_in() )
		login($user_entity);
	
	$discussions = elgg_list_entities(array(
	    'type' => 'object',
		'subtype' => 'groupforumtopic',
		'guid' => $guid
	));
	$discussion = json_decode($discussions)[0];

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

	$discussion->comments = get_entity_comments($discussion->guid);

	$discussion->userDetails = get_user_block($discussion->owner_guid, $lang);

	return $discussion;
}

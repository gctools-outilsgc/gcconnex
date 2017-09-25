<?php
/*
 * Exposes API endpoints for File entities
 */

elgg_ws_expose_function(
	"get.file",
	"get_file",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a file based on user id and file id',
	'POST',
	true,
	false
);

function get_file( $user, $guid, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	$entity = get_entity( $guid );
	if( !$entity ) return "File was not found. Please try a different GUID";
	if( !$entity instanceof ElggFile ) return "Invalid file. Please try a different GUID";

	if( !elgg_is_logged_in() )
		login($user_entity);
	
	$files = elgg_list_entities(array(
	    'type' => 'object',
		'subtype' => 'file',
		'guid' => $guid
	));
	$file = json_decode($files)[0];

	$likes = elgg_get_annotations(array(
		'guid' => $file->guid,
		'annotation_name' => 'likes'
	));
	$file->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $file->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$file->liked = count($liked) > 0;

	$file->comments = get_entity_comments($file->guid);
	
	$file->userDetails = get_user_block($file->owner_guid, $lang);

	return $file;
}

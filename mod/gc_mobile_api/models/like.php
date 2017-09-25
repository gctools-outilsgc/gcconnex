<?php
/*
 * Exposes API endpoints for Like annotations
 */

elgg_ws_expose_function(
	"like.item",
	"like_item",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Submits a like/unlike on an entity based on user id and entity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"like.count",
	"like_count",
	array(
		"guid" => array('type' => 'int', 'required' => true),
		"user" => array('type' => 'string', 'required' => false),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a like count on an entity based on user id and entity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"like.users",
	"like_users",
	array(
		"guid" => array('type' => 'int', 'required' => true),
		"user" => array('type' => 'string', 'required' => false),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves all users who liked an entity based on user id and entity id',
	'POST',
	true,
	false
);

function like_item( $user, $guid, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	if( !elgg_is_logged_in() )
		login($user_entity);
	
	$entity = get_entity( $guid );
	if( !$entity ) return "Object was not found. Please try a different GUID";
	if( !$entity instanceof ElggObject ) return "Invalid object. Please try a different GUID";

	$likes = elgg_get_annotations(array(
		'guid' => $guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));

	$liked = false;

	// check to see if the user has already liked the item
	if( !empty($likes) ){
		$like = $likes[0];

		if( $like && $like->canEdit() ){
			$like->delete();
			$data['message'] = elgg_echo("likes:deleted");
		}
	} else {
		$annotation_id = create_annotation($entity->guid, 'likes', "likes", "", $user_entity->guid, $entity->access_id);
		$liked = true;

		// notify if poster wasn't owner
		if( $entity->owner_guid != $user_entity->guid ){
			$owner = $entity->getOwnerEntity();

			$annotation = elgg_get_annotation_from_id($annotation_id);

			$title_str = $entity->getDisplayName();
			if( !$title_str ){
				$title_str = elgg_get_excerpt($entity->description);
			}

			$site = elgg_get_site_entity();

			$subject = elgg_echo('likes:notifications:subject', array(
					$user_entity->name,
					$title_str
				),
				$owner->language
			);

			$body = elgg_echo('likes:notifications:body', array(
					$owner->name,
					$user_entity->name,
					$title_str,
					$site->name,
					$entity->getURL(),
					$user_entity->getURL()
				),
				$owner->language
			);

			notify_user(
				$entity->owner_guid,
				$user_entity->guid,
				$subject,
				$body,
				array(
					'action' => 'create',
					'object' => $annotation,
				)
			);
		}

		$data['message'] = elgg_echo("likes:likes");
	}

	$likes = elgg_get_annotations(array(
		'guid' => $guid,
		'annotation_name' => 'likes'
	));
	$data['count'] = count($likes);

	$data['liked'] = $liked;

	return $data;
}

function like_count( $guid, $user, $lang ){
	$entity = get_entity( $guid );
	if( !$entity ) return "Object was not found. Please try a different GUID";
	if( !$entity instanceof ElggObject ) return "Invalid object. Please try a different GUID";

	$likes = elgg_get_annotations(array(
		'guid' => $guid,
		'annotation_name' => 'likes'
	));
	$data['count'] = count($likes);

	if( $user ){
		$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
	 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
		if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

		if( $user_entity ){
			$likes = elgg_get_annotations(array(
				'guid' => $guid,
				'annotation_owner_guid' => $user_entity->guid,
				'annotation_name' => 'likes'
			));
			$data['liked'] = count($likes) > 0;
		}
	}

	return $data;
}

function like_users( $guid, $user, $lang ){
	$entity = get_entity( $guid );
	if( !$entity ) return "Object was not found. Please try a different GUID";
	if( !$entity instanceof ElggObject ) return "Invalid object. Please try a different GUID";

	$likes = elgg_get_annotations(array(
		'guid' => $guid,
		'annotation_name' => 'likes'
	));
	$data = array();

	foreach( $likes as $key => $like ){
		$item = get_user_block($like->owner_guid, $lang);
		$item['time_created'] = date("Y-m-d H:i:s", $like->time_created);
		$data['users'][] = $item;
	}

	$data['count'] = count($likes);

	if( $user ){
		$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
	 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
		if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

		if( $user_entity ){
			$likes = elgg_get_annotations(array(
				'guid' => $guid,
				'annotation_owner_guid' => $user_entity->guid,
				'annotation_name' => 'likes'
			));
			$data['liked'] = count($likes) > 0;
		}
	}

	return $data;
}

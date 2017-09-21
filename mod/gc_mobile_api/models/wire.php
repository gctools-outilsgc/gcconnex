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

function get_wirepost( $user, $guid, $thread, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	$entity = get_entity( $guid );
	if( !$entity ) return "Wire was not found. Please try a different GUID";
	if( !$entity instanceof ElggWire ) return "Invalid wire. Please try a different GUID";

	$thread_id = $entity->wire_thread;

	if( !elgg_is_logged_in() )
		login($user_entity);

	if( $thread ){
		$all_wire_posts = elgg_list_entities_from_metadata(array(
			"metadata_name" => "wire_thread",
			"metadata_value" => $thread_id,
			"type" => "object",
			"subtype" => "thewire",
			"limit" => 0,
			"preload_owners" => true
		));
		$wire_posts = json_decode($all_wire_posts);

		foreach($wire_posts as $wire_post){
			$wire_post_obj = get_entity($wire_post->guid);
			$reshare = $wire_post_obj->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1))[0];

			$url = "";
			if( !empty( $reshare ) ){
				$url = $reshare->getURL();
			}

			$text = "";
			if ( !empty($reshare->title) ) {
				$text = $reshare->title;
			} else if ( !empty($reshare->name) ) {
				$text = $reshare->name;
			} else if ( !empty($reshare->description) ) {
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
				"metadata_value" => $thread_id,
				"type" => "object",
				"subtype" => "thewire",
				"owner_guid" => $user_entity->guid
			));
			$wire_post->replied = count($replied) > 0;

			$wire_post->thread_id = $thread_id;

			$wire_post->userDetails = get_user_block($wire_post->owner_guid, $lang);
			$wire_post->description = wire_filter($wire_post->description);
		}
	} else {
		$wire_posts = elgg_list_entities(array(
			"type" => "object",
			"subtype" => "thewire",
			"guid" => $guid
		));
		$wire_post = json_decode($wire_posts)[0];

		$wire_post_obj = get_entity($wire_post->guid);
		$reshare = $wire_post_obj->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1))[0];

		$url = "";
		if( !empty( $reshare ) ){
			$url = $reshare->getURL();
		}

		$text = "";
		if ( !empty($reshare->title) ) {
			$text = $reshare->title;
		} else if ( !empty($reshare->name) ) {
			$text = $reshare->name;
		} else if ( !empty($reshare->description) ) {
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
			"metadata_value" => $thread_id,
			"type" => "object",
			"subtype" => "thewire",
			"owner_guid" => $user_entity->guid
		));
		$wire_post->replied = count($replied) > 0;

		$wire_post->thread_id = $thread_id;
		
		$wire_post->userDetails = get_user_block($wire_post->owner_guid, $lang);
		$wire_post->description = wire_filter($wire_post->description);

		$wire_posts = $wire_post;
	}

	return $wire_posts;
}

function get_wireposts( $user, $limit, $filters, $offset, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	if( !elgg_is_logged_in() )
		login($user_entity);

	$filter_data = json_decode($filters);
	if( !empty($filter_data) ){
		$params = array(
	        'type' => 'object',
	        'subtype' => 'thewire',
			'limit' => $limit,
	        'offset' => $offset
		);

		// if( $filter_data->mine ){
		// 	$params['relationship'] = 'member';
		// 	$params['relationship_guid'] = $user_entity->guid;
		// 	$params['inverse_relationship'] = FALSE;
		// }

		// if( $filter_data->name ){
		// 	$db_prefix = elgg_get_config('dbprefix');
  //       	$params['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
		// 	$params['wheres'] = array("(ge.name LIKE '%" . $filter_data->name . "%' OR ge.description LIKE '%" . $filter_data->name . "%')");
  //       }

        if( $filter_data->mine ){
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

	foreach($wire_posts as $wire_post){
		$wire_post_obj = get_entity($wire_post->guid);
		$reshare = $wire_post_obj->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1))[0];

		$url = "";
		if( !empty( $reshare ) ){
			$url = $reshare->getURL();
		}

		$text = "";
		if ( !empty($reshare->title) ) {
			$text = $reshare->title;
		} else if ( !empty($reshare->name) ) {
			$text = $reshare->name;
		} else if ( !empty($reshare->description) ) {
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

function get_wirepostsbyuser( $profileemail, $user, $limit, $offset, $lang ){
	$user_entity = is_numeric($profileemail) ? get_user($profileemail) : ( strpos($profileemail, '@') !== FALSE ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	$viewer = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$viewer ) return "Viewer user was not found. Please try a different GUID, username, or email address";
	if( !$viewer instanceof ElggUser ) return "Invalid viewer user. Please try a different GUID, username, or email address";

	if( !elgg_is_logged_in() )
		login($user_entity);

	$all_wire_posts = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'thewire',
		'owner_guid' => $user_entity->guid,
		'limit' => $limit,
		'offset' => $offset
	));
	$wire_posts = json_decode($all_wire_posts);

	foreach($wire_posts as $wire_post){
		$wire_post_obj = get_entity($wire_post->guid);
		$reshare = $wire_post_obj->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1))[0];

		$url = "";
		if( !empty( $reshare ) ){
			$url = $reshare->getURL();
		}

		$text = "";
		if ( !empty($reshare->title) ) {
			$text = $reshare->title;
		} else if ( !empty($reshare->name) ) {
			$text = $reshare->name;
		} else if ( !empty($reshare->description) ) {
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
			'annotation_owner_guid' => $viewer->guid,
			'annotation_name' => 'likes'
		));
		$wire_post->liked = count($liked) > 0;

		$replied = elgg_get_entities_from_metadata(array(
			"metadata_name" => "wire_thread",
			"metadata_value" => $wire_post->wire_thread,
			"type" => "object",
			"subtype" => "thewire",
			"owner_guid" => $viewer->guid
		));
		$wire_post->replied = count($replied) > 0;

		$wire_post->userDetails = get_user_block($wire_post->owner_guid, $lang);
		$wire_post->description = wire_filter($wire_post->description);
	}

	return $wire_posts;
}

function reply_wire( $user, $message, $guid, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	if( trim($message) == "" ) return elgg_echo("thewire:blank");

	if( !elgg_is_logged_in() )
		login($user_entity);

	$message = utf8_encode($message);

	$new_wire = thewire_save_post($message, $user_entity->guid, ACCESS_PUBLIC, $guid);
	if( !$new_wire ) return elgg_echo("thewire:notsaved");

	return elgg_echo("thewire:posted");
}

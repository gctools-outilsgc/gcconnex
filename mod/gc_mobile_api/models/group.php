<?php
/*
 * Exposes API endpoints for Group entities
 */

elgg_ws_expose_function(
	"get.group",
	"get_group",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.groups",
	"get_groups",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves groups based on user id',
	'POST',
	true,
	false
);

function get_group( $user, $guid, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	$entity = get_entity( $guid );
	if( !$entity ) return "Group was not found. Please try a different GUID";
	if( !$entity instanceof ElggGroup ) return "Invalid group. Please try a different GUID";

	if( !elgg_is_logged_in() )
		login($user_entity);
	
	$groups = elgg_list_entities(array(
		'type' => 'group',
		'guid' => $guid
	));
	$group = json_decode($groups)[0];
	
	$group->name = gc_explode_translation($group->name, $lang);

	$likes = elgg_get_annotations(array(
		'guid' => $group->guid,
		'annotation_name' => 'likes'
	));
	$group->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $group->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$group->liked = count($liked) > 0;

	$group->comments = get_entity_comments($group->guid);
	
	$group->userDetails = get_user_block($group->owner_guid, $lang);
	$group->description = clean_text(gc_explode_translation($group->description, $lang));

	return $group;
}

function get_groups( $user, $limit, $offset, $filters, $lang ){
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user) );
 	if( !$user_entity ) return "User was not found. Please try a different GUID, username, or email address";
	if( !$user_entity instanceof ElggUser ) return "Invalid user. Please try a different GUID, username, or email address";

	if( !elgg_is_logged_in() )
		login($user_entity);

	$filter_data = json_decode($filters);
	if( !empty($filter_data) ){
		$params = array(
	        'type' => 'group',
			'limit' => $limit,
	        'offset' => $offset
		);

		if( $filter_data->mine ){
			$params['relationship'] = 'member';
			$params['relationship_guid'] = $user_entity->guid;
			$params['inverse_relationship'] = FALSE;
		}

		if( $filter_data->name ){
			$db_prefix = elgg_get_config('dbprefix');
        	$params['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
			$params['wheres'] = array("(ge.name LIKE '%" . $filter_data->name . "%' OR ge.description LIKE '%" . $filter_data->name . "%')");
        }

        if( $filter_data->mine ){
	    	$all_groups = elgg_list_entities_from_relationship($params);
        } else {
	    	$all_groups = elgg_list_entities_from_metadata($params);
        }
	} else {
		$all_groups = elgg_list_entities(array(
	        'type' => 'group',
	        'limit' => $limit,
	        'offset' => $offset
	    ));
	}
	
	$groups = json_decode($all_groups);

	foreach($groups as $group){
		$group->name = gc_explode_translation($group->name, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $group->guid,
			'annotation_name' => 'likes'
		));
		$group->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $group->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$group->liked = count($liked) > 0;

		$groupObj = get_entity($group->guid);
		$group->member = $groupObj->isMember($user_entity);
		$group->owner = ($groupObj->getOwnerEntity() == $user_entity);
		$group->iconURL = $groupObj->geticon();
		$group->count = $groupObj->getMembers(array('count' => true));

		$group->userDetails = get_user_block($group->owner_guid, $lang);
		$group->description = clean_text(gc_explode_translation($group->description, $lang));
	}

	return $groups;
}

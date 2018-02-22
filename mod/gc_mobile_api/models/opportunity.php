<?php
/*
 * Exposes API endpoints for Opportunity entities
 */

elgg_ws_expose_function(
	"get.opportunity",
	"get_opportunity",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a opportunity based on user id and opportunity id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.opportunities",
	"get_opportunities",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves opportunities based on user id',
	'POST',
	true,
	false
);

function get_opportunity($user, $guid, $lang)
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
		return "Opportunity was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'mission')) {
		return "Invalid opportunity. Please try a different GUID";
	}



	$opportunities = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'mission',
		'guid' => $guid
	));
	$opportunity = json_decode($opportunities)[0];

	$opportunity->title = gc_explode_translation($opportunity->title, $lang);

	$likes = elgg_get_annotations(array(
		'guid' => $opportunity->guid,
		'annotation_name' => 'likes'
	));
	$opportunity->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $opportunity->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$opportunity->liked = count($liked) > 0;

	$opportunity->comments = get_entity_comments($opportunity->guid);

	$opportunity->userDetails = get_user_block($opportunity->owner_guid, $lang);
	$opportunity->description = gc_explode_translation($opportunity->description, $lang);

	return $opportunity;
}

function get_opportunities($user, $limit, $offset, $filters, $lang)
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
			'subtype' => 'mission',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->type) {
			$params['metadata_name'] = 'job_type';
			$params['metadata_value'] = $filter_data->type;
		}

		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");
			$params['wheres'] = array("(oe.title LIKE '%" . $filter_data->name . "%' OR oe.description LIKE '%" . $filter_data->name . "%')");
		}

		if ($filter_data->mine) {
			$all_opportunities = elgg_list_entities_from_relationship($params);
		} else {
			$all_opportunities = elgg_list_entities_from_metadata($params);
		}
	} else {
		$all_opportunities = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'mission',
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$opportunities = json_decode($all_opportunities);

	foreach ($opportunities as $opportunity) {
		$opportunity->title = gc_explode_translation($opportunity->title, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $opportunity->guid,
			'annotation_name' => 'likes'
		));
		$opportunity->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $opportunity->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$opportunity->liked = count($liked) > 0;

		$opportunityObj = get_entity($opportunity->guid);
		$opportunity->owner = ($opportunityObj->getOwnerEntity() == $user_entity);
		$opportunity->iconURL = $opportunityObj->getIconURL();

		$opportunity->userDetails = get_user_block($opportunity->owner_guid, $lang);
		$opportunity->description = clean_text(gc_explode_translation($opportunity->description, $lang));
	}

	return $opportunities;
}

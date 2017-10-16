<?php
/*
 * Exposes API endpoints for doc entities
 */

elgg_ws_expose_function(
	"get.doc",
	"get_doc",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a Doc based on user id and doc id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.docs",
	"get_docs",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves Docs based on user id',
	'POST',
	true,
	false
);

function get_doc($user, $guid, $lang)
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
		return "Doc was not found. Please try a different GUID";
	}
	if (!elgg_instanceof($entity, 'object', 'etherpad')) {
		return "Invalid Doc. Please try a different GUID";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$docs = elgg_list_entities(array(
		'type' => 'object',
		'subtypes' => array('etherpad', 'subpad'),
		'guid' => $guid
	));
	$doc = json_decode($docs)[0];

	$doc->name = gc_explode_translation($doc->name, $lang);

	$likes = elgg_get_annotations(array(
		'guid' => $doc->guid,
		'annotation_name' => 'likes'
	));
	$doc->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $doc->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$doc->liked = count($liked) > 0;

	$doc->comments = get_entity_comments($doc->guid);
	$doc->url = $entity->getPadPath();

	$doc->userDetails = get_user_block($doc->owner_guid, $lang);
	$doc->description = clean_text(gc_explode_translation($doc->description, $lang));

	return $doc;
}

function get_docs($user, $limit, $offset, $filters, $lang)
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
			'subtypes' => array('etherpad', 'subpad'),
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");
			$params['wheres'] = array("(oe.title LIKE '%" . $filter_data->name . "%' OR oe.description LIKE '%" . $filter_data->name . "%')");
		}

		$all_docs = elgg_list_entities_from_metadata($params);
	} else {
		$all_docs = elgg_list_entities(array(
			'type' => 'object',
			'subtypes' => array('etherpad', 'subpad'),
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$docs = json_decode($all_docs);

	foreach ($docs as $doc) {
		$doc->name = gc_explode_translation($doc->name, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $doc->guid,
			'annotation_name' => 'likes'
		));
		$doc->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $doc->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$doc->liked = count($liked) > 0;

		$docObj = new ElggPad($doc->guid);
		$doc->owner = ($docObj->getOwnerEntity() == $user_entity);
		$doc->iconURL = $docObj->getIconURL();
		$doc->url = $docObj->getPadPath();

		$doc->userDetails = get_user_block($doc->owner_guid, $lang);
		$doc->description = clean_text(gc_explode_translation($doc->description, $lang));
	}

	return $docs;
}

<?php
/*
 * Exposes API endpoints for Member entities
 */

elgg_ws_expose_function(
	"get.members",
	"get_members",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves members registered on GCcollab',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.memberscolleague",
	"get_members_colleague",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves members who are colleagues of a given user',
	'POST',
	true,
	false
);

function get_members($user, $limit, $offset, $filters, $lang)
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
			'type' => 'user',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->type) {
			$params['metadata_name'] = 'user_type';
			$params['metadata_value'] = $filter_data->type;
		}
		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}users_entity ue ON e.guid = ue.guid");
			$params['wheres'] = array("(ue.username LIKE '%" . $filter_data->name . "%' OR ue.name LIKE '%" . $filter_data->name . "%')");
		}

		$members = elgg_get_entities_from_metadata($params);
	} else {
		$members = elgg_get_entities(array(
			'type' => 'user',
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$data = array();
	foreach ($members as $member) {
		$member_obj = get_user($member->guid);
		$member_data = get_user_block($member->guid, $lang);

		$about = "";
		if ($member_obj->description) {
			$about = strip_tags($member_obj->description, '<p>');
			$about = str_replace("<p>&nbsp;</p>", '', $about);
		}

		$member_data['about'] = $about;
		$data[] = $member_data;
	}

	return $data;
}

function get_members_colleague($profileemail, $user, $limit, $offset, $filters, $lang)
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

	$defaults = array(
		'type' => 'user',
		'relationship' => 'friend',
		'relationship_guid' => $user_entity->getGUID(),
		'limit' => $limit,
		'offset' => $offset,
		'full_view' => false,
	);

	$vars = array();
	$filter_data = json_decode($filters);
	if (!empty($filter_data)) {
		if ($filter_data->type) {
			$vars['metadata_name'] = 'user_type';
			$vars['metadata_value'] = $filter_data->type;
		}
		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$vars['joins'] = array("JOIN {$db_prefix}users_entity ue ON e.guid = ue.guid");
			$vars['wheres'] = array("(ue.username LIKE '%" . $filter_data->name . "%' OR ue.name LIKE '%" . $filter_data->name . "%')");
		}
	}

	$options = array_merge($defaults, $vars);

	$members = elgg_list_entities_from_relationship($options);
	$members = json_decode($members);

	$data = array();
	foreach ($members as $member) {
		$member_obj = get_user($member->guid);
		$member_data = get_user_block($member->guid, $lang);

		$about = "";
		if ($member_obj->description) {
			$about = strip_tags($member_obj->description, '<p>');
			$about = str_replace("<p>&nbsp;</p>", '', $about);
		}

		$member_data['about'] = $about;
		$data[] = $member_data;
	}

	return $data;
}

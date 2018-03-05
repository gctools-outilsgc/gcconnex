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

elgg_ws_expose_function(
	"get.groupactivity",
	"get_group_activity",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en"),
		"api_version" => array('type' => 'float', 'required' => false, 'default' => 0)
	),
	'Retrieves a group\'s activity based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.groupblogs",
	"get_group_blogs",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group\'s blogs based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.groupdiscussions",
	"get_group_discussions",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group\'s discussions based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.groupdocs",
	"get_group_docs",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group\'s docs based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.groupevents",
	"get_group_events",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group\'s events based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.groupfiles",
	"get_group_files",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group\'s files based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"group.members",
	"get_groups_members",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a group\'s members based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"group.join",
	"join_group_function",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Joins a group based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"group.leave",
	"leave_group_function",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Leaves a group based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"group.invite",
	"invite_group_member",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Invites a member to a group based on user id and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"group.invitemembers",
	"invite_group_members",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Invites members to a group based on user ids and group id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"group.decline",
	"decline_group_invite",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Declines a group invite to a group based on user id and group id',
	'POST',
	true,
	false
);

function get_group($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$ia = elgg_set_ignore_access(true);
	$entity = get_entity($guid);
	elgg_set_ignore_access($ia);

	if (!$entity) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$entity instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

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

	$groupObj = get_entity($group->guid);
	$group->public = $groupObj->isPublicMembership();
	$group->member = $groupObj->isMember($user_entity);
	if (!$group->public && !$group->member){
		$group->access = false;
	} else {
		$group->access = true;
	}
	//Group 'Tools' that are enabled or not
	//Returning info hide anything not activitated
	$group->enabled = new stdClass();
	$group->enabled->activity = $groupObj->activity_enable;
	$group->enabled->bookmarks = $groupObj->bookmarks_enable;
	$group->enabled->file_tools_structure_management = $groupObj->file_tools_structure_management_enable;
	$group->enabled->etherpad = $groupObj->etherpad_enable;
	$group->enabled->blog = $groupObj->blog_enable;
	$group->enabled->forum = $groupObj->forum_enable; //discussions
	$group->enabled->event_calendar = $groupObj->event_calendar_enable;
	$group->enabled->file = $groupObj->file_enable;
	$group->enabled->photos = $groupObj->photos_enable; //image albums
	$group->enabled->tp_images = $groupObj->tp_images_enable; // group images
	$group->enabled->pages = $groupObj->pages_enable;
	$group->enabled->ideas = $groupObj->ideas_enable;
	$group->enabled->widget_manager = $groupObj->widget_manager_enable;
	$group->enabled->polls = $groupObj->polls_enable;
	$group->enabled->related_groups = $groupObj->related_groups_enable;
	$group->enabled->subgroups = $groupObj->subgroups_enable;
	$group->enabled->subgroups_members_create = $groupObj->subgroups_members_create_enable;
	// TODO - admin options / whats viewable to non-members, currently access variable can be used to block everything if they dont have access

	$group->owner = ($groupObj->getOwnerEntity() == $user_entity);
	$group->iconURL = $groupObj->geticon();
	$group->count = $groupObj->getMembers(array('count' => true));
	$group->tags = $groupObj->interests;
	$group->userDetails = get_user_block($group->owner_guid, $lang);

	if ($group->access){
		$group->description = gc_explode_translation($group->description, $lang);
	} else {
		$group->description = elgg_echo("groups:access:private", $lang);
	}
	return $group;
}

function get_groups($user, $limit, $offset, $filters, $lang)
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
			'type' => 'group',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->mine) {
			$params['relationship'] = 'member';
			$params['relationship_guid'] = $user_entity->guid;
			$params['inverse_relationship'] = false;
		}

		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
			$params['wheres'] = array("(ge.name LIKE '%" . $filter_data->name . "%' OR ge.description LIKE '%" . $filter_data->name . "%')");
		}

		if ($filter_data->mine) {
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

	foreach ($groups as $group) {
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

		$group->comments = get_entity_comments($group->guid);
		$group->tags = $groupObj->interests;

		$group->userDetails = get_user_block($group->owner_guid, $lang);
		$group->description = gc_explode_translation($group->description, $lang);
	}

	return $groups;
}

function get_group_activity($user, $guid, $limit, $offset, $lang, $api_version)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$all_activity = elgg_list_group_river(array(
		'limit' => $limit,
		'offset' => $offset,
		'wheres1' => array(
			"oe.container_guid = $group->guid",
		),
		'wheres2' => array(
			"te.container_guid = $group->guid",
		),
	));

	$activity = json_decode($all_activity);
	foreach ($activity as $event) {
		$subject = get_user($event->subject_guid);
		$object = get_entity($event->object_guid);
		$event->userDetails = get_user_block($event->subject_guid, $lang);

		if ($object instanceof ElggUser) {
			$event->object = get_user_block($event->object_guid, $lang);
			$event->object['type'] = 'user';
		} elseif ($object instanceof ElggWire) {
			$event->object['type'] = 'wire';
			$event->object['wire'] = wire_filter($object->description);

			$thread_id = $object->wire_thread;
			$reshare = $object->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1))[0];

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

			$event->shareURL = $url;
			$event->shareText = gc_explode_translation($text, $lang);
		} elseif ($object instanceof ElggGroup) {
			$event->object['type'] = 'group';
			$event->object['name'] = gc_explode_translation($object->name, $lang);
		} elseif ($object instanceof ElggDiscussionReply) {
			if ($api_version == 0.9){
				$event->object['type'] = 'discussion-reply';
				$original_discussion = get_entity($object->container_guid);
				$event->object['name'] = gc_explode_translation($original_discussion->title, $lang);
			} else {
				$event->object['type'] = 'discussion-reply';
				$original_discussion = get_entity($object->container_guid);
				$event->object['name'] = $original_discussion->title;
				$event->object['description'] = $object->description;
			}
		} elseif ($object instanceof ElggFile) {
			$event->object['type'] = 'file';
			if ($api_version == 0.9){
				$event->object['name'] = gc_explode_translation($object->title, $lang);
			} else {
				$event->object['name'] = $object->title;
				$event->object['description'] = $object->description;
			}
		} elseif ($object instanceof ElggObject) {
			$event->object['type'] = 'discussion-add';

			if($object->title){
				if (strpos($object->title, '"en":') !== false) {
					$event->object['name'] = gc_explode_translation($object->title, $lang);
				} else {
					$event->object['name'] = $object->title;
				}
			} else if($object->name){
				if (strpos($object->name, '"en":') !== false) {
					$event->object['name'] = gc_explode_translation($object->name, $lang);
				} else {
					$event->object['name'] = $object->name;
				}
			}

			if (strpos($object->description, '"en":') !== false) {
				$event->object['description'] = gc_explode_translation($object->description, $lang);
			} else {
				$event->object['description'] = $object->description;
			}

			$other = get_entity($event->object_guid);
			$parent = get_entity($other->container_guid);
			if ($parent instanceof ElggGroup) {
				if (!isset($event->object['name'])) {
					$event->object['name'] = ($parent->title) ? $parent->title : $parent->name;
				}
			} else {
				if (!isset($event->object['name'])) {
					$event->object['name'] = ($parent->title) ? $parent->title : $parent->name;
				}
			}
		} else {
			//@TODO handle any unknown events
			if (strpos($object->title, '"en":') !== false) {
				$event->object['name'] = gc_explode_translation($object->title, $lang);
			} else {
				$event->object['name'] = $object->title;
			}

			if (strpos($object->description, '"en":') !== false) {
				$event->object['description'] = gc_explode_translation($object->description, $lang);
			} else {
				$event->object['description'] = $object->description;
			}
		}
	}

	return $activity;
}

function get_group_blogs($user, $guid, $limit, $offset, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$blogs = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'blog',
		'container_guid' => $guid,
		'limit' => $limit,
		'offset' => $offset,
		'order_by' => 'e.last_action desc'
	));

	return json_decode($blogs);
}

function get_group_discussions($user, $guid, $limit, $offset, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$discussions = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'groupforumtopic',
		'container_guid' => $guid,
		'limit' => $limit,
		'offset' => $offset,
		'order_by' => 'e.last_action desc'
	));

	$discussions = json_decode($discussions);
	foreach ($discussions as $discussion) {
		
		$discussion->userDetails = get_user_block($discussion->owner_guid, $lang);
		$discussion->title = gc_explode_translation($discussion->title, $lang);
		$discussion->description = gc_explode_translation($discussion->description, $lang);
	}

	return $discussions;
}

function get_group_docs($user, $guid, $limit, $offset, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$docs = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'etherpad',
		'container_guid' => $guid,
		'limit' => $limit,
		'offset' => $offset,
		'order_by' => 'e.last_action desc'
	));

	return json_decode($docs);
}

function get_group_events($user, $guid, $limit, $offset, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$events = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'event_calendar',
		'container_guid' => $guid,
		'limit' => $limit,
		'offset' => $offset,
		'order_by' => 'e.last_action desc'
	));

	return json_decode($events);
}

function get_group_files($user, $guid, $limit, $offset, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$files = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'file',
		'container_guid' => $guid,
		'limit' => $limit,
		'offset' => $offset,
		'order_by' => 'e.last_action desc'
	));

	return json_decode($files);
}

function get_groups_members($user, $guid, $limit, $offset, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$db_prefix = elgg_get_config('dbprefix');
	$members = elgg_list_entities_from_relationship(array(
		'type' => 'user',
		'limit' => $limit,
		'offset' => $offset,
		'relationship' => 'member',
		'relationship_guid' => $guid,
		'inverse_relationship' => true,
		'joins' => array("JOIN {$db_prefix}users_entity u ON e.guid=u.guid"),
		'order_by' => 'u.name ASC'
	));
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

function join_group_function($user, $guid, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}



	// access bypass for getting invisible group
	$ia = elgg_set_ignore_access(true);
	$group = get_entity($guid);
	elgg_set_ignore_access($ia);

	if ($user_entity && ($group instanceof ElggGroup)) {

		// join or request
		$join = false;
		if ($group->isPublicMembership() || $group->canEdit($user_entity->guid)) {
			// anyone can join public groups and admins can join any group
			$join = true;
		} else {
			if (check_entity_relationship($group->guid, 'invited', $user_entity->guid)) {
				// user has invite to closed group
				$join = true;
			}
		}

		if ($join) {
			if (groups_join_group($group, $user_entity)) {


				// cyu - 05/12/2016: modified to comform to the business requirements documentation
				if (elgg_is_active_plugin('cp_notifications')) {
					$user_entity = elgg_get_logged_in_user_entity();
					add_entity_relationship($user_entity->getGUID(), 'cp_subscribed_to_email', $group->getGUID());
					add_entity_relationship($user_entity->getGUID(), 'cp_subscribed_to_site_mail', $group->getGUID());
				}

				return elgg_echo("groups:joined");
			} else {
				return elgg_echo("groups:cantjoin");
			}
		} else {
			add_entity_relationship($user_entity->guid, 'membership_request', $group->guid);

			$owner = $group->getOwnerEntity();

			$url = "{$CONFIG->url}groups/requests/$group->guid";

			$subject = elgg_echo('groups:request:subject', array(
				$user_entity->name,
				$group->name,
			), $owner->language);

			$body = elgg_echo('groups:request:body', array(
				$group->getOwnerEntity()->name,
				$user_entity->name,
				$group->name,
				$user_entity->getURL(),
				$url,
			), $owner->language);

			$params = [
				'action' => 'membership_request',
				'object' => $group,
			];

			// Notify group owner
			if (notify_user($owner->guid, $user_entity->getGUID(), $subject, $body, $params)) {
				return elgg_echo("groups:joinrequestmade");
			} else {
				return elgg_echo("groups:joinrequestnotmade");
			}
		}
	} else {
		return elgg_echo("groups:cantjoin");
	}
}

function leave_group_function($user, $guid, $lang)
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

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	elgg_set_page_owner_guid($group->guid);

	if ($user_entity && ($group instanceof ElggGroup)) {
		if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
			if ($group->leave($user_entity)) {

				// cyu - remove all the relationships when a user leaves a group
				if (elgg_is_active_plugin('cp_notifications')) {

					$group_content_arr = array('blog','bookmark','groupforumtopic','event_calendar','file',/*'hjforumtopic','hjforum',*/'photo','album','task','page','page_top','task_top','idea');
					$dbprefix = elgg_get_config('dbprefix');

					$query = "SELECT o.guid as content_id, o.title FROM {$dbprefix}entity_relationships r, {$dbprefix}objects_entity o, {$dbprefix}entities e, {$dbprefix}entity_subtypes es WHERE r.guid_one = {$user_entity->getGUID()} AND r.guid_two = o.guid AND o.title <> '' AND o.guid = e.guid AND e.container_guid = {$guid} AND es.id = e.subtype AND ( es.subtype = 'poll'";
					foreach ($group_content_arr as $grp_content_subtype)
						$query .= " OR es.subtype = '{$grp_content_subtype}'";
					$query .= " )";

					$group_contents = get_data($query);

					// unsubscribe to the group
					remove_entity_relationship($user_entity->getGUID(), 'cp_subscribed_to_email', $guid);
					remove_entity_relationship($user_entity->getGUID(), 'cp_subscribed_to_site_mail', $guid);
					// unsubscribe to group content if not already
					foreach ($group_contents as $group_content) {
						remove_entity_relationship($user_entity->getGUID(), 'cp_subscribed_to_email', $group_content->content_id);
						remove_entity_relationship($user_entity->getGUID(), 'cp_subscribed_to_site_mail', $group_content->content_id);
					}

				}

				//check if user is a group operator
				if(check_entity_relationship($user_entity->getGUID(), 'operator', $guid)){
					//remove operator rights
					remove_entity_relationship($user_entity->getGUID(), 'operator', $guid);
				}

				return elgg_echo("groups:left");
			} else {
				return elgg_echo("groups:cantleave");
			}
		} else {
			return elgg_echo("groups:cantleave");
		}
	} else {
		return elgg_echo("groups:cantleave");
	}
}

function invite_group_member($profileemail, $user, $guid, $lang)
{
	$invitee = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$invitee) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$invitee instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "Viewer user was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid viewer user. Please try a different GUID, username, or email address";
	}
	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	if (check_entity_relationship($group->guid, 'invited', $invitee->guid)) {
		return elgg_echo("groups:useralreadyinvited");
		continue;
	}

	if (check_entity_relationship($invitee->guid, 'member', $group->guid)) {
		// @todo add error message
		continue;
	}

	// Create relationship
	add_entity_relationship($group->guid, 'invited', $invitee->guid);

	$url = elgg_normalize_url("groups/invitations/$invitee->username");

	$subject = elgg_echo('groups:invite:subject', array(
		$invitee->name,
		$group->name
	), $invitee->language);

	$body = elgg_echo('groups:invite:body', array(
		$invitee->name,
		$user_entity->name,
		$group->name,
		$url,
	), $invitee->language);

	$params = [
		'action' => 'invite',
		'object' => $group,
	];

	// Send notification
	$result = notify_user($invitee->getGUID(), $group->owner_guid, $subject, $body, $params);

	if ($result) {
		return elgg_echo("groups:userinvited");
	} else {
		return elgg_echo("groups:usernotinvited");
	}
}

function invite_group_members($profileemail, $user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "Viewer user was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid viewer user. Please try a different GUID, username, or email address";
	}
	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	$user_guids = explode(',', $profileemail);
	if (count($user_guids) > 0 && elgg_instanceof($group, 'group') && $group->canEdit()) {
		foreach ($user_guids as $guid) {
			$invitee = is_numeric($guid) ? get_user($guid) : (strpos($guid, '@') !== false ? get_user_by_email($guid)[0] : get_user_by_username($guid));
			if (!$invitee) {
				continue;
			}
			if (!$invitee instanceof ElggUser) {
				continue;
			}

			if (check_entity_relationship($group->guid, 'invited', $invitee->guid)) {
				return elgg_echo("groups:useralreadyinvited");
				continue;
			}

			if (check_entity_relationship($invitee->guid, 'member', $group->guid)) {
				// @todo add error message
				continue;
			}

			// Create relationship
			add_entity_relationship($group->guid, 'invited', $invitee->guid);

			$url = elgg_normalize_url("groups/invitations/$invitee->username");

			$subject = elgg_echo('groups:invite:subject', array(
				$invitee->name,
				$group->name
			), $invitee->language);

			$body = elgg_echo('groups:invite:body', array(
				$invitee->name,
				$user_entity->name,
				$group->name,
				$url,
			), $invitee->language);

			$params = [
				'action' => 'invite',
				'object' => $group,
			];

			// Send notification
			$result = notify_user($invitee->getGUID(), $group->owner_guid, $subject, $body, $params);

			if ($result) {
				return elgg_echo("groups:userinvited");
			} else {
				return elgg_echo("groups:usernotinvited");
			}
		}
	}
}

function decline_group_invite($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "Viewer user was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid viewer user. Please try a different GUID, username, or email address";
	}
	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$group = get_entity($guid);
	if (!$group) {
		return "Group was not found. Please try a different GUID";
	}
	if (!$group instanceof ElggGroup) {
		return "Invalid group. Please try a different GUID";
	}

	// invisible groups require overriding access to delete invite
	$old_access = elgg_set_ignore_access(true);
	$group = get_entity($guid);
	elgg_set_ignore_access($old_access);

	// If join request made
	if (check_entity_relationship($group->guid, 'invited', $user_entity->guid)) {
		remove_entity_relationship($group->guid, 'invited', $user_entity->guid);
		return elgg_echo("groups:invitekilled");
	}

	return false;
}

<?php
/*
 * Exposes API endpoints for User entities
 */

elgg_ws_expose_function(
	"get.newsfeed2",
	"get_newsfeed2",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s newsfeed based on user id',
	'POST',
	true,
	false
);

function get_newsfeed2($user, $limit, $offset, $lang)
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

	$db_prefix = elgg_get_config('dbprefix');

	if ($user_entity) {
		// check if user exists and has friends or groups
		$hasfriends = $user_entity->getFriends();
		$hasgroups = $user_entity->getGroups();
		if ($hasgroups) {
			// loop through group guids
			$groups = $user_entity->getGroups(array('limit'=>0));
			$group_guids = array();
			foreach ($groups as $group) {
				$group_guids[] = $group->getGUID();
			}
		}
	} else {
		$hasfriends = false;
		$hasgroups = false;
		$group_guids = array();
	}

	$actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');

	if (!$hasgroups) {
	 	if(!$hasfriends) {
			// no friends and no groups :(
			$activity = '';
		} else {
			// has friends but no groups
			$optionsf = array();
			$optionsf['relationship_guid'] = $user_entity->guid;
			$optionsf['relationship'] = 'friend';
			$optionsf['pagination'] = true;

			// turn off friend connections
			// remove friend connections from action types
			// load user's preference
			$filteredItems = array($user_entity->colleagueNotif);
			// filter out preference
			$optionsf['action_types'] = array_diff($actionTypes, $filteredItems);

			$activity = json_decode(newsfeed_list_river($optionsf));
		}
	} elseif (!$hasfriends) {
		// if no friends but groups
		$guids_in = implode(',', array_unique(array_filter($group_guids)));

		// display created content and replies and comments
		$optionsg = array();
		$optionsg['wheres'] = array("( oe.container_guid IN({$guids_in}) OR te.container_guid IN({$guids_in}) )");
		$optionsg['pagination'] = true;
		$activity = json_decode(newsfeed_list_river($optionsg));
	} else {
		// if friends and groups :3
		// turn off friend connections
		// remove friend connections from action types
		// load user's preference
		$filteredItems = array($user_entity->colleagueNotif);
		// filter out preference
		$optionsfg = array();
		$optionsfg['action_types'] = array_diff($actionTypes, $filteredItems);

		$guids_in = implode(',', array_unique(array_filter($group_guids)));

		// Groups + Friends activity query
		// This query grabs new created content and comments and replies in the groups the user is a member of *** te.container_guid grabs comments and replies
		$optionsfg['wheres'] = array(
			"( oe.container_guid IN({$guids_in})
         	OR te.container_guid IN({$guids_in}) )
        	OR rv.subject_guid IN (SELECT guid_two FROM {$db_prefix}entity_relationships WHERE guid_one=$user_entity->guid AND relationship='friend')"
		);
		$optionsfg['pagination'] = true;
		$activity = json_decode(newsfeed_list_river($optionsfg));
	}

	foreach ($activity as $event) {
		$subject = get_user($event->subject_guid);
		$object = get_entity($event->object_guid);
		$event->userDetails = get_user_block($event->subject_guid, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $event->object_guid,
			'annotation_name' => 'likes'
		));
		$event->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $event->object_guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$event->liked = count($liked) > 0;

		if ($object->description) {
			$object->description = str_replace("<p>&nbsp;</p>", '', $object->description);
		}

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
			$event->object['description'] = gc_explode_translation($object->name, $lang);

			if (is_callable(array($object, 'getURL'))) {
				$event->object['url'] = $object->getURL();
			}
		} elseif ($object instanceof ElggDiscussionReply) {
			$event->object['type'] = 'discussion-reply';
			$original_discussion = get_entity($object->container_guid);
			$event->object['name'] = gc_explode_translation($original_discussion->title, $lang);
			$event->object['description'] = gc_explode_translation($object->description, $lang);

			$group = get_entity($original_discussion->container_guid);
			$event->object['group_guid'] = $group->guid;
			$event->object['group_title'] = gc_explode_translation($group->title, $lang);

			if (is_callable(array($original_discussion, 'getURL'))) {
				$event->object['url'] = $original_discussion->getURL();
			}
		} elseif ($object instanceof ElggFile) {
			$event->object['type'] = 'file';
			$event->object['name'] = gc_explode_translation($object->title, $lang);
			$event->object['description'] = gc_explode_translation($object->description, $lang);
			$event->object['url'] = $object->getURL();
		} elseif ($object instanceof ElggObject) {
			$subtype = $object->getSubtype();
			$event->object['type'] = $subtype;

			$name = ($object->title) ? $object->title : $object->name;
			if (empty(trim($name))) {
				$otherEntity = get_entity($object->container_guid);
				$name = ($otherEntity->title) ? $otherEntity->title : $otherEntity->name;
			}
			$event->object['name'] = $name;

			if (is_callable(array($object, 'getURL'))) {
				$event->object['url'] = $object->getURL();
			}

			$event->object['description'] = gc_explode_translation($object->description, $lang);

			$other = get_entity($object->container_guid);
			if ($other instanceof ElggGroup) {
				$event->object['group_title'] = gc_explode_translation($other->title, $lang);
				$event->object['group_guid'] = $other->guid;
			}
			if ($event->action == "comment") {
				$other_other = get_entity($other->container_guid);
				if ($other_other instanceof ElggGroup) {
					$event->object['group_title'] = gc_explode_translation($other_other->title, $lang);
					$event->object['group_guid'] = $other_other->guid;
				}
			}

			if (strpos($event->object['name'], '"en":') !== false) {
				$event->object['name'] = gc_explode_translation($event->object['name'], $lang);
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

			if (is_callable(array($object, 'getURL'))) {
				$event->object['url'] = $object->getURL();
			}
		}
	}

	return $activity;
}

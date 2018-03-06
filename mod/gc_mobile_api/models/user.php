<?php
/*
 * Exposes API endpoints for User entities
 */

elgg_ws_expose_function(
	"get.user",
	"get_user_data",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => false),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s profile information based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.userexists",
	"get_user_exists",
	array(
		"user" => array('type' => 'string', 'required' => false),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves whether a user exists based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.useractivity",
	"get_user_activity",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en"),
		"api_version" => array('type' => 'float', 'required' => false, 'default' => 0)
	),
	'Retrieves a user\'s activity information based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.usergroups",
	"get_user_groups",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s group information based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.newsfeed",
	"get_newsfeed",
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

elgg_ws_expose_function(
	"get.colleaguerequests",
	"get_colleague_requests",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a user\'s colleague requests based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"add.colleague",
	"add_colleague",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Adds a colleague for a user based on user ids',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"remove.colleague",
	"remove_colleague",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Removes a colleague for a user based on user ids',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"approve.colleague",
	"approve_colleague",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Approves a colleague request for a user based on user ids',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"decline.colleague",
	"decline_colleague",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Declines a colleague request for a user based on user ids',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"revoke.colleague",
	"revoke_colleague",
	array(
		"profileemail" => array('type' => 'string', 'required' => true),
		"user" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Revokes a colleague request for a user based on user ids',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"delete.post",
	"delete_post",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Deletes a user-owned object based on user id and post id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"share.post",
	"share_post",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"message" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Shares a user-owned object based on user id and post id',
	'POST',
	true,
	false
);

function build_date($month, $year)
{
	$string = "01/";
	switch ($month) {
		case 1:
			$string = "01/";
			break;
		case 2:
			$string = "02/";
			break;
		case 3:
			$string = "03/";
			break;
		case 4:
			$string = "04/";
			break;
		case 5:
			$string = "05/";
			break;
		case 6:
			$string = "06/";
			break;
		case 7:
			$string = "07/";
			break;
		case 8:
			$string = "08/";
			break;
		case 9:
			$string = "09/";
			break;
		case 10:
			$string = "10/";
			break;
		case 11:
			$string = "11/";
			break;
		case 12:
			$string = "12/";
			break;
	}
	return $string . $year;
}

function get_user_data($profileemail, $user, $lang)
{
	$user_entity = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if ($user) {
		$viewer = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
		if (!$viewer) {
			return "Viewer user was not found. Please try a different GUID, username, or email address";
		}
		if (!$viewer instanceof ElggUser) {
			return "Invalid viewer user. Please try a different GUID, username, or email address";
		}

		$friends = $viewer->isFriendsWith($user_entity->guid);

		if (!elgg_is_logged_in()) {
			login($viewer);
		}
	} else {
		$friends = false;
	}

	$user = array();
	$user['id'] = $user_entity->guid;
	$user['friend'] = $friends;
	$user['user_type'] = $user_entity->user_type;
	$user['username'] = $user_entity->username;
	$user['displayName'] = $user_entity->name;
	$user['email'] = $user_entity->email;
	$user['profileURL'] = $user_entity->getURL();
	$user['iconURL'] = $user_entity->getIconURL();
	$user['jobTitle'] = $user_entity->job;

	switch ($user_entity->user_type) {
		case "federal":
			$user['department'] = $user_entity->federal;
			break;
		case "student":
		case "academic":
			$institution = $user_entity->institution;
			$user['department'] = ($institution == 'university') ? $user_entity->university : ($institution == 'college' ? $user_entity->college : $user_entity->highschool);
			break;
		case "provincial":
			$user['department'] = $user_entity->provincial . ' / ' . $user_entity->ministry;
			break;
		default:
			$user['department'] = $user_entity->{$user_entity->user_type};
			break;
	}

	$user['telephone'] = $user_entity->phone;
	$user['mobile'] = $user_entity->mobile;
	$user['website'] = $user_entity->website;

	if ($user_entity->facebook) {
		$user['links']['facebook'] = "http://www.facebook.com/".$user_entity->facebook;
	}
	if ($user_entity->google) {
		$user['links']['google'] = "http://www.google.com/".$user_entity->google;
	}
	if ($user_entity->github) {
		$user['links']['github'] = "https://github.com/".$user_entity->github;
	}
	if ($user_entity->twitter) {
		$user['links']['twitter'] = "https://twitter.com/".$user_entity->twitter;
	}
	if ($user_entity->linkedin) {
		$user['links']['linkedin'] = "http://ca.linkedin.com/in/".$user_entity->linkedin;
	}
	if ($user_entity->pinterest) {
		$user['links']['pinterest'] = "http://www.pinterest.com/".$user_entity->pinterest;
	}
	if ($user_entity->tumblr) {
		$user['links']['tumblr'] = "https://www.tumblr.com/blog/".$user_entity->tumblr;
	}
	if ($user_entity->instagram) {
		$user['links']['instagram'] = "http://instagram.com/".$user_entity->instagram;
	}
	if ($user_entity->flickr) {
		$user['links']['flickr'] = "http://flickr.com/".$user_entity->flickr;
	}
	if ($user_entity->youtube) {
		$user['links']['youtube'] = "http://www.youtube.com/".$user_entity->youtube;
	}

	// About Me
	$about_me = strip_tags($user_entity->description, '<p>');
	$about_me = str_replace("<p>&nbsp;</p>", '', $about_me);
	$user['about_me'] = $about_me;

	// Education
	$educationEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'education',
		'type' => 'object',
		'limit' => 0
	));
	$i = 0;
	foreach ($educationEntity as $school) {
		if ($school->access_id == ACCESS_PUBLIC || $school->access_id == ACCESS_LOGGED_IN || ($friends && $school->access_id == ACCESS_FRIENDS)) {
			$user['education']['item_'.$i]['school_name'] = $school->school;

			$user['education']['item_'.$i]['start_date'] = build_date($school->startdate, $school->startyear);

			if ($school->ongoing == "false") {
				$user['education']['item_'.$i]['end_date'] = build_date($school->enddate, $school->endyear);
			} else {
				$user['education']['item_'.$i]['end_date'] = "present/actuel";
			}
			$user['education']['item_'.$i]['degree'] = $school->degree;
			$user['education']['item_'.$i]['field_of_study'] = $school->field;
			$i++;
		}
	}

	// Experience
	$experienceEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'experience',
		'type' => 'object',
		'limit' => 0
	));
	usort($experienceEntity, "sortDate");
	$i = 0;
	foreach ($experienceEntity as $job) {
		if ($job->access_id == ACCESS_PUBLIC || $job->access_id == ACCESS_LOGGED_IN || ($friends && $job->access_id == ACCESS_FRIENDS)) {
			$jobMetadata = elgg_get_metadata(array(
				'guid' => $job->guid,
				'limit' => 0
			));

			$user['experience']['item_'.$i]['job_title'] = $job->title;
			$user['experience']['item_'.$i]['organization'] = $job->organization;
			$user['experience']['item_'.$i]['start_date'] = build_date($job->startdate, $job->startyear);
			if ($job->ongoing == "false") {
				$user['experience']['item_'.$i]['end_date'] = build_date($job->enddate, $job->endyear);
			} else {
				$user['experience']['item_'.$i]['end_date'] = "present/actuel";
			}
			$user['experience']['item_'.$i]['responsibilities'] = $job->responsibilities;

			$j = 0;
			if (is_array($job->colleagues)) {
				foreach ($job->colleagues as $friend) {
					$friendEntity = get_user($friend);
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["id"] = $friendEntity->guid;
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["username"] = $friendEntity->username;

					//get and store user display name
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["displayName"] = $friendEntity->name;

					//get and store URL for profile
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["profileURL"] = $friendEntity->getURL();

					//get and store URL of profile avatar
					$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["iconURL"] = $friendEntity->getIconURL();
					$j++;
				}
			} elseif (!is_null($job->colleagues) && !empty(trim($job->colleagues))) {
				$friendEntity = get_user($job->colleagues);
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["id"] = $friendEntity->guid;
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["username"] = $friendEntity->username;

				//get and store user display name
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["displayName"] = $friendEntity->name;

				//get and store URL for profile
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["profileURL"] = $friendEntity->getURL();

				//get and store URL of profile avatar
				$user['experience']['item_'.$i]['colleagues']['colleague_'.$j]["iconURL"] = $friendEntity->getIconURL();
			}
			$i++;
		}
	}

	// Skills
	if ($user_entity->skill_access == ACCESS_PUBLIC || $user_entity->skill_access == ACCESS_LOGGED_IN || ($friends && $user_entity->skill_access == ACCESS_FRIENDS)) {
		$skillsEntity = elgg_get_entities(array(
			'owner_guid'=>$user['id'],
			'subtype'=>'MySkill',
			'type' => 'object',
			'limit' => 0
		));

		$i=0;
		foreach ($skillsEntity as $skill) {
			$user['skills']['item_'.$i]['skill'] = $skill->title;

			$j = 0;
			if (is_array($skill->endorsements)) {
				foreach ($skill->endorsements as $friend) {
					$friendEntity = get_user($friend);
					if ($friendEntity instanceof ElggUser) {
						$user['skills']['item_'.$i]['endorsements']["user_".$j]["id"] = $friendEntity->guid;
						$user['skills']['item_'.$i]['endorsements']["user_".$j]["username"] = $friendEntity->username;
						$user['skills']['item_'.$i]['endorsements']["user_".$j]["displayName"] = $friendEntity->name;
						$user['skills']['item_'.$i]['endorsements']["user_".$j]["profileURL"] = $friendEntity->getURL();
						$user['skills']['item_'.$i]['endorsements']["user_".$j]["iconURL"] = $friendEntity->getIconURL();
					}
					$j++;
				}
			} elseif (!is_null($skill->endorsements)) {
				$friendEntity = get_user($skill->endorsements);
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["id"] = $friendEntity->guid;
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["username"] = $friendEntity->username;
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["displayName"] = $friendEntity->name;
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["profileURL"] = $friendEntity->getURL();
				$user['skills']['item_'.$i]['endorsements']["user_".$j]["iconURL"] = $friendEntity->getIconURL();
			}
			$i++;
		}
	}

	// Portfolio
	$portfolioEntity = elgg_get_entities(array(
		'owner_guid'=>$user['id'],
		'subtype'=>'portfolio',
		'type' => 'object',
		'limit' => 0
	));
	$i = 0;
	foreach ($portfolioEntity as $portfolio) {
		if ($portfolio->access_id == ACCESS_PUBLIC || $portfolio->access_id == ACCESS_LOGGED_IN || ($friends && $portfolio->access_id == ACCESS_FRIENDS)) {
			$user['portfolio']['item_'.$i]['title'] = $portfolio->title;
			$user['portfolio']['item_'.$i]['link'] = $portfolio->link;
			if ($portfolio->datestamped == "on") {
				$user['portfolio']['item_'.$i]['date'] = $portfolio->publishdate;
			}
			$user['portfolio']['item_'.$i]['description'] = $portfolio->description;
		}
	}

	$user['dateJoined'] = date("Y-m-d H:i:s", $user_entity->time_created);
	$user['lastActivity'] = date("Y-m-d H:i:s", $user_entity->last_action);
	$user['lastLogin'] = date("Y-m-d H:i:s", $user_entity->last_login);

	$options = array(
		'type' => 'object',
		'subtype' => 'thewire',
		'owner_guid' => $user_entity->guid,
		'limit' => 0
	);
	$wires = elgg_get_entities($options);
	$user['wires'] = count($wires);

	$options = array(
		'type' => 'object',
		'subtype' => 'blog',
		'owner_guid' => $user_entity->guid,
		'limit' => 0
	);
	$blogs = elgg_get_entities($options);
	$user['blogs'] = count($blogs);

	$colleagues = $user_entity->getFriends(array('limit' => 2000));
	$plus = "";
	if(count($colleagues) == 2000)
		$plus = "+";

	$user['colleagues'] = count($colleagues).''.$plus;

	return $user;
}

function get_user_exists($user, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));

	$valid = false;
	if ($user_entity instanceof ElggUser) {
		$is_validated = elgg_get_user_validation_status($user->guid);
		if ($is_validated) {
			$valid = true;
		}
	}

	return $valid;
}

function get_user_activity($profileemail, $user, $limit, $offset, $lang, $api_version)
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
		login($viewer);
	}

	$all_activity = elgg_list_river(array(
		'subject_guid' => $user_entity->guid,
		'distinct' => false,
		'limit' => $limit,
		'offset' => $offset
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
			$event->object['type'] = 'discussion-reply';
			$original_discussion = get_entity($object->container_guid);
			$event->object['name'] = gc_explode_translation($original_discussion->title, $lang);
			$event->object['description'] = gc_explode_translation($object->description, $lang);
		} elseif ($object instanceof ElggFile) {
			$event->object['type'] = 'file';
			$event->object['name'] = gc_explode_translation($object->title, $lang);
			$event->object['description'] = gc_explode_translation($object->description, $lang);
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

function get_user_groups($profileemail, $user, $lang)
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
		login($viewer);
	}

	$all_groups = elgg_list_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $user_entity->guid,
		'inverse_relationship' => false,
		'type' => 'group',
		'limit' => 0
	));

	$groups = json_decode($all_groups);
	foreach ($groups as $group) {
		$groupObj = get_entity($group->guid);
		$group->name = gc_explode_translation($group->name, $lang);
		$group->iconURL = $groupObj->getIconURL();
		$group->count = $groupObj->getMembers(array('count' => true));
		$group->description = clean_text(gc_explode_translation($group->description, $lang));
	}

	return $groups;
}

function get_newsfeed($user, $limit, $offset, $lang)
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

			if (is_callable(array($original_discussion, 'getURL'))) {
				$event->object['url'] = $original_discussion->getURL();
			}
		} elseif ($object instanceof ElggFile) {
			$event->object['type'] = 'file';
			$event->object['name'] = gc_explode_translation($object->title, $lang);
			$event->object['description'] = gc_explode_translation($object->description, $lang);
			$event->object['url'] = $object->getURL();
		} elseif ($object instanceof ElggObject) {
			$event->object['type'] = 'discussion-add';

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
				if (!isset($event->object['type'])) {
					$event->object['name'] = ($other->title) ? $other->title : $other->name;
				}
			} else {
				if (!isset($event->object['type'])) {
					$event->object['name'] = ($other->title) ? $other->title : $other->name;
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

function get_colleague_requests($user, $limit, $offset, $lang)
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

	$friendrequests = elgg_get_entities_from_relationship(array(
		"type" => "user",
		"relationship" => "friendrequest",
		"relationship_guid" => $user_entity->getGUID(),
		"inverse_relationship" => true,
		"limit" => $limit,
		"offset" => $offset
	));

	$data = array();
	foreach ($friendrequests as $member) {
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

function add_colleague($profileemail, $user, $lang)
{
	$friend = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$friend) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$friend instanceof ElggUser) {
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

	//Now we need to attempt to create the relationship
	if (empty($user_entity) || empty($friend)) {
		return elgg_echo("friend_request:add:failure");
	} else {
		//New for v1.1 - If the other user is already a friend (fan) of this user we should auto-approve the friend request...
		if (check_entity_relationship($friend->getGUID(), "friend", $user_entity->getGUID())) {
			try {
				$user_entity->addFriend($friend->getGUID());
				return true;
			} catch (Exception $e) {
				return elgg_echo("friends:add:failure", array($friend->name));
			}
		} elseif (check_entity_relationship($friend->getGUID(), "friendrequest", $user_entity->getGUID())) {
			// Check if your potential friend already invited you, if so make friends
			if (remove_entity_relationship($friend->getGUID(), "friendrequest", $user_entity->getGUID())) {

				// Friends mean reciprical...
				$user_entity->addFriend($friend->getGUID());
				$friend->addFriend($user_entity->getGUID());

				$n_result = notify_user(
					$friend->guid,
					$user_entity->guid,
					elgg_echo('friend:newfriend:subject', array(
						$user_entity->name,
						$user_entity->name,
					)),
					elgg_echo("friend:newfriend:body", array(
						$user_entity->name,
						$user_entity->getURL(),
						elgg_get_site_url().'notifications/personal/',

						$user_entity->name,
						$user_entity->getURL(),
						elgg_get_site_url().'notifications/personal/',
					))
				);

				// add to river
				elgg_create_river_item(array(
					"view" => "river/relationship/friend/create",
					"action_type" => "friend",
					"subject_guid" => $user_entity->getGUID(),
					"object_guid" => $friend->getGUID(),
				));
				elgg_create_river_item(array(
					"view" => "river/relationship/friend/create",
					"action_type" => "friend",
					"subject_guid" => $friend->getGUID(),
					"object_guid" => $user_entity->getGUID(),
				));

				return true;
			} else {
				return elgg_echo("friend_request:approve:fail", array($friend->name));
			}
		} else {
			try {
				if (!add_entity_relationship($user_entity->getGUID(), "friendrequest", $friend->getGUID())) {
					return elgg_echo("friend_request:add:exists", array($friend->name));
				}
			} catch (Exception $e) {	//register_error calls insert_data which CAN raise Exceptions.
				return elgg_echo("friend_request:add:exists", array($friend->name));
			}
		}
	}
}

function remove_colleague($profileemail, $user, $lang)
{
	$friend = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$friend) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$friend instanceof ElggUser) {
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

	if (!empty($friend)) {
		try {
			$user_entity->removeFriend($friend->getGUID());

			// remove river items
			elgg_delete_river(array(
				"view" => "river/relationship/friend/create",
				"subject_guid" => $user_entity->getGUID(),
				"object_guid" => $friend->getGUID()
			));

			try {
				//V1.1 - Old relationships might not have the 2 as friends...
				$friend->removeFriend($user_entity->getGUID());

				// remove river items
				elgg_delete_river(array(
					"view" => "river/relationship/friend/create",
					"subject_guid" => $friend->getGUID(),
					"object_guid" => $user_entity->getGUID()
				));

				// cyu - remove the relationship (if applicable) for the subscribed to user
				remove_entity_relationship($user_entity->guid, 'cp_subscribed_to_email', $friend->getGUID());
				remove_entity_relationship($user_entity->guid, 'cp_subscribe_to_site_mail', $friend->getGUID());

				return true;
			} catch (Exception $e) {
				// do nothing
			}
		} catch (Exception $e) {
			return elgg_echo("friends:remove:failure", array($friend->name));
		}
	} else {
		return elgg_echo("friends:remove:failure", array($friend->getGUID()));
	}
}

function approve_colleague($profileemail, $user, $lang)
{
	$friend = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$friend) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$friend instanceof ElggUser) {
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

	if (!empty($friend)) {
		if (remove_entity_relationship($friend->getGUID(), "friendrequest", $user_entity->getGUID())) {
			$user_entity->addFriend($friend->getGUID());
			$friend->addFriend($user_entity->getGUID());			//Friends mean reciprical...

			// notify the user about the acceptance
			$subject = elgg_echo("friend_request:approve:subject", array($user_entity->name, $user_entity->name));
			$message = elgg_echo("friend_request:approve:message", array($user_entity->name, $user_entity->getURL(), $user_entity->name, $user_entity->getURL()));

			$params = array(
				"action" => "add_friend",
				"object" => $user_entity
			);

			// cyu - 04/04/2016: use new notification system hook instead (if activated)
			if (elgg_is_active_plugin('cp_notifications')) {
				$message = array(
					'object' => $user_entity,
					'cp_request_guid' => $friend->getGUID(),
					'cp_approver' => $user_entity->name,
					'cp_approver_profile' => $user_entity->getURL(),
					'cp_msg_type' => 'cp_friend_approve'
				);
				$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
			} else {
				notify_user($friend->getGUID(), $user_entity->getGUID(), $subject, $message, $params);
			}

			// add to river
			elgg_create_river_item(array(
				"view" => "river/relationship/friend/create",
				"action_type" => "friend",
				"subject_guid" => $user_entity->getGUID(),
				"object_guid" => $friend->getGUID(),
			));
			elgg_create_river_item(array(
				"view" => "river/relationship/friend/create",
				"action_type" => "friend",
				"subject_guid" => $friend->getGUID(),
				"object_guid" => $user_entity->getGUID(),
			));

			return elgg_echo("friend_request:approve:successful", array($friend->name));
		} else {
			return elgg_echo("friend_request:approve:fail", array($friend->name));
		}
	}
}

function decline_colleague($profileemail, $user, $lang)
{
	$friend = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$friend) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$friend instanceof ElggUser) {
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

	if (!empty($friend)) {
		if (remove_entity_relationship($friend->getGUID(), "friendrequest", $user_entity->getGUID())) {
			$subject = elgg_echo("friend_request:decline:subject", array($user_entity->name));
			$message = elgg_echo("friend_request:decline:message", array($friend->name, $user_entity->name));

			return elgg_echo("friend_request:decline:success");
		} else {
			return elgg_echo("friend_request:decline:fail");
		}
	}
}

function revoke_colleague($profileemail, $user, $lang)
{
	$friend = is_numeric($profileemail) ? get_user($profileemail) : (strpos($profileemail, '@') !== false ? get_user_by_email($profileemail)[0] : get_user_by_username($profileemail));
	if (!$friend) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$friend instanceof ElggUser) {
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

	if (!empty($friend)) {
		if (remove_entity_relationship($user_entity->getGUID(), "friendrequest", $friend->getGUID())) {
			return elgg_echo("friend_request:revoke:success");
		} else {
			return elgg_echo("friend_request:revoke:fail");
		}
	}
}

function delete_post($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user));
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
	if (elgg_instanceof($entity, 'object') && $entity->canEdit()) {
		if ($entity->delete()) {
			return elgg_echo('blog:message:deleted_post');
		} else {
			return elgg_echo('blog:error:cannot_delete_post');
		}
	} else {
		return elgg_echo('blog:error:post_not_found');
	}
}

function share_post($user,$message,$guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : ( strpos($user, '@') !== FALSE ? get_user_by_email($user)[0] : get_user_by_username($user));
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

	$new_wire = thewire_tools_save_post($message, $user_entity->guid, ACCESS_PUBLIC, 0,'site', $guid);
	if (!$new_wire) {
		return elgg_echo("thewire:notsaved");
	}

	return elgg_echo("thewire:posted");

}

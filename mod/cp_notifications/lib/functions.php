<?php

/**
 * recursively search for the group guid
 *
 * @param integer 	$entity_guid_static
 * @param integer 	$entity_guid
 *
 */
function get_forum_in_group($entity_guid_static, $entity_guid) {
	$entity = get_entity($entity_guid);
	// (base) stop recursing when we reach group guid
	if ($entity instanceof ElggGroup)  
		return $entity_guid;
	else 
		return get_forum_in_group($entity_guid_static, $entity->getContainerGUID());
}


/**
 * @param integer 			$user_id 
 * @param string 			$name 
 * @param array <string> 	$values
 * @param string 			$label
 */
function create_checkboxes($user_id, $name, $values, $label, $id='') {
	$user_option = elgg_get_plugin_user_setting($name, $user_id, 'cp_notifications');
	$is_checked = (strcmp($user_option, 'set_digest_no') == 0 || strcmp($user_option, 'set_notify_off') == 0) ? false : true;

	$chkbox = elgg_view('input/checkbox', array(
		'name' => 		"params[{$name}]",
		'value' => 		$values[0],
		'default' => 	$values[1],
		'checked' => 	(strcmp($user_option, $name) == 0  || !$user_option) ? true : false,
		'label' => 		$label,
		'checked' => 	$is_checked,
		'id' =>		$id
	));

	return $chkbox;
}


/**
 * check if object is: public, logged in, in group (check if user is in group), in friend-circle (check if user is in friend-circle)
 * 
 * @param ElggObject $entity		the entity we will check permissions of
 * @param int $recipient_user_id	the user guid.. to check if user is author's circle or friend
 */
function cp_check_permissions($entity, $recipient_user_id = 0) {
	$access_id = $entity->access_id;
	if ($access_id == 2 || $access_id == 1) // public or logged-in access
		return true;

	if ($access_id == -2) { // author or author's friends
		return check_entity_relationship($recipient_user_id, 'friend', $entity->getOwnerGUID()); // returns object
	}

	// Note: non-group members cannot subscribe to a group...
	// check if user is in friend's circle
	if ($access_id > 2) {
		$user_id_list = get_members_of_access_collection($access_id, true); // returns list of id in collection
		if (in_array($recipient_user_id, $user_id_list))
			return true;
	}

	return false;
}



/**
 * We need to modify the headers so that emails can go out (header spoofing)
 *
 * @param string 	$event
 */
function cp_get_headers($event) { 	// $event will be null if nothing is passed into it (no default value set)

	$email_address = elgg_get_plugin_setting('cp_notifications_email_addr','cp_notifications');
	if (!$email_address || $email_address === '')
		$email_address = 'admin.gcconnex@tbs-sct.gc.ca'; // default if nothing is set
	$php_version = phpversion();

	$headers =  "From: GCconnex <{$email_address}> \r\n";
	$headers .= "Reply-To: GCconnex <{$email_address}> \r\n";
	$headers .= "Return-Path: GCconnex <{$email_address}> \r\n";
	$headers .= "X-Mailer: PHP/{$php_version} \r\n";
	$headers .= "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type: text/html; charset=utf-8 \r\n";
   
	if ($event === 'event') {
		$mime_boundary = "----Meeting Booking----".MD5(TIME());
		$headers .= 'Content-Type: multipart/alternative; boundary='.$mime_boundary."\r\n";
		$headers .= "Content-class: urn:content-classes:calendarmessage\n";
	}

	return $headers;
}



/**
 * scans the text object for any @mentions
 * 
 * @param string 	$cp_object
 */
function cp_scan_mentions($cp_object) {
	$fields = array('title','description','value');
	foreach($fields as $field) {
		$content = $cp_object->$field;													// pull the information from the fields saved to object
		if (preg_match_all("/\@([A-Za-z1-9]*).?([A-Za-z1-9]*)/", $content, $matches)) { // find all the string that matches: @christine.yu
			$users_found = array();
			foreach ($matches[0] as $match) {
				if (preg_match('/\s/',$match)) { 										// what if no space found? check for space
					$user_found = explode(' ',$match);
					$users_found[] = $user_found[0];
				}
			}
			return $users_found;
		}
	}
	return false;
}







/**
 * renders the correct subtype for the notification to display
 * 
 * @param string 			$subtype_name
 * @param optional string 	$english
 */
function cp_translate_subtype($subtype_name, $english = true) {
	$label = '';
	switch($subtype_name) {
		case 'blog':
			$label = 'blog';
			break;
		case 'bookmarks':
			$label = 'bookmark';
			break;
		case 'file':
			$label = 'file';
			break;
		case 'poll':
			$label = 'poll';
			break;
		case 'event_calendar':
			$label = 'event';
			break;
		case 'album':
			$label = 'album';
			break;
		case 'groupforumtopic':
			$label = 'discussion';
			break;
		case 'image':
			$label = 'photo';
			break;
		case 'idea':
			$label = 'idea';
			break;
		case 'page_top':
		case 'page':
				$label = 'page';
			break;
		case 'hjforumtopic':
			$label = 'forum topic';
			break;
		case 'hjforum':
			$label = 'forum';
			break;
		case 'thewire':
			$label = 'wire';
			if (!$english)
				$label = 'fil';
			break;
		case 'task_top':
			$label = 'task';
			break;
		case 'mission':
			$label = 'opportunity';
			break;
		default:
			$label = $subtype_name;
		break;
	}
	return $label;
}




/**
 * Helper function for notifications about new opportunities
 *
 * @param ElggUser 	$user_obj
 * @param string 	$mission_type
 */
function userOptedIn( $user_obj, $mission_type ) {
	$typemap = array(
		'missions:micro_mission' => 'opt_in_missions',
		'missions:job_swap'	=> 'opt_in_swap',
		'missions:mentoring' => 'opt_in_mentored',
		'missions:job_shadowing' => 'opt_in_shadowed',
		'missions:assignment' => 'opt_in_assignSeek',
		'missions:deployment' => 'opt_in_deploySeek',
		'missions:job_rotation'	=> 'opt_in_rotation',
		'missions:skill_share' => 'opt_in_ssSeek',
		'missions:peer_coaching' => 'opt_in_pcSeek',
		'missions:job_share' => 'opt_in_jobshare',
		);

	$typemap2 = array(
		'missions:micro-mission' => 'opt_in_missionCreate',
		'missions:job_swap' => 'opt_in_swap',
		'missions:mentoring' =>	'opt_in_mentoring',
		'missions:job_shadowing'	=>	'opt_in_shadowing',
		'missions:assignment'	=> 'opt_in_assignCreate',
		'missions:deployment'	=>	'opt_in_deployCreate',
		'missions:job_rotation'	=>	'opt_in_rotation',
		'missions:skill_share'	=>	'opt_in_ssCreate',
		'missions:peer_coaching'	=>	'opt_in_pcCreate',
		'missions:job_share'	=>	'opt_in_jobshare',
		);
	return $user_obj->$typemap[$mission_type] == 'gcconnex_profile:opt:yes' || $user_obj->$typemap2[$mission_type] == 'gcconnex_profile:opt:yes';
}





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
function create_checkboxes($user_id, $name, $values, $label, $id='chkboxID', $class='chkboxClass') {
	$user_option = elgg_get_plugin_user_setting($name, $user_id, 'cp_notifications');


	if (strcmp($name, 'cpn_set_digest_freq_daily') == 0) {
		$user_option_daily = elgg_get_plugin_user_setting('cpn_set_digest_freq_daily', $user_id, 'cp_notifications');
		$user_option_weekly = elgg_get_plugin_user_setting('cpn_set_digest_freq_weekly', $user_id, 'cp_notifications');

		if (!$user_option_daily && !$user_option_weekly) $user_option = 'set_digest_daily';
	}

	if (strcmp($name, 'cpn_set_digest_lang_en') == 0) {
		$user_option_en = elgg_get_plugin_user_setting('cpn_set_digest_lang_en', $user_id, 'cp_notifications');
		$user_option_fr = elgg_get_plugin_user_setting('cpn_set_digest_lang_fr', $user_id, 'cp_notifications');

		if (!$user_option_en && !$user_option_fr) $user_option = 'set_digest_en';
	}

	$is_checked = (strcmp($user_option, 'set_digest_no') == 0 || strcmp($user_option, 'set_notify_off') == 0 || !$user_option || strpos($name, 'cpn_group_') !== false) ? false : true;

	$digest_option = elgg_get_plugin_user_setting('cpn_set_digest', $user_id, 'cp_notifications');
	$disabled = (strcmp('set_digest_yes', $digest_option) == 0 && strpos($name, 'site') !== false) ? true : false;

	$chkbox = elgg_view('input/checkbox', array(
		'name' => 		"params[{$name}]",
		'value' => 		$values[0],
		'default' => 	$values[1],
		'label' => 		$label,
		'checked' => 	$is_checked,
		'id' =>			$id,
		'class' =>		$class,
		'disabled' => 	$disabled
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
function cp_get_headers($event = '') { 	// $event will be null if nothing is passed into it (no default value set)

	$email_address = elgg_get_plugin_setting('cp_notifications_email_addr','cp_notifications');
	if (!$email_address || $email_address === '') $email_address = 'admin.gcconnex@tbs-sct.gc.ca';
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

				//if (preg_match('/\s/',$match)) { 										// what if no space found? check for space
					$user_found = explode(' ',$match);
					$users_found[] = $user_found[0];

				//}
			}
			return $users_found;
		}
	}
	return false;
}


function isJson($string) {
  json_decode($string);
  return (json_last_error() == JSON_ERROR_NONE);
}


/**
 * assembles the digest then encodes the array into JSON to be saved
 *
 * @param ElggUser 		$invoked_by
 * @param string 		$subtype
 * @param ElggEntity 	$entity
 * @param ElggUser 		$send_to
 * @param string 		$entity_url (default value empty)
 * @return Success 		true/false
 */
function create_digest($invoked_by, $subtype, $entity, $send_to, $entity_url = '') {

	elgg_load_library('GCconnex_display_in_language');
	elgg_load_library('elgg:gc_notification:functions'); // cyu - lol i dont have this in my instance of gcconnex :|
	$digest = get_entity($send_to->cpn_newsletter);
	$digest_collection = json_decode($digest->description,true);

	$content_title = $entity->title; // default value for title

	if (!$entity->title) $entity = get_entity($entity->guid);

	if ($entity instanceof ElggObject) {
		$content_url = (!$entity_url) ? $entity->getURL() : $entity_url;

		if (isJson($entity->title))
		{
			// cyu - TODO: use the gc_explode_translation() (NEW)
			$content_title = json_decode($entity->title, true);

		} else {
			// cyu - TODO: use the gc_explode_translation() (OLD)
			if ($entity->title2) 
				$content_title = array('en' => $entity->title, 'fr' => $entity->title2);
			else 
				$content_title = array('en' => $entity->title, 'fr' => $entity->title);
			
		}

		$content_array = array(
			'content_title' => $content_title,
			'content_url' => $content_url."?utm_source=notification_digest&utm_medium=email",
			'subtype' => $entity->getSubtype(),
			'content_author_name' => $invoked_by->name,
			'content_author_url' => $invoked_by->getURL()."?utm_source=notification_digest&utm_medium=email"
		);

	} else {

		$content_array = array(
			'content_title' => 'colleague requests',
			'content_url' => $entity,
			'subtype' => $subtype
		);
	}



	switch ($subtype) {

		case 'thewire':
			$content_array = array(
				'content_description' => $entity->description,
				'content_url' => $content_url."?utm_source=notification_digest&utm_medium=email",
				'subtype' => $entity->getSubtype(),
				'content_author_name' => $invoked_by->name,
				'content_author_url' => $invoked_by->getURL()
			);

			$digest_collection['personal']['new_post'][$entity->guid] = json_encode($content_array);
			break;

		case 'mission':

			$content_array = array(
				'content_title' => $entity->title,
				'content_author_name' => $entity->getOwnerEntity()->name,
				'content_url' => $entity->getURL()."?utm_source=notification_digest&utm_medium=email",
				'subtype' => $entity->job_type,
				'deadline' => $entity->deadline
			);

			$digest_collection['mission']['new_post']["{$entity->guid}{$entity->getSubtype()}"] = json_encode($content_array);
			break;

		case 'comment':
		case 'discussion_reply':

			if ($entity->getContainerEntity() instanceof ElggGroup) 
				$digest_collection['group']["<a href='{$entity->getContainerEntity()->getURL()}'>{$entity->getContainerEntity()->name}</a>"]['response'][$entity->guid] = json_encode($content_array);
			else 
				$digest_collection['personal']['response'][$entity->guid] = json_encode($content_array);
			break;


		case 'cp_friend_request':
			$digest_collection['personal']['friend_request'][$invoked_by->guid] = json_encode($content_array);
		 	break;

		case 'cp_friend_approve':
			$digest_collection['personal']['friend_approved'][$invoked_by->guid] = json_encode($content_array);
			break;

		case 'cp_messageboard':

			$digest_collection['personal']['profile_message'][$entity->guid] = "{$invoked_by->username} has left u a msg on your profile => sending to... {$send_to->guid} / {$send_to->username}";
			break;


		case 'cp_hjtopic':
		case 'cp_hjpost':
			$group_title = get_entity(get_forum_in_group($entity->guid, $entity->guid))->name;
			$group_url = get_entity(get_forum_in_group($entity->guid, $entity->guid))->getURL();

			if ($subtype === 'cp_hjtopic') {

				$digest_collection['group']["<a href='{$group_url}'>{$group_title}</a>"]['forum_topic'][$entity->guid] = json_encode($content_array);
			
			} else {

				$content_array = array(
					'content_title' => $entity->getContainerEntity()->title,
					'content_url' => $content_url."?utm_source=notification_digest&utm_medium=email",
					'subtype' => $entity->getSubtype(),
					'content_author' => $entity->getOwnerEntity()->guid
				);

				$digest_collection['group']["<a href='{$group_url}'>{$group_title}</a>"]['forum_reply'][$entity->guid] = json_encode($content_array);
			}
			break;


		case 'like_comment':
		case 'like_reply':
		case 'post_likes':

			if ($subtype === "like_comment" || $subtype === "like_reply") {
				$content_title = array('en' => elgg_echo("cp_newsletter:body:view_comment_reply",'en'), 'fr' => elgg_echo("cp_newsletter:body:view_comment_reply",'fr'));
				$content_array = array(
					'content_title' => $content_title,
					'content_url' =>  $entity->getURL()."?utm_source=notification_digest&utm_medium=email",
					'subtype' => $entity->getSubtype(),
					'content_author_name' => $invoked_by->name,
					'content_author_url' => $invoked_by->getURL()
				);
			} elseif ($entity->getSubtype() === 'thewire') {

				$content_array = array(
					'content_title' => $entity->description,
					'content_url' =>  $entity->getURL()."?utm_source=notification_digest&utm_medium=email",
					'subtype' => $entity->getSubtype(),
					'content_author_name' => $invoked_by->name,
					'content_author_url' => $invoked_by->getURL()
				);

			} else {
				$entity_title = $entity->title;
				if ($entity->title == '')
					$entity_title = $entity->name;

				$content_array = array(
					'content_title' => $entity_title,
					'content_url' =>  $entity->getURL()."?utm_source=notification_digest&utm_medium=email",//$entity->getContainerEntity()->getURL()."?utm_source=notification_digest&utm_medium=email",
					'subtype' => $entity->getSubtype(),
					'content_author_name' => $invoked_by->name,
					'content_author_url' => $invoked_by->getURL()
				);
			}

			$digest_collection['personal']['likes']["{$entity->guid}{$author->guid}"] = json_encode($content_array);
			break;


		case 'content_revision':
			if (!is_array($digest_collection['personal']['content_revision']))
				$digest_collection['personal']['content_revision'] = array();
		
			$digest_collection['personal']['content_revision'][] = json_encode($content_array);
			break;

		case 'cp_wire_share':
			if (!is_array($digest_collection['personal']['cp_wire_share']))
				$digest_collection['personal']['cp_wire_share'] = array();

			$content_title = $entity->title;
			if (!$entity->title) $content_title = $entity->description;

			$content_array = array(
				'content_title' => $content_title,
				'content_url' => $entity->getURL()."?utm_source=notification_digest&utm_medium=email",
				'subtype' => $entity->getSubtype(),
				'content_author_name' => $invoked_by->name,
				'content_author_url' => $invoked_by->getURL()
			);

			$digest_collection['personal']['cp_wire_share'][] = json_encode($content_array);
			
			break;

		case 'cp_wire_mention':
			if (!is_array($digest_collection['personal']['cp_mention']))
				$digest_collection['personal']['cp_mention'] = array();


			$content_array = array(
				'content_url' => $entity->getURL()."?utm_source=notification_digest&utm_medium=email",
				'subtype' => 'wire_mention',
				'content_author' => $invoked_by->name,
				'content_author_url' => $invoked_by->getURL(), 
			);
			$digest_collection['personal']['cp_mention'][] = json_encode($content_array);
			break;

		case 'cp_mention':

			$content_array = array(
				'content_title' => $entity->getContainerEntity()->title,
				'content_url' => $content_url."?utm_source=notification_digest&utm_medium=email",
				'subtype' => $entity->getContainerEntity()->getSubtype(),
				'content_author' => $invoked_by->name,
				'content_author_url' => $invoked_by->getURL()
			);

			if (!is_array($digest_collection['personal']['cp_mention']))
				$digest_collection['personal']['cp_mention'] = array();

			$digest_collection['personal']['cp_mention'][] = json_encode($content_array);

			break;

		default:

			$entity = get_entity($entity->guid);
			
			if ($entity->getContainerEntity() instanceof ElggGroup)
				$digest_collection['group']["<a href='{$entity->getContainerEntity()->getURL()}?utm_source=notification_digest&utm_medium=email'>{$entity->getContainerEntity()->name}</a>"]['new_post'][$entity->guid] = json_encode($content_array);
			else 
				$digest_collection['personal']['new_post'][$entity->guid] = json_encode($content_array);

			break;
	}

	// save the information to the digest object for later access
	$ia = elgg_set_ignore_access(true);
	$digest->description = json_encode($digest_collection);
	$digest->save();
	elgg_set_ignore_access($ia);

	return true;
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
			$label = ($english) ? 'blog' : 'un blogue';
			break;
		case 'bookmarks':
			$label = ($english) ? 'bookmark' : 'un signet';
			break;
		case 'file':
			$label = ($english) ? 'file' : 'un fichier';
			break;
		case 'poll':
			$label = ($english) ? 'poll' : 'un sondage';
			break;
		case 'event_calendar':
			$label = ($english) ? 'event' : 'un événement';
			break;
		case 'album':
			$label = ($english) ? 'album' : 'un album';
			break;
		case 'groupforumtopic':
			$label = ($english) ? 'discussion' : 'une discussion';
			break;
		case 'image':
			$label = ($english) ? 'photo' : 'une image';
			break;
		case 'idea':
			$label = ($english) ? 'idea' : 'un idee';
			break;
		case 'page_top':
		case 'page':
				$label = ($english) ? 'page' : 'une page';
			break;
		case 'hjforumtopic':
			$label = ($english) ? 'forum topic' : 'un suget sur le forum';
			break;
		case 'hjforum':
			$label = ($english) ? 'forum' : 'un forum';
			break;
		case 'thewire':
			$label = ($english) ? 'wire' : 'un fil';
			break;
		case 'task_top':
			$label = ($english) ? 'task' : 'une tâche';
			break;
		case 'mission':
			$label = ($english) ? 'opportunity' : 'un oppourtunite';
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


/**
   * @param Array <string> $heading
   */
  function render_contents($content_array, $heading = '', $language_preference = 'en') {

    $author = $content_array['content_author_name'];

    // this is specifically for the Micro Missions portion due to extra field
    $subtype = elgg_echo($content_array['subtype']);
    $boolSubtype = ($language_preference === 'fr') ? false : true;
    $subtype = cp_translate_subtype($subtype, $boolSubtype);


    if ($content_array['deadline']) {

       $content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_array['content_title'];

      $closing_date = elgg_echo('cp_newsletter:digest:opportunities:date', $language_preference).$content_array['deadline'];
      $subtype = elgg_echo($content_array['subtype'], $language_preference);

      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:oppourtunity", array($author, $subtype, $url), $language_preference)." - ".$closing_date;


    } elseif ($heading === 'cp_wire_share') {

			$content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_array['content_title'];
			$url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
			if ($subtype === 'The Wire') $subtype = elgg_echo('cp_notifications:mail_body:your_wire_post', $language_preference);
			$rendered_content = elgg_echo("cp_notifications:mail_body:subtype:content_share", array($author, $subtype, $url), $language_preference);
    	

	} elseif ($heading === 'cp_mention') {


		if ($content_array['subtype'] === 'wire_mention') {

	   	  $content_title = elgg_echo("cp_notifications:subtype:name:thewire", $language_preference);
	   	  $author = $content_array['content_author'];

	      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
	      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:wire_mention", array($author, $url), $language_preference);

	    } else {
	   	  $content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_title = $content_array['content_title'];
	   	  $author = $content_array['content_author'];

	      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
	      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:mention", array($author, cp_translate_subtype($content_array['subtype']),$url), $language_preference);
	  	}


	} elseif ($heading === 'forum_reply') {

   	  $content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_array['content_title'];
   	  $author = get_entity($content_array['content_author']);

      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:hjforumpost", array($author->name, $url), $language_preference);


	} elseif (strcmp($heading, "content_revision") == 0) {

   	  $content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_array['content_title'];

      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:{$heading}", array($author, $subtype, $url), $language_preference);

    } elseif ($content_array['subtype'] === 'thewire' && $heading !== 'likes') {

      $url = elgg_echo('cp_notifications:subtype:name:thewire', $language_preference)." : <a href='{$content_array['content_url']}'>".$content_array['content_description']."</a>";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:{$content_array['subtype']}", array($author, $url), $language_preference);


    } elseif (strcmp($heading, "likes") === 0) {

      $content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_array['content_title'];
      //if (!$content_title) $content_title = elgg_echo('cp_notifications:mail_body:your_wire_post',$language_preference);

      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:{$heading}", array($author, $url), $language_preference);


    } elseif ($heading === 'response') {
      $content_title = (is_array($content_array['content_title'])) ? $content_array['content_title'][$language_preference] : $content_array['content_title'];

      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a>";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:{$heading}", array($author, $url), $language_preference);

    } else {


      // limit 35 characters
      if (is_array($content_array['content_title']))
        $content_title = $content_array['content_title'][$language_preference];
      else
        $content_title = $content_array['content_title'];

      $url = "<a href='{$content_array['content_url']}'>{$content_title}</a> {$closing_date}";

      $boolSubtype = ($language_preference === 'fr') ? false : true;
      $subtype = cp_translate_subtype($content_array['subtype'], $boolSubtype);
      $n = "";
      $vowels = array('a','e','i','o','u');
      if (in_array($subtype{0}, $vowels)) $n = "n";
      $rendered_content = elgg_echo("cp_notifications:mail_body:subtype:any", array($author, "",$subtype, $url), $language_preference);
    }
    return $rendered_content;
  }


  /**
   * @param string  $heading
   *
   */
  function render_headers($heading, $user_name='', $language = "en", $number='') {

    $proper_heading = '';
    $number_items = ($number > 1) ? "plural" : "singular";

    switch ($heading) {
      case 'new_mission':	
      case 'new_post_in_group':
      	$proper_heading = elgg_echo("cp_newsletter:heading:notify:new_post:group:{$number_items}", array(), $language);
      	break;
      case 'personal':
      case 'mission':
      case 'group':
      case 'new_post':
      case 'cp_wire_share':
      case 'likes':
      case 'friend_request':
      case 'content_revision':
      	$proper_heading = elgg_echo("cp_newsletter:heading:notify:{$heading}:{$number_items}", array(), $language);
      	break;

      case 'forum_topic':
      case 'forum_reply':
      case 'response':
        $proper_heading = elgg_echo("cp_newsletter:heading:notify:{$heading}:{$number_items}", array(), $language);
        break;
      case 'friend_approved':
       $proper_heading = elgg_echo("cp_newsletter:heading:notify:{$heading}:{$number_items}", array($user_name),$language);
      	break;
      case 'cp_mention':
      	$proper_heading = elgg_echo("cp_newsletter:heading:notify:{$heading}:{$number_items}", array(), $language);
      	break;
      default:
        $proper_heading = $heading;
        break;
    }

    return $proper_heading;
  }




/**
 *
 */
function information_icon($text, $url) {
	return "<span class='pull-right'><a title='{$text}'><i class='fa fa-info-circle icon-sel'><span class='wb-invisible'> </span></i></a></span>";
//	return "<span class='pull-right'><a title='{$text}' target='_blank' href='{$url}'><i class='fa fa-info-circle icon-sel'><span class='wb-invisible'> </span></i></a></span>";
}

function has_group_subscriptions($group_guid, $user_guid) {
	$dbprefix = elgg_get_config('dbprefix');

	// normal objects
	$query = "SELECT r.guid_one, r.relationship, r.guid_two  FROM {$dbprefix}entity_relationships r LEFT JOIN {$dbprefix}entities e ON r.guid_two = e.guid LEFT JOIN (SELECT guid FROM {$dbprefix}groups_entity WHERE guid = {$group_guid}) g ON e.container_guid = g.guid WHERE r.relationship LIKE 'cp_subscribed_to_%' AND e.type = 'object' AND e.container_guid = {$group_guid} AND r.guid_one = {$user_guid} LIMIT 1";

	$subscriptions = get_data($query);

	if (sizeof($subscriptions) == 0) {
		// forums
		$query = "SELECT elgg_subtype.entity_guid, elgg_subtype.entity_subtype
		FROM {$dbprefix}entity_relationships r
		LEFT JOIN 
			(SELECT e.guid AS entity_guid, s.subtype AS entity_subtype FROM {$dbprefix}entities e, {$dbprefix}entity_subtypes s WHERE (s.subtype = 'hjforumtopic' OR s.subtype = 'hjforum') AND e.subtype = s.id) elgg_subtype ON elgg_subtype.entity_guid = r.guid_two 
		WHERE r.guid_one = {$user_guid} AND r.relationship LIKE 'cp_subscribed_to_%'";

		$forums = get_data($query);

		foreach ($forums as $forum) {
			if (!empty($group_content->entity_guid) && $group_content->entity_guid > 0) {
		    	$content = get_entity($group_content->entity_guid);

				// we want the forum topic that resides in the group
		    	$container_id = (strcmp($content->getSubtype(), 'hjforumtopic') == 0) ? $content->getContainerGUID() : $container_id = $content->getGUID();
		    	
		    	if (get_forum_in_group($container_id,$container_id) == $group_guid)
		    		return 1;
		    }
		}
		return 0;
	}

	return (sizeof($subscriptions) > 0);
}



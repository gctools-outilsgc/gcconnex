<?php

/* CHECK & VALIDATE STRINGS */
function c_validate_string($subject_message) {
	$slash_count = substr_count($subject_message, " / ");
	$bar_count = substr_count($subject_message, " | ");
	
	if (($slash_count == 1) xor ($bar_count == 1))
	{
		if ($slash_count == 1)
			$bilingual = explode(" / ", $subject_message);
	
		if ($bar_count == 1)
			$bilingual = explode(" | ", $subject_message);
			
		if (strlen($bilingual[0]) > 25)
			$bilingual[0] = utf8_decode(substr($bilingual[0], 0, 20)."...");
		
		if (strlen($bilingual[1]) > 25)
			$bilingual[1] = utf8_decode(substr($bilingual[1], 0, 20).'...');
			
		return $bilingual;
		
	} else {

		if (strlen($subject_message) > 25 )
			return utf8_decode(substr($subject_message, 0, 20).'...');
	}
	
	return utf8_decode($subject_message);
}

/* FRIEND REQUEST (FRIEND REQUEST MODULE) */
function c_friend_request_event_create_friendrequest($event, $object_type, $object) {
	
	if (($object instanceof ElggRelationship)) {
		$user_one = get_user($object->guid_one);
		$user_two = get_user($object->guid_two);
			
		$view_friends_url = elgg_get_site_url() . "friend_request/" . $user_two->username;
			
		// Notify target user
		$subject = elgg_echo('friend_request:newfriend:subject', array($user_one->name,$user_one->name,));
		$message = elgg_echo("c_friend_request:newfriend:body", array(
			$user_one->name, 
			$view_friends_url,
			$user_one->getURL(),
			
			$user_one->name, 
			$view_friends_url,
			$user_one->getURL(),
		));
	
		return notify_user($object->guid_two, $object->guid_one, $subject, $message);
	}
}


/* DISCUSSION REPLY */
function c_discussion_create_reply_notification($hook, $type, $message, $params) {
	$reply = $params['annotation'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	$topic = $reply->getEntity();
	$poster = $reply->getOwnerEntity();
	$group = $topic->getContainerEntity();
	$owner = $topic->getOwnerEntity();

	return elgg_echo('discussion:notifications:reply:body', array(
		//$owner->name,
		$to_entity->name,
		$poster->name,
		$topic->title,
		$group->name,
		$reply->value,
		$topic->getURL(),
		elgg_get_site_url().'notifications/group/',
		
		//$owner->name,
		$to_entity->name,
		$poster->name,
		$topic->title,
		$group->name,
		$reply->value,
		$topic->getURL(),
		elgg_get_site_url().'notifications/group/',
	));
}

 
/* DISCUSSION REPLY SUBJECT */
function c_advanced_notifications_discussion_reply_subject_hook($hooks, $type, $return_value, $params) {
	$reply = $params['annotation'];
	$topic = $reply->getEntity();

	$subj_line = c_validate_string(utf8_encode(html_entity_decode($topic->title, ENT_QUOTES | ENT_HTML5 )));
	if (!is_array($subj_line))
	{
		$lang01 = $subj_line;
		$lang02 = $subj_line;
	} else {
		$lang01 = $subj_line[0];
		$lang02 = $subj_line[1];
	}
	
	return elgg_echo("discussion:notifications:reply:subject", array($lang01,$lang02));
}


/* NEW FILE UPLOAD BODY */
function c_file_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'file')) {
		$descr = $entity->description;
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
		
		if ($group instanceof ElggGroup) {
			return elgg_echo('group_file:notification', array(
				$owner->name,
				$group->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
				
				$owner->name,
				$group->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
			));
		} else {
			return elgg_echo('file:notification', array(
				$owner->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
				
				$owner->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			));
		}
	}
	return null;
}


/* NOTIFY WHEN SOMEONE ADDS A COLLEAGUE */
function c_relationship_notification_hook($event, $type, $object) {
	$user_one = get_entity($object->guid_one);

	return notify_user(
		$object->guid_two,
		$object->guid_one,
		elgg_echo('friend:newfriend:subject', array(
			$user_one->name,
			$user_one->name,				
		)),
			
		elgg_echo("friend:newfriend:body", array(
			$user_one->name, 
			$user_one->getURL(),
			elgg_get_site_url().'notifications/personal/',
			
			$user_one->name, 
			$user_one->getURL(),
			elgg_get_site_url().'notifications/personal/',
		))
	);
}


/* THE WIRE POST (SUBJECT) */
function c_thewire_send_response_notification($guid, $parent_guid, $user) {
	$parent_owner = get_entity($parent_guid)->getOwnerEntity();
	$user = elgg_get_logged_in_user_entity();

	// check to make sure user is not responding to self
	if ($parent_owner->guid != $user->guid) {
		// check if parent owner has notification for this user
		$send_response = true;
		global $NOTIFICATION_HANDLERS;
		foreach ($NOTIFICATION_HANDLERS as $method => $foo) {
			if (check_entity_relationship($parent_owner->guid, 'notify' . $method, $user->guid)) {
				$send_response = false;
			}
		}

		// create the notification message
		if ($send_response) {
			// grab same notification message that goes to everyone else
			$params = array(
				'entity' => get_entity($guid),
				'method' => "email",
			);
			$msg = c_thewire_notify_message("", "", "", $params);
		
			
			notify_user(
					$parent_owner->guid,
					$user->guid,
					elgg_echo('thewire:notify:subject'),
					$msg);
		}
	}
}


/* THE WIRE POST (NOTIFICATION BODY) */
function c_thewire_notify_message($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;
	$entity = $params['entity'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'thewire')) {
		$descr = $entity->description;
		$owner = $entity->getOwnerEntity();
		
		$is_reply = $entity->reply;

		if ($is_reply) {
			// have to do this because of poor design of Elgg notification system
			// cyu - 05/05/2015: does not work
			// if ($parent_post) {
			// 	$parent_owner = $parent_post->getOwnerEntity();
			// }

			$body = elgg_echo('thewire_reply:notify:reply', array(
				$owner->name,				
				$entity->description,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
				
				$owner->name,
				$entity->description,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			));
		} else {

			$body = elgg_echo('thewire_post:notify:reply', array(
				$owner->name,
				$entity->description,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
				
				$owner->name,
				$entity->description,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			));
		}
		$body .= elgg_echo('thewire') . ": {$CONFIG->url}thewire";
		return $body;
	}
	return $returnvalue;
}


/* SENDING INTERNAL MAIL THROUGH ELGG */
function c_messages_send($subject, $body, $recipient_guid, $sender_guid = 0, $original_msg_guid = 0, $notify = true, $add_to_sent = true) {
	global $messagesendflag;
	$messagesendflag = 1;

	global $messages_pm;
	if ($notify) {
		$messages_pm = 1;
	} else {
		$messages_pm = 0;
	}

	if ($sender_guid == 0) {
		$sender_guid = (int) elgg_get_logged_in_user_guid();
	}

	$message_to = new ElggObject();
	$message_sent = new ElggObject();

	$message_to->subtype = "messages";
	$message_sent->subtype = "messages";

	$message_to->owner_guid = $recipient_guid;
	$message_to->container_guid = $recipient_guid;
	$message_sent->owner_guid = $sender_guid;
	$message_sent->container_guid = $sender_guid;

	$message_to->access_id = ACCESS_PUBLIC;
	$message_sent->access_id = ACCESS_PUBLIC;

	$message_to->title = $subject;
	$message_to->description = $body;

	$message_sent->title = $subject;
	$message_sent->description = $body;

	$message_to->toId = $recipient_guid; // the user receiving the message
	$message_to->fromId = $sender_guid; // the user receiving the message
	$message_to->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_to->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_to->hiddenTo = 0; // this is used when a user deletes a message in their inbox

	$message_sent->toId = $recipient_guid; // the user receiving the message
	$message_sent->fromId = $sender_guid; // the user receiving the message
	$message_sent->readYet = 0; // this is a toggle between 0 / 1 (1 = read)
	$message_sent->hiddenFrom = 0; // this is used when a user deletes a message in their sentbox, it is a flag
	$message_sent->hiddenTo = 0; // this is used when a user deletes a message in their inbox

	$message_to->msg = 1;
	$message_sent->msg = 1;

	// Save the copy of the message that goes to the recipient
	$success = $message_to->save();

	// Save the copy of the message that goes to the sender
	if ($add_to_sent) {
		$message_sent->save();
	}

	$message_to->access_id = ACCESS_PRIVATE;
	$message_to->save();

	if ($add_to_sent) {
		$message_sent->access_id = ACCESS_PRIVATE;
		$message_sent->save();
	}

	if ($original_msg_guid && $success) {
		add_entity_relationship($message_sent->guid, "reply", $original_msg_guid);
	}

	$message_contents = strip_tags($body);
	if (($recipient_guid != elgg_get_logged_in_user_guid()) && $notify) {
		$recipient = get_user($recipient_guid);
		$sender = get_user($sender_guid);
		
		$subj_line = c_validate_string(utf8_encode(html_entity_decode($message_to->title, ENT_QUOTES | ENT_HTML5 )));
		if (!is_array($subj_line))
		{
			$lang01 = $subj_line;
			$lang02 = $subj_line;
		} else {
			$lang01 = $subj_line[0];
			$lang02 = $subj_line[1];
		} 
		
		$subject = elgg_echo('messages:email:subject', array($lang01, $lang02));
		$body = elgg_echo('messages:email:body', array(
			$sender->name,
			$message_contents,
			elgg_get_site_url() . "messages/inbox/" . $recipient->username,
			$sender->name,
			elgg_get_site_url() . "messages/compose?send_to=" . $sender_guid,
			elgg_get_site_url().'notifications/personal/',
			
			$sender->name,
			$message_contents,
			elgg_get_site_url() . "messages/inbox/" . $recipient->username,
			$sender->name,
			elgg_get_site_url() . "messages/compose?send_to=" . $sender_guid,
			elgg_get_site_url().'notifications/personal/',	
		));
		notify_user($recipient_guid, $sender_guid, $subject, $body);
	}
	$messagesendflag = 0;
	return $success;
}


/* VALIDATION EMAIL */
function c_uservalidationbyemail_check_auth_attempt($credentials) {
	
	if (!isset($credentials['username'])) {
		return;
	}
	$username = $credentials['username'];

	// See if the user exists and isn't validated
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);

	$user = get_user_by_username($username);
	if ($user && isset($user->validated) && !$user->validated) {
		// show an error and resend validation email
		// cyu - 01/29/2015: modified so system doesnt send out empty notifications to users
		//uservalidationbyemail_request_validation($user->guid);
		c_uservalidationbyemail_request_validation($user->guid);
		access_show_hidden_entities($access_status);
		throw new LoginException(elgg_echo('uservalidationbyemail:login:fail'));
	}
	access_show_hidden_entities($access_status);
}


/* SENDS OUT AN EMAIL TO HAVE THE USER VALIDATE THEIR EMAIL/ACCOUNT */
function c_uservalidationbyemail_request_validation($user_guid, $admin_requested = FALSE) {
	$site = elgg_get_site_entity();

	$user_guid = (int)$user_guid;
	$user = get_entity($user_guid);

	if (($user) && ($user instanceof ElggUser)) {
		// Work out validate link
		$code = uservalidationbyemail_generate_code($user_guid, $user->email);
		$link = "{$site->url}uservalidationbyemail/confirm?u=$user_guid&c=$code";

		// Send validation email
		$subject = elgg_echo('email:validate:subject', array($user->name, $site->name, $user->name, $site->name));
		$body = elgg_echo('email:validate:body', array(
			$user->name, 
			$site->name, 
			$link, 
			$site->name, 
			$site->url,
			elgg_get_site_url().'notifications/personal/',
			
			$user->name, 
			$site->name, 
			$link, 
			$site->name, 
			$site->url,
			elgg_get_site_url().'notifications/personal/',
		));
		$result = notify_user($user->guid, $site->guid, $subject, $body, NULL, 'email');

		if ($result && !$admin_requested) {
			system_message(elgg_echo('uservalidationbyemail:registerok'));
		}
		return $result;
	}
	return FALSE;
}


/* GENERATE EMAIL THEN SEND IT TO THE USER */
function c_send_new_password_request($user_guid) {
	$user_guid = (int)$user_guid;

	$user = get_entity($user_guid);
	if ($user instanceof ElggUser) {
		// generate code
		$code = generate_random_cleartext_password();
		$user->setPrivateSetting('passwd_conf_code', $code);

		// generate link
		$link = elgg_get_site_url() . "resetpassword?u=$user_guid&c=$code";

		// generate email
		$email = elgg_echo('email:resetreq:body', array(
			$user->name, 
			$_SERVER['REMOTE_ADDR'], 
			$link,
			
			$user->name, 
			$_SERVER['REMOTE_ADDR'], 
			$link,
		));
		return notify_user($user->guid, elgg_get_site_entity()->guid,
			elgg_echo('email:resetreq:subject'), $email, array(), 'email');
	}
	return false;
}


/* VALIDATE THEN RESETS THE PASSWORD TO THE USER */
function c_execute_new_password_request($user_guid, $conf_code) {
	global $CONFIG;

	$user_guid = (int)$user_guid;
	$user = get_entity($user_guid);

	if ($user instanceof ElggUser) {
		$saved_code = $user->getPrivateSetting('passwd_conf_code');

		if ($saved_code && $saved_code == $conf_code) {
			$password = generate_random_cleartext_password();

			if (force_user_password_reset($user_guid, $password)) {
				remove_private_setting($user_guid, 'passwd_conf_code');
				// clean the logins failures
				reset_login_failure_count($user_guid);
				
				$email = elgg_echo('email:resetpassword:body', array(
					$user->name, 
					$password,
					
					$user->name, 
					$password,
				));
				return notify_user($user->guid, $CONFIG->site->guid,
					elgg_echo('email:resetpassword:subject'), $email, array(), 'email');
			}
		}
	}
	return FALSE;
}


function c_html_email_handler_make_html_body($subject = "", $body = ""){
	global $CONFIG;
	
	// in some cases when page setup isn't done yet this can cause problems
	// so manually set is to done
	$unset = false;
	if(!isset($CONFIG->pagesetupdone)){
		$unset = true;
		$CONFIG->pagesetupdone = true;
	}
	
	// generate HTML mail body
	$result = elgg_view("html_email_handler/notification/body", array("title" => $subject, "message" => parse_urls($body)));

	// do we need to restore pagesetup
	if($unset){
		unset($CONFIG->pagesetupdone);
	}
	
	if(defined("XML_DOCUMENT_NODE")){
		if($transform = html_email_handler_css_inliner($result)){
			$result = $transform;
		}
	}
	return $result;
}


function c_event_calendar_send_event_request($event,$user_guid) {
	$result = FALSE;
	if(add_entity_relationship($user_guid, 'event_calendar_request', $event->guid)) {
		$subject = elgg_echo('event_calendar:request_subject');
		$name = get_entity($user_guid)->name;
		$title = $event->title;
		$url = $event->getUrl();
		$link = elgg_get_site_url().'event_calendar/review_requests/'.$event->guid;
		$message = elgg_echo('event_calendar:request_message', array(
			$name,
			$title,
			$url,
			$link,
			
			$name,
			$title,
			$url,
			$link,
		));
		notify_user($event->owner_guid,elgg_get_site_entity()->guid,$subject,$message);
		$result = TRUE;
	}
	return $result;
}


/* NEW BOOKMARKS */
function c_bookmarks_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'bookmarks')) {
		$descr = $entity->description;
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		$is_group = $entity->getContainerEntity();

		if ($is_group instanceof ElggGroup) {
			return elgg_echo('group_bookmarks:notification', array(
				$owner->name,
				$is_group->name,
				$title,
				$entity->address,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
				
				$owner->name,
				$is_group->name,
				$title,
				$entity->address,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',

			));
		} else {
			return elgg_echo('bookmarks:notification', array(
				$owner->name,
				$title,
				$entity->address,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
				
				$owner->name,
				$title,
				$entity->address,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			));
		}
	}
	return null;
}


/* NEW REPLY TO DISCUSSION TOPIC */
function c_reply_discussion($hook, $type, $message, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'messages')) {
		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
		return elgg_echo('discussion:notifications:reply:body',array(
			$to_entity->name,
			$owner->name,
			$entity->title,
		));
	}
}


/* NEW DISCUSSION TOPIC */
function c_groupforumtopic_notify_message($hook, $type, $message, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'groupforumtopic')) {
		$descr = $entity->description; 
		$title = $entity->title;
		$url = $entity->getURL();

		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();

		return elgg_echo('c_discussion:notification:body', array(
			$owner->name,
			$group->name,
			$entity->title,
			$entity->description,
			$entity->getURL(),
			elgg_get_site_url().'notifications/group/',
			
			$owner->name,
			$group->name,
			$entity->title,
			$entity->description,
			$entity->getURL(),
			elgg_get_site_url().'notifications/group/',
		));
	}
	return null;
}

/* NEW TASK NOTIFICATION */
function c_task_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	
	if (($entity instanceof ElggEntity) && (($entity->getSubtype() == 'task_top') || ($entity->getSubtype() == 'task'))) {
		$desc = $entity->description;
		$title = $entity->title;
		$url = elgg_get_site_url() . "view/" . $entity->guid;
		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
		
		if ($group instanceof ElggGroup) {
			return elgg_echo('group_c_tasks:new_body_email', array(
				$owner->name,
				$title,
				$group->name,
				$url,
				elgg_get_site_url().'notifications/group/',
				
				$owner->name,
				$title,
				$group->name,
				$url,
				elgg_get_site_url().'notifications/group/',
			));
		} else {
			return elgg_echo('c_tasks:new_body_email', array(
				$owner->name,
				$title,
				$url,
				elgg_get_site_url().'notifications/personal/',
				
				$owner->name,
				$title,
				$url,
				elgg_get_site_url().'notifications/personal/',
			));
		}
	}
	return null;
}


/* NEW PAGE NOTIFICATION */
function c_page_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (elgg_instanceof($entity, 'object', 'page') || elgg_instanceof($entity, 'object', 'page_top')) {
		$descr = $entity->description;
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
		
		return elgg_echo('pages:notification', array(
			$owner->name,
			$group->name,
			$title,
			$descr,
			$entity->getURL(),
			elgg_get_site_url().'notifications/personal/',
			
			$owner->name,
			$group->name,
			$title,
			$descr,
			$entity->getURL(),
			elgg_get_site_url().'notifications/personal/',
		));
	}
	return null;
}


/**
 * Disables a user upon registration.
 *
 * @param string $hook
 * @param string $type
 * @param bool   $value
 * @param array  $params
 * @return bool
 */
function c_uservalidationbyemail_disable_new_user($hook, $type, $value, $params) {
	$user = elgg_extract('user', $params);

	// no clue what's going on, so don't react.
	if (!$user instanceof ElggUser) {
		return;
	}

	// another plugin is requesting that registration be terminated
	// no need for uservalidationbyemail
	if (!$value) {
		return $value;
	}

	// has the user already been validated?
	if (elgg_get_user_validation_status($user->guid) == true) {
		return $value;
	}

	// disable user to prevent showing up on the site
	// set context so our canEdit() override works
	elgg_push_context('uservalidationbyemail_new_user');
	$hidden_entities = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);

	// Don't do a recursive disable.  Any entities owned by the user at this point
	// are products of plugins that hook into create user and might need
	// access to the entities.
	// @todo That ^ sounds like a specific case...would be nice to track it down...
	$user->disable('uservalidationbyemail_new_user', FALSE);

	// set user as unvalidated and send out validation email
	elgg_set_user_validation_status($user->guid, FALSE);
	c_uservalidationbyemail_request_validation($user->guid);

	elgg_pop_context();
	access_show_hidden_entities($hidden_entities);

	return $value;
}


/* SEND NOTIFICATION FOR A LIKE */
function c_likes_notify_user(ElggUser $user, ElggUser $liker, ElggEntity $entity) {
	
	if (!$user instanceof ElggUser) {
		return false;
	}
	
	if (!$liker instanceof ElggUser) {
		return false;
	}
	
	if (!$entity instanceof ElggEntity) {
		return false;
	}
	
	$title_str = $entity->title;
	if (!$title_str) {
		$title_str = elgg_get_excerpt($entity->description);
	}

	$site = get_config('site');

	$subj_line = c_validate_string(utf8_encode(html_entity_decode($title_str, ENT_QUOTES | ENT_HTML5 )));
	if (!is_array($subj_line))
	{
		$lang01 = $subj_line;
		$lang02 = $subj_line;
	} else {
		$lang01 = $subj_line[0];
		$lang02 = $subj_line[1];
	}
	
	$subject = elgg_echo('likes:notifications:subject', array(
					$liker->name,
					$lang01,
					
					$liker->name,
					$lang02,
				));
				

	$body = elgg_echo('likes:notifications:body', array(
					$user->name,
					$liker->name,
					$title_str,
					$site->name,
					$entity->getURL(),
					$liker->name,
					$liker->getURL(),
					elgg_get_site_url().'notifications/personal/',
					elgg_get_site_url().'notifications/group/',
					
					$user->name,
					$liker->name,
					$title_str,
					$site->name,
					$entity->getURL(),
					$liker->name,
					$liker->getURL(),
					elgg_get_site_url().'notifications/personal/',
					elgg_get_site_url().'notifications/group/',
				));
	notify_user($user->guid, $liker->guid, $subject, $body);
}


/* INVITE NEW USERS TO GROUP VIA EMAIL */
function c_group_tools_invite_email(ElggGroup $group, $email, $text = "", $resend = false) {
	$result = false;
	
	$loggedin_user = elgg_get_logged_in_user_entity();
	if (!empty($group) && ($group instanceof ElggGroup) && !empty($email) && is_email_address($email) && !empty($loggedin_user)) {
		// generate invite code
		$invite_code = group_tools_generate_email_invite_code($group->getGUID(), $email);
		
		if (!empty($invite_code)) {
			$found_group = group_tools_check_group_email_invitation($invite_code, $group->getGUID());
			if (empty($found_group) || $resend) {
				// make site email
				$site = elgg_get_site_entity();
				if (!empty($site->email)) {
					if (!empty($site->name)) {
						$site_from = $site->name . " <" . $site->email . ">";
					} else {
						$site_from = $site->email;
					}
				} else {
					// no site email, so make one up
					if (!empty($site->name)) {
						$site_from = $site->name . " <noreply@" . get_site_domain($site->getGUID()) . ">";
					} else {
						$site_from = "noreply@" . get_site_domain($site->getGUID());
					}
				}
				
				if (empty($found_group)) {
					// register invite with group
					$group->annotate("email_invitation", $invite_code . "|" . $email, ACCESS_LOGGED_IN, $group->getGUID());
				}
				
				$subj_line = c_validate_string(utf8_encode(html_entity_decode($group->name, ENT_QUOTES | ENT_HTML5 )));
				if (!is_array($subj_line))
				{
					$lang01 = $subj_line;
					$lang02 = $subj_line;
				} else {
					$lang01 = $subj_line[0];
					$lang02 = $subj_line[1];
				}
	
				// make subject
				$subject = elgg_echo("group_tools:groups:invite:email:subject", array(
					$lang01,
					$lang02));
				
				// make body
				$body = elgg_echo("group_tools:groups:invite:email:body", array(
					$loggedin_user->name,
					$group->name,
					$site->name,
					$text,
					$site->name,
					elgg_get_site_url()."register",
					elgg_get_site_url()."groups/invitations/?invitecode=".$invite_code,
					$invite_code,
					
					$loggedin_user->name,
					$group->name,
					$site->name,
					$text,
					$site->name,
					elgg_get_site_url()."register",
					elgg_get_site_url()."groups/invitations/?invitecode=".$invite_code,
					$invite_code,
				));
				
				$params = array(
					"group" => $group,
					"inviter" => $loggedin_user,
					"invitee" => $email
				);
				$body = elgg_trigger_plugin_hook("invite_notification", "group_tools", $params, $body);
				
				$result = elgg_send_email($site_from, $email, $subject, $body);
			} else {
				$result = null;
			}
		}
	}
	return $result;
}



/* INVITE USERS TO GROUP */
function c_group_tools_invite_user(ElggGroup $group, ElggUser $user, $text = "", $resend = false) {
	$result = false;
	
	$loggedin_user = elgg_get_logged_in_user_entity();
	
	if (!empty($user) && ($user instanceof ElggUser) && !empty($group) && ($group instanceof ElggGroup) && !empty($loggedin_user)) {
		// Create relationship
		$relationship = add_entity_relationship($group->getGUID(), "invited", $user->getGUID());
		
		if ($relationship || $resend) {
			// Send email
			$url = elgg_get_site_url() . "groups/invitations/" . $user->username;
			
			$subj_line = c_validate_string(utf8_encode(html_entity_decode($group->name, ENT_QUOTES | ENT_HTML5 )));
			if (!is_array($subj_line))
			{
				$lang01 = $subj_line;
				$lang02 = $subj_line;
			} else {
				$lang01 = $subj_line[0];
				$lang02 = $subj_line[1];
			}
			
			if ($text != "")
			{
				$eText = "<u>Message:</u> ".$text;
				$fText = "<u>Message</u> : ".$text;
			}
	
			$subject = elgg_echo("c_group_tools:groups:invite:subject", array(
				$lang01,
				$lang02,
			));
			$msg = elgg_echo("c_group_tools:groups:invite:body", array(
				$user->name,
				$loggedin_user->name,
				$group->name,
				$eText,
				$url,
				elgg_get_site_url().'notifications/group/',

				$user->name,
				$loggedin_user->name,
				$group->name,
				$fText,
				$url,
				elgg_get_site_url().'notifications/group/',
			));
			if (notify_user($user->getGUID(), $group->getOwnerGUID(), $subject, $msg, null, "email")) {
				$result = true;
			}
		}
	}
	return $result;
}


/* ADD USER TO GROUP */
function c_group_tools_add_user(ElggGroup $group, ElggUser $user, $text = "") {
	$result = false;
	
	$loggedin_user = elgg_get_logged_in_user_entity();
	
	if (!empty($user) && ($user instanceof ElggUser) && !empty($group) && ($group instanceof ElggGroup) && !empty($loggedin_user)) {
		// make sure all goes well
		$ia = elgg_set_ignore_access(true);
		
		if ($group->join($user)) {
			// Remove any invite or join request flags
			remove_entity_relationship($group->getGUID(), "invited", $user->getGUID());
			remove_entity_relationship($user->getGUID(), "membership_request", $group->getGUID());
				
			$subj_line = c_validate_string(utf8_encode(html_entity_decode($group->name, ENT_QUOTES | ENT_HTML5 )));
			if (!is_array($subj_line))
			{
				$lang01 = $subj_line;
				$lang02 = $subj_line;
			} else {
				$lang01 = $subj_line[0];
				$lang02 = $subj_line[1];
			} 
			
			if ($text != "") 
			{ 
				$eText = "<u>Personal Note</u>: ".$text; 
				$fText = "<u>Note Personnelle</u> : ".$text;
			}			
			
			// notify user
			$subject = elgg_echo("group_tools:groups:invite:add:subject", array($lang01, $lang02));
			$msg = elgg_echo("group_tools:groups:invite:add:body", array(
				$user->name,
				$loggedin_user->name,
				$group->name,
				$eText,
				$group->getURL(),
				elgg_get_site_url().'notifications/group/',
				
				$user->name,
				$loggedin_user->name,
				$group->name,
				$fText,
				$group->getURL(),
				elgg_get_site_url().'notifications/group/',
			));
			
			$params = array(
				"group" => $group,
				"inviter" => $loggedin_user,
				"invitee" => $user
			);
			$msg = elgg_trigger_plugin_hook("invite_notification", "group_tools", $params, $msg);
				
			if (notify_user($user->getGUID(), $group->getOwnerGUID(), $subject, $msg, null, "email")) {
				$result = true;
			}
		}
		// restore access
		elgg_set_ignore_access($ia);
	}
	return $result;
}


/* NEW BLOG POST */
function c_blog_notify_message($hook, $type, $message, $params) {

	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (elgg_instanceof($entity, 'object', 'blog')) {
			$descr = $entity->excerpt;
			$title = $entity->title;
			$owner = $entity->getOwnerEntity();
			
			$is_group = $entity->getContainerEntity();
		if ($is_group instanceof ElggGroup) {
			return elgg_echo('group_blog:notification', array(
				$owner->name,
				$is_group->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
				
				$owner->name,
				$is_group->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			));
		} else {
			return elgg_echo('blog:notification', array(
				$owner->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
				
				$owner->name,
				$title,
				$descr,
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
			));
		}
	}
	return null;
}

/* NEW EVENT IN CALENDAR */
function c_event_notify_message($hook,$type,$message,$params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (elgg_instanceof($entity, 'object', 'event_calendar')) {
		$grp = $entity->getContainerEntity();

		if ($grp instanceof ElggGroup) {
			return elgg_echo('group_event_calendar:c_new_event_body', array(
				$grp->name,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			
				$grp->name,
				$entity->getURL(),
				elgg_get_site_url().'notifications/personal/',
			));
		} else {
			return elgg_echo('event_calendar:c_new_event_body', array(
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
			
				$entity->getURL(),
				elgg_get_site_url().'notifications/group/',
			));
		}
	}
	return null;
}

// function c_html_email_handler_notification_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL){
		
// 		if (!$from) {
// 			$msg = elgg_echo("NotificationException:MissingParameter", array("from"));
// 			throw new NotificationException($msg);
// 		}

// 		if (!$to) {
// 			$msg = elgg_echo("NotificationException:MissingParameter", array("to"));
// 			throw new NotificationException($msg);
// 		}

// 		if ($to->email == "") {
// 			$msg = elgg_echo("NotificationException:NoEmailAddress", array($to->guid));
// 			throw new NotificationException($msg);
// 		}

// 		// To
// 		$to = html_email_handler_make_rfc822_address($to);

// 		// From
// 		$site = elgg_get_site_entity();
// 		// If there's an email address, use it - but only if its not from a user.
// 		if (!($from instanceof ElggUser) && !empty($from->email)) {
// 		    $from = html_email_handler_make_rfc822_address($from);
// 		} elseif (!empty($site->email)) {
// 		    // Use email address of current site if we cannot use sender's email
// 		    $from = html_email_handler_make_rfc822_address($site);
// 		} else {
// 			// If all else fails, use the domain of the site.
// 			if(!empty($site->name)){
// 				$name = $site->name;
// 				if (strstr($name, ',')) {
// 					$name = '"' . $name . '"'; // Protect the name with quotations if it contains a comma
// 				}
				
// 				$name = '=?UTF-8?B?' . base64_encode($name) . '?='; // Encode the name. If may content nos ASCII chars.
// 				$from = $name . " <noreply@" . get_site_domain($site->getGUID()) . ">";
// 			} else {
// 				$from = "noreply@" . get_site_domain($site->getGUID());
// 			}
// 		}
		
// 		// generate HTML mail body
// 		$html_message = c_html_email_handler_make_html_body($subject, $message);
	
// 		// set options for sending
// 		$options = array(
// 			"to" => $to,
// 			"from" => $from,
// 			"subject" => '=?UTF-8?B?' . base64_encode($subject) . '?=',
// 			"html_message" => $html_message,
// 			"plaintext_message" => $message
// 		);
		
// 		if(!empty($params) && is_array($params)){
// 			$options = array_merge($options, $params);
// 		}
		
// 		return html_email_handler_send_email($options);
// 	}
	
	
/* MENTIONING A USER ON THE WIRE */
function c_thewire_tools_create_object_event_handler($event, $type, $object) {
	if (elgg_instanceof($object, "object", "thewire")) {
		//send out notification to users mentioned in a wire post
		$usernames = array();
		
		if (preg_match_all("/\@([A-Za-z0-9\_\.\-]+)/i", $object->description, $usernames)) {
			$usernames = array_unique($usernames[0]);
			
			foreach ($usernames as $username) {
				$username = str_ireplace("@", "", $username);
				$user = get_user_by_username($username);
				
				if (!empty($user) && ($user->getGUID() != $object->getOwnerGUID())) {
					$user_setting = elgg_get_plugin_user_setting("notify_mention", $user->getGUID(), "thewire_tools");
					
					if ($user_setting === "yes") {
						$subject = elgg_echo("thewire_tools:notify:mention:subject");
						$message = elgg_echo("thewire_tools:notify:mention:message", array(
							$user->name,
							$object->getOwnerEntity()->name,
							elgg_get_site_url()."thewire/search/@".$user->username,
							elgg_get_site_url().'notifications/personal/',
							
							$user->name,
							$object->getOwnerEntity()->name,
							elgg_get_site_url()."thewire/search/@".$user->username,
							elgg_get_site_url().'notifications/personal/',
						));
						notify_user($user->getGUID(), $object->getOwner(), $subject, $message);
					}
				}
			}
		}
	}
}


	
/* ADDING A MESSAGE ON THE MESSAGE BOARD */
function c_messageboard_add($poster, $owner, $message, $access_id = ACCESS_PUBLIC) {
	$result = $owner->annotate('messageboard', $message, $access_id, $poster->guid);

	if (!$result) {
		return false;
	}

	add_to_river('river/object/messageboard/create',
				'messageboard',
				$poster->guid,
				$owner->guid,
				$access_id,
				0,
				$result);

	// only send notification if not self
	if ($poster->guid != $owner->guid) {
		$subject = elgg_echo('messageboard:email:subject');
		$body = elgg_echo('c_messageboard:email:body', array(
						$poster->name,
						$message,
						elgg_get_site_url() . "messageboard/" . $owner->username,
						$poster->name,
						$poster->getURL(),
						elgg_get_site_url().'notifications/personal/',
						
						$poster->name,
						$message,
						elgg_get_site_url() . "messageboard/" . $owner->username,
						$poster->name,
						$poster->getURL(),
						elgg_get_site_url().'notifications/personal/',
					));
		notify_user($owner->guid, $poster->guid, $subject, $body);
	}
	return $result;
}

	
/**
 * Hook to handle emails send by elgg_send_email
 * 
 * @param string $hook
 * @param string $type
 * @param bool $return
 * @param array $params
 * 		to 		=> who to send the email to
 * 		from 	=> who is the sender
 * 		subject => subject of the message
 * 		body 	=> message
 * 		params 	=> optional params
 */
function c_html_email_handler_email_hook($hook, $type, $return, $params){
	// generate HTML mail body
	$html_message = c_html_email_handler_make_html_body($params["subject"], $params["body"]);
	
	// set options for sending
	$options = array(
		"to" => $params["to"],
		"from" => $params["from"],
		"subject" => $params["subject"],
		"html_message" => $html_message,
		"plaintext_message" => $params["body"]
	);
	return html_email_handler_send_email($options);
}



/* PHOTO & ALBUM UPLOAD */
function c_tidypics_notify_message($hook, $type, $notification, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (elgg_instanceof($entity, 'object', 'album')) {
		//$descr = $entity->description;
		$title = $entity->getTitle();
		//$user = elgg_get_logged_in_user_entity();
		$user = $entity->getOwnerEntity();
		$group = $entity->getContainerEntity();
	
		if ($entity->getSize() <= 0) {
		
			if ($group instanceof ElggGroup) {
				return elgg_echo('group_tidypics:notify:body_newalbum', array(
					$user->name,
					$group->name,
					$title,
					$entity->getURL(),
					elgg_get_site_url().'notifications/personal/',
					
					$user->name,
					$group->name,
					$entity->getTitle(),
					$entity->getURL(),
					elgg_get_site_url().'notifications/personal/',
				));
			} else {
				return elgg_echo('tidypics:notify:body_newalbum', array(
					$user->name,
					$title,
					$entity->getURL(),
					elgg_get_site_url().'notifications/group/',
					
					$user->name,
					$entity->getTitle(),
					$entity->getURL(),
					elgg_get_site_url().'notifications/group/',
				));
			}
		} else {

			if (!$user) {
					$user = $entity->getOwnerEntity();
			}
			
			if ($group instanceof ElggGroup) {
				return elgg_echo('group_tidypics:updatealbum', array(
					$user->name,
					$title,
					$group->name,
					$entity->getURL(),
					elgg_get_site_url().'notifications/group/',	
					
					$user->name,
					$title,
					$group->name,
					$entity->getURL(),
					elgg_get_site_url().'notifications/group/',	
				));
			} else {
				return elgg_echo('tidypics:updatealbum', array(
					$user->name,
					$title,
					$entity->getURL(),
					elgg_get_site_url().'notifications/personal/',
					
					$user->name,
					$title,
					$entity->getURL(),
					elgg_get_site_url().'notifications/personal/',
				));
			}
		}
	}
	return null;
}



/* MEMBERSHIP REQUESTS FOR CLOSED GROUPS */
function c_group_tools_membership_request($event, $type, $relationship) {
	if (!($relationship instanceof ElggRelationship)) {
		return;
	}
	
	$group = get_entity($relationship->guid_two);
	$user = get_user($relationship->guid_one);
	
	if (!elgg_instanceof($group, 'group') || !elgg_instanceof($user, 'user')) {
		return;
	}
	
	// only send a message if group admins are allowed
	if (elgg_get_plugin_setting("multiple_admin", "group_tools") != "yes") {
		return;
	}
	
	// Notify group admins
	$options = array(
		"relationship" => "group_admin",
		"relationship_guid" => $group->getGUID(),
		"inverse_relationship" => true,
		"type" => "user",
		"limit" => false,
		"wheres" => array("e.guid <> " . $group->owner_guid),
		"callback" => false
	);
	
	$admins = elgg_get_entities_from_relationship($options);
	if (!empty($admins)) {
		$url = elgg_get_site_url()."groups/requests/" . $group->getGUID();
		$subject = elgg_echo("c_groups:request:subject", array(
			$user->name,
			$group->name,
			
			$user->name,
			$group->name,
		));
		
		foreach ($admins as $a) { 
			$user_gadmin = get_entity($a->guid);
			$body = elgg_echo("c_groups:request:body", array(
				$user_gadmin->name,	// cyu - the name element does not exist within the stdClass array
				$user->name,
				$group->name,
				$user->getURL(),
				$url,
				
				$a->name,
				$user->name,
				$group->name,
				$user->getURL(),
				$url,
			));
			//notify_user($a->getGUID(), $user->guid, $subject, $body);	// cyu - FATAL ERROR: stdClass::getGUID does not exist (see below for fix:)
			notify_user($a->guid, $user->guid, $subject, $body);
		}
	}
}
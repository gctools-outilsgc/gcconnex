<?php

elgg_register_event_handler('init','system','cp_notifications_init');

function cp_notifications_init() {

	elgg_register_css('cp_notifications-css','mod/cp_notifications/css/notifications-table.css');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'notify_entity_menu_setup', 400);

	$actions_base = elgg_get_plugins_path() . 'cp_notifications/actions/cp_notifications';
	elgg_register_action('cp_notify/subscribe', "$actions_base/subscribe.php");
	elgg_register_action('cp_notify/unsubscribe', "$actions_base/unsubscribe.php");
	elgg_register_action('user/requestnewpassword', "$actions_base/request_new_password.php", 'public');

	elgg_register_plugin_hook_handler('email', 'system', 'cpn_email_handler_hook');	// intercepts and blocks emails and notifications to be sent out
	elgg_register_event_handler('create','object','cp_create_notification');	// send notifications when the action is sent out
	elgg_register_event_handler('create','annotation','cp_create_annotation_notification');	// likes notification

	elgg_register_action('groups/email_invitation', "$actions_base/manual_send.php");

	elgg_register_event_handler('create', 'membership_request', 'cp_membership_request');
	//if (elgg_is_active_plugin('group_tools'))
		//elgg_register_event_handler('group_tools/invite_members', 'group', 'cp_group_join_notification');

	if (elgg_is_active_plugin('mentions')) {	// we need to check if the mention plugin is installed and activated because it does notifications differently...
		elgg_unregister_event_handler('create', 'object','mentions_notification_handler');
		elgg_unregister_event_handler('update', 'annotation','mentions_notification_handler');
	}

	if (elgg_is_active_plugin('thewire_tools'))
		elgg_unregister_event_handler('create', 'object', 'thewire_tools_create_object_event_handler');

	// since most of the notifications are built within the action file itself, the trigger_plugin_hook was added to respected plugins
	elgg_register_plugin_hook_handler('cp_overwrite_notification', 'all', 'cp_overwrite_notification_hook');

	elgg_unregister_action('useradd'); 
	elgg_register_action('useradd',"$actions_base/useradd.php",'admin'); // actions/useradd.php (core file)

    elgg_extend_view("js/elgg", "js/notification");//add some notification js 

    // remove core notification settings portion of the main settings page
    elgg_unextend_view('forms/account/settings', 'core/settings/account/notifications');

}



// these notifications cannot be set from the settings page for the user, MUST be sent out
function cp_overwrite_notification_hook($hook, $type, $value, $params) {
	
	$cp_msg_type = trim($params['cp_msg_type']);
	error_log("=== cp_overwrite_notification_hook === msg-type: {$cp_msg_type}");
	$subject = "";
	$to_recipients = array();
	$email_only = false;	// some notifications require only sending off emails
	$add_to_sent = false;	// messages should only be saved in a user's sent messages box if it's an actual message they sent (as opposed to an automated notification they triggered)
	$senderGUID = elgg_get_site_entity()->guid;		// By default, the sender for notifications is the site

	switch($cp_msg_type) {

		case 'cp_grp_admin_transfer':
		error_log("hey hey hey hey hey");
			$message = array();
			$subject = elgg_echo();
			$subject .= ' | '.elgg_echo();
			$to_recipients[] = $params['cp_new_owner_user'];
			break;


		case 'cp_wire_mention': // thewire_tools/lib/events.php
			$message = array(
				'cp_mention_by' => $params['cp_mention_by'],
				'cp_view_mention' => $params['cp_view_your_mention'],
				'cp_msg_type' => $cp_msg_type,
			);
			$subject = elgg_echo('cp_notify:subject:wire_mention',array(),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:wire_mention',array(),'fr');
			$to_recipients[] = $params['cp_send_to'];
			break;


		case 'cp_useradd': // cp_notifications/actions/useradd.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_user_name' => $params['cp_user_name'],
				'cp_site_name' => $params['cp_site_name'],
				'cp_site_url' => $params['cp_site_url'],
				'cp_username' => $params['cp_username'],
				'cp_password' => $params['cp_password'],
			);

			$to_recipients[] = $params['cp_user'];
			$email_only = true;
			$subject = elgg_echo('cp_notify:subject:add_new_user',array(),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:add_new_user',array(),'fr');
			break;


		case 'cp_friend_invite': // invitefriends/actions/invite.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_from_user' => $params['cp_from']->name, // cp_from is a user object
				'cp_to_user' => $params['cp_to'],
				'cp_join_url' => $params['cp_join_url'],
				'cp_msg' => $params['cp_email_msg'],
			);
			$email_only = true;
			$subject = elgg_echo('cp_notify:subject:invite_new_user',array(),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:invite_new_user',array(),'fr');

			$template = elgg_view('cp_notifications/email_template', $message);
			mail($params['cp_to'],$subject,$template,cp_get_headers());
			return;


		case 'cp_friend_approve': // friend_request/actions/approve
			$subject = elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'fr');
			$message = array(
				'cp_approver' => $params['cp_approver'],
				'cp_approver_profile' => $params['cp_approver_profile'],
				'cp_msg_type' => $cp_msg_type,
				);
			$to_recipients[] = get_user($params['cp_request_guid']);
			break;


		case 'cp_site_msg_type':	// messages/actions/messages/send.php
			$add_to_sent = true;	// since this is not a notification, it does need to go into the user's sent history
			$senderGUID = $params['cp_from']['guid'];		// special case: this is an actual user-to-user message, and thus should be sent from the user that sent it.
			$to_recipients[] = get_user($params['cp_to']['guid']);
			$subject = $params['cp_topic_title'];
			$message = array('cp_topic_title' => $params['cp_topic_title'],
								'cp_topic_description' => $params['cp_topic_description'],
								'cp_topic_author' => $params['cp_from']['name'],
								'cp_topic_url' => $params['cp_topic_url'],
								'cp_msg_type' => 'cp_site_msg_type',
						);
			break;


		case 'cp_group_add':	// group_tools/lib/functions.php OR groups/actions/groups/membership/add.php ????
			$to_recipients[] = $params['cp_user_added'];
			$subject = elgg_echo('cp_notify:subject:group_add_user',array($params['cp_group']['name']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:group_add_user',array($params['cp_group']['name']),'fr');
			$message = array(
				'cp_user_added' => $params['cp_user_added'],
				'cp_group' => $params['cp_group'],
				'cp_message' => $params['cp_added_msg'],
				'cp_msg_type' => $cp_msg_type
			);
			//$template = elgg_view('cp_notifications/email_template',$message);
			break;

		
		case 'cp_group_invite': // group_tools/lib/functions.php
			$subject = elgg_echo('cp_notify:subject:group_invite_user',array($params['cp_inviter']['name'],$params['cp_invite_to_group']['name']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:group_invite_user',array($params['cp_inviter']['name'],$params['cp_invite_to_group']['name']),'fr');
			$message = array(
				'cp_group_invite_from' => $params['cp_invitee'], // user we're inviting
				'cp_group_invite_to' => $params['cp_inviter'], // user inviting others
				'cp_group' => $params['cp_invite_to_group'],
				'cp_invitation_url' => $params['cp_invitation_url'],
				'cp_invitation_msg' => $params['cp_invite_msg'],
				'cp_msg_type' => $cp_msg_type
			);
			$to_recipients[] = get_user($params['cp_invitee']['guid']);
			break;


		case 'cp_group_invite_email': // group_tools/lib/functions.php (returns user's email, so return after mail is sent out)
			$subject = elgg_echo('cp_notify:subject:group_invite_email',array($params['cp_inviter']['name'],$params['cp_group_invite']['name']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:group_invite_email',array($params['cp_inviter']['name'],$params['cp_group_invite']['name']),'fr');
			$message = array(
				'cp_email_invited' => $params['cp_invitee'],
				'cp_email_invited_by' => $params['cp_inviter'],
				'cp_group_invite' => $params['cp_group_invite'],
				'cp_invitation_non_user_url' => $params['cp_invitation_nonuser_url'],
				'cp_invitation_url' => $params['cp_invitation_url'],
				'cp_invitation_code' => $params['cp_invitation_code'],
				'cp_invitation_msg' => $params['cp_invitation_msg'],
				'cp_msg_type' => $cp_msg_type
			);
			$template = elgg_view('cp_notifications/email_template', $message);
			mail($params['cp_invitee'],$subject,$template,cp_get_headers());
			return true;


		case 'cp_group_mail': // group_tools/actions/mail.php
			$message = array(
				'cp_group' => $params['cp_group'],
				'cp_group_subject' => $params['cp_group_subject'],
				'cp_group_message' => $params['cp_group_message'],
				'cp_group_user' => $params['cp_group_mail_users'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:group_mail',array($params['cp_group']['name'],$params['cp_group_subject']),'en');
            $subject .= ' | '.elgg_echo('cp_notify:subject:group_mail',array($params['cp_group']['name'],$params['cp_group_subject']),'fr');
			foreach ($params['cp_group_mail_users'] as $to_user)
				$to_recipients[] = get_user($to_user);
			break;


		case 'cp_friend_request':
			$message = array(
				'cp_friend_request_from' => $params['cp_friend_requester'],
				'cp_friend_request_to' => $params['cp_friend_receiver'],
				'cp_friend_invitation_url' => $params['cp_friend_invite_url'],
				'cp_msg_type' => $cp_msg_type
			);
			$from_user = $params['cp_friend_requester'];
			$to_user = $params['cp_friend_receiver'];
			$subject = elgg_echo('cp_notify:subject:friend_request',array($from_user['name']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:friend_request',array($from_user['name']),'fr');
			$to_recipients[] = get_user($to_user['guid']);
			break;


		case 'cp_forgot_password': // send email notifications only - /wet4/users/action/password
			cp_send_new_password_request($params['cp_user_pass_req_guid']);
			return true; // this is the only special case that will need to end early in function


		case 'cp_validate_user': // uservalidationbyemail/lib/functions.php
			$message = array(
				'cp_validate_user' => $params['cp_validate_user'],
				'cp_validate_url' => $params['cp_validate_url'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:validate_user',array($params['cp_validate_user']['email']),'en');
            $subject .= ' | '. elgg_echo('cp_notify:subject:validate_user',array($params['cp_validate_user']['email']),'fr');
			$to_recipients[] = get_user($params['cp_validate_user']['guid']);
			$email_only = true;
			break;


		case 'cp_hjtopic': // gcforums/actions/gcforums/create.php
			$message = array(
				'cp_hjtopic_author' => $params['cp_topic_author'],
				'cp_hjtopic_title' => $params['cp_topic_title'],
				'cp_hjtopic_description' => $params['cp_topic_description'],
				'cp_hjtopic_url' => $params['cp_topic_url'],
				'cp_msg_type' => $cp_msg_type
				);
			$t_user = $params['cp_subscribers'];
			foreach ($t_user as $s_uer)
				$to_recipients[] = get_user($s_uer);
			$subject = elgg_echo('cp_notify:subject:hjtopic',array(),'en'); 
			$subject .= ' | '.elgg_echo('cp_notify:subject:hjtopic',array(),'fr');
			break;


		case 'cp_event': // somewhere
			$message = array(
				'cp_event_request_to' => $params['cp_event_receiver'],
				'cp_topic_url' => $params['cp_event_invite_url'],
				'startdate' => $params['startdate'],
				'enddate' => $params['enddate'],
				'event' => $params['event'],
				'cp_msg_type' => $cp_msg_type
			);
			$event = $params['event'];
			$startdate = $params['startdate'];
			$enddate = $params['enddate'];
			$from_user = $params['cp_event_requester'];
			$to_user = $params['email_users'];
			$subject = $event->title;
			$type_event = $params['type_event'];
			$to_recipients[] = $params['cp_event_receiver'];



			$mime_boundary = "----Meeting Booking----".MD5(TIME());
			$template .= "--$mime_boundary\r\n";
			$template .= "Content-Type: text/html; charset=UTF-8\n";
			$template .= elgg_view('cp_notifications/email_template', $message);
			$template .= "--$mime_boundary\r\n";

			if (!$enddate) {
				$enddate = date('j M Y g:i A', strtotime($startdate)+86340);
				$oneday = true;
			} else {
				$oneday=false;
			}

		    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
		    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
		    'METHOD:'.$type_event. "\r\n" .
		    'VERSION:2.0' . "\r\n" .
		    'BEGIN:VTIMEZONE' . "\r\n" .
		    'TZID:Eastern Time' . "\r\n" .
		    'BEGIN:STANDARD' . "\r\n" .
		    'DTSTART:20091101T020000' . "\r\n" .
		    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
		    'TZOFFSETFROM:-0400' . "\r\n" .
		    'TZOFFSETTO:-0500' . "\r\n" .
		    'TZNAME:EST' . "\r\n" .
		    'END:STANDARD' . "\r\n" .
		    'BEGIN:DAYLIGHT' . "\r\n" .
		    'DTSTART:20090301T020000' . "\r\n" .
		    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
		    'TZOFFSETFROM:-0500' . "\r\n" .
		    'TZOFFSETTO:-0400' . "\r\n" .
		    'TZNAME:EDST' . "\r\n" .
		    'END:DAYLIGHT' . "\r\n" .
		    'END:VTIMEZONE' . "\r\n" .	
		    'BEGIN:VEVENT' . "\r\n" .
		    /*'ORGANIZER;CN="steph4104":MAILTO:stephanie.lefebvre@tbs-sct.gc.ca'."\r\n" .
		    'ATTENDEE;CN="'.get_loggedin_user()->username.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:stephanie.lefebvre@tbs-sct.gc.ca'. "\r\n" .*/
		    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
		    'UID:'.$event->guid . "\r\n" .
		    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
		    'DTSTART;TZID="Eastern Time":'.date("Ymd\THis", strtotime($startdate)). "\r\n" .
		    'DTEND;TZID="Eastern Time":'.date("Ymd\THis", strtotime($enddate)). "\r\n" .
		    'TRANSP:OPAQUE'. "\r\n" .
		    'SEQUENCE:1'. "\r\n" .
		    'SUMMARY:'.$event->title."\r\n" .
		    'LOCATION:'.$event->venue. "\r\n" .
		    'CLASS:PUBLIC'. "\r\n" .
		    'PRIORITY:5'. "\r\n" .
		    'BEGIN:VALARM' . "\r\n" .
		    'TRIGGER:-PT15M' . "\r\n" .
		    'ACTION:DISPLAY' . "\r\n" .
		    'DESCRIPTION:Reminder' . "\r\n" .
		    'END:VALARM' . "\r\n" .
		    'END:VEVENT'. "\r\n" .
		    'END:VCALENDAR'. "\r\n";
		    'STATUS:CONFIRMED'. "\r\n";
		   
		    $template .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
		    $template .= "Content-Transfer-Encoding: 8bit\n\n";
		    $template .= $ical;
		    $event = 'event';
			break;


		case 'cp_hjpost': // gcforums/actions/gcforums/create.php
			$message = array(
				'cp_hjpost_author' => $params['cp_topic_author'],
				'cp_hjpost_title' => $params['cp_topic_title'],
				'cp_hjpost_description' => $params['cp_topic_description'],
				'cp_hjpost_url' => $params['cp_topic_url'],
				'cp_msg_type' => $cp_msg_type
				);
			$t_user = $params['cp_subscribers'];
			foreach ($t_user as $s_uer)
				$to_recipients[] = get_user($s_uer);
			$subject = elgg_echo('cp_notify:subject:hjpost',array(),'en'); 
			$subject .= ' | '.elgg_echo('cp_notify:subject:hjpost',array(),'fr');
			break;


		default:
			break;
	} 

	$template .= elgg_view('cp_notifications/email_template', $message);
	foreach ($to_recipients as $to_recipient) {
				
		if ($to_recipient->guid != elgg_get_logged_in_user_guid()) { 

			if ($cp_msg_type == 'cp_event') { // for now
				mail($to_recipient,$subject,$template,cp_get_headers($event)); // be careful of this line, event may be null
			} else {
				mail($to_recipient->email,$subject,$template,cp_get_headers($event)); // be careful of this line, event may be null
			}
			error_log('/ ----> '.$to_recipient->email);
			if (!$email_only)
				messages_send($subject, $template, $to_recipient->guid, $senderGUID, 0, true, $add_to_sent);
		} // end if
	} // end foreach loop
} // end function







function cp_create_annotation_notification($event, $type, $object) {
	$subject = "";
	$site = elgg_get_site_entity();

	$do_not_subscribe_list = array('blog_revision','discussion_reply','task','vote','folder');	// we dont need to be notified so many times
	if (in_array($object->getSubtype(), $do_not_subscribe_list))
		return $return;

	$object_subtype = $object->getSubtype();
	$liked_content = get_entity($object->entity_guid);
	$type_of_like = $liked_content->getSubtype();

	if ($object_subtype === 'likes') {
	
	    switch ($type_of_like) {

	    	case 'comment':
	    		$commented_to_entity = get_entity($object->entity_guid); // get the comment object
	    		$comment_author = get_user($commented_to_entity->owner_guid); // get the user who made the comment

	    		$content = get_entity($commented_to_entity->getContainerGUID()); // get the location of comment
	    		$content_title = $content->title; // get title of content

	    		$liked_by = get_user($object->owner_guid); // get user who liked comment

	    		$subject = elgg_echo('cp_notify:subject:likes_comment', array($liked_by->name,$content_title),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_comment',array($liked_by->name,$content_title),'fr');

	    		$message = array(
	    			'cp_liked_by' => $liked_by->name,
	    			'cp_comment_from' => $content_title,
					'cp_msg_type' => 'cp_likes_comments',
				);

				$to_recipients[$comment_author->getGUID()] = get_user($comment_author->getGUID());
	    		break;
	    	

	    	case 'discussion_reply':
	    		$commented_to_entity = get_entity($object->entity_guid); // get the comment object
	    		$comment_author = get_user($commented_to_entity->owner_guid); // get the user who made the comment

	    		$content = get_entity($commented_to_entity->getContainerGUID()); // get the location of comment
	    		$content_title = $content->title; // get title of content

	    		$liked_by = get_user($object->owner_guid); // get user who liked comment

	    		$subject = elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name,$content_title),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name,$content_title),'fr');

				$message = array(
					'cp_liked_by' => $liked_by->name,
					'cp_comment_from' => $content_title,
					'cp_msg_type' => 'cp_likes_topic_replies',
				);

				$to_recipients[$comment_author->getGUID()] = get_user($comment_author->getGUID());
	    		break;


	    	default:
		    	if ($liked_content instanceof ElggUser) {
		    		$liked_by = get_user($object->owner_guid); // get user who liked comment

		    		$subject = elgg_echo('cp_notify:subject:likes_user_update',array($liked_by->name),'en');
		    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_user_update',array($liked_by->name),'fr');

		    		$message = array(
						'cp_msg_type' => 'cp_likes_user_update',
						'cp_liked_by' => $liked_by->name
					);

	    			$to_recipients[$liked_content->guid] = $liked_content;

		    	} else {

		    		$liked_by = get_user($object->owner_guid); // get user who liked content
		    		$content = get_entity($object->entity_guid);
		    		$content_author = get_user($content->owner_guid);

		    		// cyu - patching issue #323 (liking wire post)
		    		if ($content->getSubtype() === 'thewire') {
		    			$subject = elgg_echo('cp_notify:subject:likes_wire',array($liked_by->name,$content->title),'en');
		    			$subject .= ' | '.elgg_echo('cp_notify:subject:likes_wire',array($liked_by->name,$content->title),'fr');
		    			$content_subtype = 'thewire';
		    		} else {
		    			$subject = elgg_echo('cp_notify:subject:likes',array($liked_by->name,$content->title),'en');
		    			$subject .= ' | '.elgg_echo('cp_notify:subject:likes',array($liked_by->name,$content->title),'fr');
		    			$content_subtype = '';
		    		}

		    		$message = array(
		    			'cp_subtype' => $content_subtype,
						'cp_msg_type' => 'cp_likes_type',
						'cp_liked_by' => $liked_by->name,
						'cp_comment_from' => $content->title,
						'cp_content_url' => $content->getURL(),
					);

	    			$to_recipients[$content_author->guid] = $content_author;
		    	}
	    		break;

		} // end switch
	} // end if

	$template = elgg_view('cp_notifications/email_template', $message); // pass in the information into the template to prepare the notification

	foreach ($to_recipients as $to_recipient) {
		if ($to_recipient->guid != elgg_get_logged_in_user_guid()) { // make sure we don't send a notification to user who did the action

			if (elgg_get_plugin_user_setting("cpn_likes_email", $to_recipient->getGUID(), 'cp_notifications') === 'likes_email') // make sure user wants to receive the email
				mail($to_recipient->email,$subject,$template,cp_get_headers());
		
			if (elgg_is_active_plugin('messages') && elgg_get_plugin_user_setting("cpn_likes_site", $to_recipient->getGUID(), 'cp_notifications') === 'likes_site')
				messages_send($subject, $template, $to_recipient->guid, $site->guid, 0, true, false);

		}
	}
} // end of function






function cp_create_notification($event, $type, $object) {
	error_log("=== cp_create_notification === msg-type: {$object->getSubtype()}");
	$subject = "";
	$do_not_subscribe_list = array('poll_choice','blog_revision','widget','folder');
	if (in_array($object->getSubtype(), $do_not_subscribe_list))
		return $return;

	$site = elgg_get_site_entity();
	$to_recipients = array();

	switch ($object->getSubtype()) {
		case 'discussion_reply':
		case 'comment':	// when someone makes a comment in an entity
			if (elgg_is_active_plugin('mentions') && $object->getSubtype() !== 'messages') // if mentions plugin is enabled... check to see if there were any mentions
				$cp_mentioned_users = cp_scan_mentions($object);

			$container_entity = get_entity($object->getContainerGUID());	// get topic that the comment resides in

			// Users subscribed to recieve notifications by email
			$options = array(
				'relationship' => 'cp_subscribed_to_email',
				'relationship_guid' => $container_entity->getGUID(),
				'inverse_relationship' => true,
				'limit' => 0	// no limit
			);
			
			// prepare all the emails that needs to be sent
			$users = elgg_get_entities_from_relationship($options);
			
			foreach ($users as $user) 
				$to_recipients_email[$user->guid] = $user;
			
		
			$to_recipients_email[$container_entity->owner_guid] = get_user($container_entity->owner_guid);
			
			// Users subscribed to recieve notifications by site message
			$options = array(
				'relationship' => 'cp_subscribed_to_site_mail',
				'relationship_guid' => $container_entity->getGUID(),
				'inverse_relationship' => true,
				'limit' => 0	// no limit
			);
			
			// prepare all the emails that needs to be sent
			$users = elgg_get_entities_from_relationship($options);
			
			foreach ($users as $user) 
				$to_recipients_message[$user->guid] = $user;
		
			
			$reply_author = get_user($object->owner_guid);
			
			$subject = elgg_echo('cp_notify:subject:comments',array($reply_author->name,$container_entity->title),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:comments',array($reply_author->name,$container_entity->title),'fr');

			$message = array('cp_topic_title' => $container_entity->title, 
								'cp_topic_author' => $container_entity->owner_guid, 
								'cp_topic_description' => $container_entity->description, 
								'cp_comment_author' => $object->owner_guid, 
								'cp_comment_description' => $object->description,
								'cp_topic_url' => $container_entity->getURL(),
								'cp_msg_type' => 'cp_reply_type',
						);

			// notify user when something happens (comment) on their content (only for the content owner case)
			$content_owner = get_user($container_entity->owner_guid);
			$template = elgg_view('cp_notifications/email_template', $message);
			if (elgg_get_plugin_user_setting("cpn_content_email", $container_entity->owner_guid, 'cp_notifications') === 'content_email')
				mail($content_owner->email,$subject,$template,cp_get_headers());

			if (elgg_get_plugin_user_setting("cpn_content_site", $container_entity->owner_guid, 'cp_notifications') === 'content_site')
				messages_send($subject, $template, $content_owner->getGUID(), $site->guid, 0, true, false);	

			break;

		default:	// creating entities such as blogs, topics, bookmarks, etc...

			// the user creating the content is automatically subscribed to it
			add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $object->getGUID());
			add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $object->getGUID());

			if (elgg_is_active_plugin('mentions') && $object->getSubtype() !== 'messages') // check to see if there were any mentions
				$cp_mentioned_users = cp_scan_mentions($object);

			if ($object->getContainerEntity() instanceof ElggGroup) {
				// Users subscribed to recieve notifications by email
				$options = array(
					'relationship' => 'cp_subscribed_to_email',
					'relationship_guid' => $object->getContainerGUID(),
					'inverse_relationship' => true,
					'limit' => 0
				);

				$users = elgg_get_entities_from_relationship($options);


				foreach ($users as $user)
					$to_recipients_email[$user->guid] = $user;

				// Users subscribed to recieve notifications by site message
				$options = array(
					'relationship' => 'cp_subscribed_to_site_mail',
					'relationship_guid' => $object->getContainerGUID(),
					'inverse_relationship' => true,
					'limit' => 0	// no limit
				);

				$users = elgg_get_entities_from_relationship($options);
				foreach ($users as $user)
					$to_recipients_message[$user->guid] = $user;
			}


			//*** users subscribed to this user ***//
			// by email
				$options_usr = array(
					'relationship' => 'cp_subscribed_to_email',
					'relationship_guid' => $object->owner_guid,
					'types' => 'user',
					'inverse_relationship' => false,
					'limit' => 0,
				);

			// users subscribed to this user
			$user_subscribers = elgg_get_entities_from_relationship($options_usr);
		
			foreach ($user_subscribers as $user)
				$to_recipients_email[$user->guid] = $user;

			// site message
				$options_usr = array(
					'relationship' => 'cp_subscribed_to_site_mail',
					'relationship_guid' => $object->owner_guid,
					'types' => 'user',
					'inverse_relationship' => false,
					'limit' => 0,
				);

			// users subscribed to this user
			$user_subscribers = elgg_get_entities_from_relationship($options_usr);
		
			foreach ($user_subscribers as $user)
				$to_recipients_message[$user->guid] = $user;

			
			//*** END of users subscribed to this user code ***//

			$user = get_user($object->owner_guid);

			// fem and mas are different (so the subject should be reflected on which subtype is passed)
			$subtypes_gender_subject = array(
				'blog' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un blogue",$object->title),'fr'),
				'bookmarks' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un signet",$object->title),'fr'),
				'file' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un fichier",$object->title),'fr'),
				'poll' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un sondage",$object->title),'fr'),
				'event_calendar' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un nouvel événement",$object->title),'fr'),
				'album' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un album d'image",$object->title),'fr'),
				'groupforumtopic' => elgg_echo('cp_notify:subject:new_content_fem',array($user->name,"une discussion",$object->title),'fr'),
				'image' => elgg_echo('cp_notify:subject:new_content_fem',array($user->name,"une image",$object->title),'fr'),
				'idea' => elgg_echo('cp_notify:subject:new_content_fem',array($user->name,"une idée",$object->title),'fr'),
				'page' => elgg_echo('cp_notify:subject:new_content_fem',array($user->name,"une page",$object->title),'fr'),
				'page_top' => elgg_echo('cp_notify:subject:new_content_fem',array($user->name,"une page",$object->title),'fr'),
				//'folder' => elgg_echo('cp_notify:subject:new_content_mas',array($user->name,"un dossier",$object->title),'fr'),
			);

			$subject = elgg_echo('cp_notify:subject:new_content',array($user->name,cp_translate_subtype($object->getSubtype()),$object->title),'en');
			$subject .= ' | '.$subtypes_gender_subject[$object->getSubtype()];
			//if (!$object->title)
			//	$object1 = get_entity(844);
			//error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> {$object->getGUID()} // ".$object1->title.' /// type: '.gettype($object->getGUID()));
			$message = array('cp_topic_title' => $object->title, 
								'cp_topic_author' => $object->owner_guid, 
								'cp_topic_description' => $object->description, 
								'cp_topic_url' => $object->getURL(),
								'cp_msg_type' => 'cp_new_type',
						);		
			break;
	}

	$template = elgg_view('cp_notifications/email_template', $message); // pass in the information into the template to prepare the notification
	
    if ($cp_mentioned_users) { // if there are users who are mentioned, send out notifications
		foreach ($cp_mentioned_users as $cp_mentioned_user) {
			$user_mentioned = preg_replace('/[^A-Za-z1-9\.\-]/','',$cp_mentioned_user);	// there will always be that extra special character to remove
			$user_mentioned = get_user_by_username($user_mentioned);	// get the user entity through username

			$user_mentioner = $object->getOwnerGUID();
			$user_mentioner = get_user($user_mentioner);

			$subject_mention = elgg_echo('cp_notify:subject:mention',array($user_mentioner->name));
			$subject_mention .= ' | '.elgg_echo('cp_notify:subject:mention',array($user_mentioner->name));

			$message_mention = array('cp_topic_title' => $object->getContainerEntity()->title,
			                       'cp_topic_author' => $object->owner_guid,
			                       'cp_topic_description' => $object->description,
			                       'cp_topic_url' => $object->getURL(),
			                       'cp_msg_type' => 'cp_mention_type'
			       );

			$template_mention = elgg_view('cp_notifications/email_template', $message_mention);


			if (elgg_get_plugin_user_setting("cpn_mentions_email", $user->guid, 'cp_notifications') === 'mentions_email')	// check if user enabled notification for mentions (email notifications)
				mail($user_mentioned->email,$subject_mention,$template,cp_get_headers());
		
			if (elgg_get_plugin_user_setting("cpn_mentions_site", $user->guid, 'cp_notifications') === 'mentions_site') // check if user wants notifications for mentions (site messages)
				messages_send($subject_mention, $template, $user_mentioned->getGUID(), $site->guid, 0, true, false);		
		}
    }


    // send out emails
	foreach ($to_recipients_email as $to_recipient) { 
		if ($to_recipient->getGUID() != elgg_get_logged_in_user_guid()) { // prevents notification to be sent to the sender
			if ($to_recipient instanceof ElggUser)
				mail($to_recipient->email,$subject,$template,cp_get_headers());
		}
	} 


	// send out site messages
	foreach ($to_recipients_message as $to_recipient) { 
		if ($to_recipient->getGUID() != elgg_get_logged_in_user_guid()) { // prevents notification to be sent to the sender
			if ($to_recipient instanceof ElggUser)
				messages_send($subject, $template, $to_recipient->getGUID(), $site->guid, 0, true, false);
		}
	}

	return true;
} // end of function




// this is a mirror image of the core function: /engine/classes/Elgg/PasswordService.php
function cp_send_new_password_request($user_guid) {

	$user_guid = (int)$user_guid;

	$user = _elgg_services()->entityTable->get($user_guid);
	if (!$user instanceof ElggUser)
		return false;

	// generate code
	$code = generate_random_cleartext_password();
	$user->setPrivateSetting('passwd_conf_code', $code);
	$user->setPrivateSetting('passwd_conf_time', time());

	// generate link
	$link = _elgg_services()->config->getSiteUrl() . "changepassword?u=$user_guid&c=$code";

	// generate email
	$ip_address = _elgg_services()->request->getClientIp();
	$message = array(
		'cp_password_request_user' => $user->username,
		'cp_password_request_ip' => $ip_address,
		'cp_password_request_url' => $link,
		'cp_msg_type' => 'cp_forgot_password',
	);

	$subject = elgg_echo('cp_notify:subject:forgot_password', array(), "en");
	$subject .= ' | '.elgg_echo('cp_notify:subject:forgot_password', array(), "fr");
	$template = elgg_view('cp_notifications/email_template', $message);
	mail($user->email,$subject,$template,cp_get_headers());

}


function cp_get_headers($event) { // $event will be null if nothing is passed into it (no default value set)
	// reply should always be from admin.GCconnex@tbs-sct.gc.ca (TODO: make setting in admin page)
	$headers = 'From: GCconnex <admin.gcconnex@tbs-sct.gc.ca>' . "\r\n";
	$headers .= 'Reply-To: GCconnex <admin.gcconnex@tbs-sct.gc.ca>' . "\r\n";
	$headers .= 'Return-Path: GCconnex <admin.gcconnex@tbs-sct.gc.ca>' . "\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	if ($event === 'event') {
		$mime_boundary = "----Meeting Booking----".MD5(TIME());
		$headers .= 'Content-Type: multipart/alternative; boundary='.$mime_boundary."\r\n";
	}
    //$headers .= 'Content-class: urn:content-classes:calendarmessage'."\r\n";
	//$headers .='Content-Disposition: inline; filename=calendar.ics'."\r\n";
	return $headers;
}


// membership only notification
function cp_membership_request($event, $type, $object) { // MUST always be sending notification

	$request_user = get_user($object->guid_one); // user who sends request to join
	$group_request = get_entity($object->guid_two);	// group that is being requested

	$message = array(
					'cp_group_req_user' => $request_user,
					'cp_group_req_group' => $group_request,
					'cp_msg_type' => 'cp_closed_grp_req_type',
				);

	$template = elgg_view('cp_notifications/email_template', $message);
	
	$subject = elgg_echo('cp_notify:subject:group_request',array($request_user->name, $group_request->name),'en');
	$subject .= ' | '.elgg_echo('cp_notify:subject:group_request',array($request_user->name, $group_request->name),'fr');
	
	$to_user = get_user($group_request->owner_guid);

	mail($to_user->email,$subject,$template,cp_get_headers());
	messages_send($subject, $template, $to_user->guid, elgg_get_site_entity()->guid, 0, true, false); // site mail
}


// scans the text object for any @mentions
function cp_scan_mentions($cp_object) {
	$fields = array('title','description','value');
	foreach($fields as $field) {
		$content = $cp_object->$field;	// pull the information from the fields saved to object
		if (preg_match_all("/\@([A-Za-z1-9]*).?([A-Za-z1-9]*)/", $content, $matches)) { // find all the string that matches: @christine.yu

			$users_found = array();
			foreach ($matches[0] as $match) {
				if (preg_match('/\s/',$match)) { // what if no space found?
					$user_found = explode(' ',$match);
					$users_found[] = $user_found[0];
				}
			}
			return $users_found;
		}
	}
	return false;
}


// intercepts all email and stops emails from sending
function cpn_email_handler_hook($hook, $type, $notification, $params) {
	return false;
}


// this is where the bell icon is implemented
function notify_entity_menu_setup($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$do_not_subscribe_list = array('comment','discussion_reply','widget');
	if (elgg_in_context('widgets') || in_array($entity->getSubtype(), $do_not_subscribe_list))
		return $return;

	// lol check for everything to put the bell thingy
	$allow_subscription = false;
	if ( $entity->getContainerEntity() instanceof ElggGroup ) {
		if ($entity->getContainerEntity()->isMember(elgg_get_logged_in_user_entity()) == 1 ) 
			$allow_subscription = true;
	
	} else if ($entity instanceof ElggGroup) {
		if ($entity->isMember(elgg_get_logged_in_user_entity()) == 1 )
			$allow_subscription = true;
	
	} else if ( $entity->getContainerEntity() instanceof ElggUser ) {
		$allow_subscription = true;
	}

	
	if ($allow_subscription && elgg_is_logged_in()) {

	    if ( check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $entity->getGUID())
	    	|| check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $entity->getGUID()) ) {

			if (elgg_is_active_plugin('wet4')) 
			 	$bell_status = '<i class="icon-unsel fa fa-lg fa-bell"></i>';
		    else
			    $bell_status = elgg_echo('cp_notify:unsubBell');
		

		    $return[] = ElggMenuItem::factory(array(
			    'name' => 'unset_notify',
			    'href' => elgg_add_action_tokens_to_url("/action/cp_notify/unsubscribe?guid={$entity->guid}"),
			    'text' => $bell_status,
			    'title' => elgg_echo('cp_notify:unsubBell'),
			    'priority' => 1000,
			    'class' => 'bell-subbed',
			    'item_class' => ''
		    ));

	    } else {

		    if (elgg_is_active_plugin('wet4'))
			   $bell_status = '<i class="icon-unsel fa fa-lg fa-bell-slash-o"></i>';
		    else
			   $bell_status = elgg_echo('cp_notify:subBell');

		    $return[] = ElggMenuItem::factory(array(
			    'name' => 'set_notify',
			    'href' => elgg_add_action_tokens_to_url("/action/cp_notify/subscribe?guid={$entity->guid}"),
			    'text' => $bell_status,
			    'title' => elgg_echo('cp_notify:subBell'),
			    'priority' => 1000,
			    'class' => '',
			    'item_class' => ''
		    ));

		}

	}
 

	return $return;
}


function cp_translate_subtype($subtype_name) {
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
			$label = 'discussion topic';
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

		default:
			$label = $subtype_name;
		break;
	}
	return $label;
}
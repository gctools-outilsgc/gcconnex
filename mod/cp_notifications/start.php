<?php

elgg_register_event_handler('init','system','cp_notifications_init');

function cp_notifications_init() {

	elgg_register_css('cp_notifications-css','mod/cp_notifications/css/notifications-table.css');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'notify_entity_menu_setup', 400);

	$actions_base = elgg_get_plugins_path() . 'cp_notifications/actions/cp_notifications';
	elgg_register_action('cp_notify/subscribe', "$actions_base/subscribe.php");
	elgg_register_action('cp_notify/unsubscribe', "$actions_base/unsubscribe.php");
	elgg_register_action('user/requestnewpassword', "$actions_base/request_new_password.php", 'public');

	elgg_register_action('cp_notify/retrieve_group_contents', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_group_contents.php'); // ajaxy
	elgg_register_action('cp_notify/retrieve_pt_users', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_pt_users.php'); // ajaxy
	elgg_register_action('cp_notify/retrieve_messages', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_messages.php'); // ajaxy

	elgg_register_plugin_hook_handler('email', 'system', 'cpn_email_handler_hook');	// intercepts and blocks emails and notifications to be sent out
	elgg_register_event_handler('create','object','cp_create_notification');		// send notifications when the action is sent out
	elgg_register_event_handler('create','annotation','cp_create_annotation_notification');	// likes notification

	elgg_register_event_handler('create', 'membership_request', 'cp_membership_request');

	// we need to check if the mention plugin is installed and activated because it does notifications differently...
	if (elgg_is_active_plugin('mentions')) {	
		elgg_unregister_event_handler('create', 'object','mentions_notification_handler');
		elgg_unregister_event_handler('update', 'annotation','mentions_notification_handler');
	}

	if (elgg_is_active_plugin('thewire_tools'))
		elgg_unregister_event_handler('create', 'object', 'thewire_tools_create_object_event_handler');

	// since most of the notifications are built within the action file itself, the trigger_plugin_hook was added to respected plugins
	elgg_register_plugin_hook_handler('cp_overwrite_notification', 'all', 'cp_overwrite_notification_hook');

	elgg_unregister_action('useradd'); 
	elgg_register_action('useradd',"$actions_base/useradd.php",'admin');	// cyu - actions/useradd.php (core file)

    elgg_extend_view("js/elgg", "js/notification");							// add some notification js 

    // remove core notification settings portion of the main settings page
    elgg_unextend_view('forms/account/settings', 'core/settings/account/notifications');

	// maintenance script actions
    $action_path = elgg_get_plugins_path() . 'cp_notifications/actions/cp_notifications';
	elgg_register_action('cp_notifications/set_personal_subscription', "$action_path/set_personal_subscription.php");
	elgg_register_action('cp_notifications/reset_personal_subscription', "$action_path/reset_personal_subscription.php");
    
    elgg_register_action('cp_notifications/subscribe_users_to_group_content',"$actions_base/subscribe_users_to_group_content.php");
    elgg_register_action('cp_notifications/undo_subscribe_users_to_group_content',"$actions_base/undo_subscribe_users_to_group_content.php");

    elgg_register_action('cp_notifications/usersettings/save', elgg_get_plugins_path() . 'cp_notifications/actions/usersettings/save.php');

	// cyu - allow users to subscribe to all their group things
	elgg_register_action('cp_notifications/user_autosubscription',"{$action_path}/user_autosubscription.php");

	elgg_register_action('cp_notifications/fix_inconsistent_subscription_script',"{$action_path}/fix_inconsistent_subscription_script.php");


	// cron job - for daily/weekly newsletter (digest requirement)
	elgg_register_plugin_hook_handler('cron', 'daily', 'cp_digest_cron_handler');
	elgg_register_plugin_hook_handler('cron', 'weekly', 'cp_digest_cron_handler');
	// http://gcconnex12_dev.gc.ca/cron/daily  --> go here to execute cron jobs
}

function cp_digest_cron_handler($hook, $entity_type, $return_value, $params) {

	/*
	 *	- setup crontab on daily (midnight~5am)
	 *	- get users who are subscribed to digest
	 *	- run crontab, retrieve users, send digest, reset timer (update timestamp)
	 *	- create object [ title:<subject> / description:<email-content> / subtype:<cp_digest_site> or <cp_digest_group> ]
	 *
	 */
	echo "Starting up the cron job for the Notifications (cp_notifications plugin)";
	$options = array(
		'type' => 'object',
		'subtype' => 'cp_digest',
	);
	$current_digest = elgg_get_entities($options);


	$subject = "Your digest here";
	// go through the list of notification digests (per user)
	foreach ($current_digest as $notify_user) {

		// make sure the user has their setting set first before sending
		if (strcmp(elgg_get_plugin_user_setting('cpn_bulk_notifications_email', $notify_user->getOwnerGUID(),'cp_notifications'),'bulk_notifications_email') == 0) {
			$user = get_user($notify_user->getOwnerGUID());
			$timestamp = date("F j, Y, g:i a",$notify_user->time_updated);	// use time created (just update this timestamp when we send off notification)
			echo "<p> {$user->username} -- {$user->email} on {$timestamp} </p>";

			// TODO: check to see if it's daily or weekly
			$subject = $notify_user->title;
			$message = array('email_content' => $notify_user->description);
			$template = elgg_view('cp_notifications/newsletter_template', $message);
			mail($user->email,$subject,$template,cp_get_headers());

			// clear the digest, get ready for the next one
			$notify_user->description = '';
			$notify_user->save();
			$notify_user->getOwnerEntity()->cpn_newsletter = $notify_user->guid;
			//error_log("cpn_newsletter value - {$notify_user->guid} / {$notify_user->getOwnerEntity()->cpn_newsletter}");
			//$notify_user->delete();
			//$user->deleteMetadata('cpn_newsletter');

		$digest_content = ""; // we will save all the text into this variable
		$digest_activities = "";
		$digest_comments = "";
		$digest_revisions = "";
		$digest_mm_posting = "";

		error_log("---------------------- RECEIPT  START ----------------------");
		$title = explode('|',$notify_user->title);
		error_log("sending to user.... {$title[1]}");
		error_log("send following updated stuff.... {$notify_user->description}");

		// go through the items in the digest notification (new blog, new comment, new... etc)
		$digest_items = json_decode($notify_user->description, true);

		foreach ($digest_items['new_group_content'] as $digest_item => $digest_title) {
			$digest_content .= "item id: {$digest_item} / item title: {$digest_title} <br/>";
		}

		foreach ($digest_items['new_like'] as $digest_item => $digest_title) {
			$digest_activities .= "item id: {$digest_item} / item title: {$digest_title} <br/>";
		}

		foreach ($digest_items['new_content'] as $digest_item => $digest_title) {
			$digest_content .= "item id: {$digest_item} / item title: {$digest_title} <br/>"; 
		}

		foreach ($digest_items['new_comment'] as $digest_item => $digest_title) {
			$digest_comments .= "item id: {$digest_item} / item title: {$digest_title} <br/>";
		}

		foreach ($digest_items['new_mission'] as $digest_item => $digest_title) {
			$digest_mm_posting .= "item id: {$digest_item} / item title: {$digest_title} <br/>";
		}


		foreach ($digest_items['new_revision'] as $digest_item => $digest_title) {
			$digest_revisions .= "item id: {$digest_item} / item title: {$digest_title} <br/>";
		}

		error_log("---------------------- RECEIPT  ENDDD ----------------------");
		//$notify_user->delete();
		
		$template = elgg_view('cp_notifications/newsletter_template', array(
			'new_content' => $digest_content, 
			'new_like' => $digest_activities, 
			'new_comment' => $digest_comment, 
			'new_mission' => $digest_mm_posting, 
			'new_revision' => $digest_revision));


		mail($title[1], $subject, $template, cp_get_headers());
	
	}
}



/*
 * cp_overwrite_notification_hook
 * 
 * This contains all the notifications that are required to be triggered from the original action files. Filepaths
 * are documented beside each case (and in the readme.md file)
 *
 */

function cp_overwrite_notification_hook($hook, $type, $value, $params) {

	$cp_msg_type = trim($params['cp_msg_type']);
	$to_recipients = array();
	$email_only = false;					// some notifications require only sending off emails
	$add_to_sent = false;					// messages should only be saved in a user's sent messages box if it's an actual message they sent (as opposed to an automated notification they triggered)
	$sender_guid = elgg_get_site_entity()->guid;	// By default, the sender for notifications is the site

	
	switch($cp_msg_type) {

		// E-MAIL ONLY NOTIFICATIONS (includes: user add to site, friend invite via email, forgot password, validate user)
		//==================================================================================================================

		
		// these are special cases, where we only have the recipient's email address (because they have not joined the application yet)
		case 'cp_friend_invite':		// invitefriends/actions/invite.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_from_user' => $params['cp_from']->name, // cp_from is a user object
				'cp_to_user' => $params['cp_to'],
				'cp_join_url' => $params['cp_join_url'],
				'cp_msg' => $params['cp_email_msg'],
				'_user_e-mail' => $params['cp_to'],
			);
			$subject = elgg_echo('cp_notify:subject:invite_new_user',array(),'en') . ' | ' . elgg_echo('cp_notify:subject:invite_new_user',array(),'fr');
			$template = elgg_view('cp_notifications/email_template', $message);
			$user_obj = get_user_by_email($params['cp_to']);

			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send($params['cp_to'], $params['cp_to'], $subject, $template, NULL, true );
			else
				mail($params['cp_to'],$subject,$template,cp_get_headers()); 
			return true;


		case 'cp_forgot_password':		// send email notifications only - /wet4/users/action/password
			cp_send_new_password_request($params['cp_user_pass_req_guid']);
			return true;


		case 'cp_group_invite_email':	// group_tools/lib/functions.php (returns user's email, so return after mail is sent out)
			$subject = elgg_echo('cp_notify:subject:group_invite_email',array($params['cp_inviter']['name'],$params['cp_group_invite']['name']),'en') . ' | ' . elgg_echo('cp_notify:subject:group_invite_email',array($params['cp_inviter']['name'],$params['cp_group_invite']['name']),'fr');
			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);
			$message = array(
				'cp_email_invited' => $params['cp_invitee'],
				'cp_email_invited_by' => $params['cp_inviter'],
				'cp_group_invite' => $params['cp_group_invite'],
				'cp_invitation_non_user_url' => $params['cp_invitation_nonuser_url'],
				'cp_invitation_url' => $params['cp_invitation_url'],
				'cp_invitation_code' => $params['cp_invitation_code'],
				'cp_invitation_msg' => $params['cp_invitation_msg'],
				'cp_msg_type' => $cp_msg_type,
				'_user_e-mail' => $params['cp_invitee']
			);
			$template = elgg_view('cp_notifications/email_template', $message);
			$user_obj = get_user_by_email($params['cp_invitee']);
			
			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send( $params['cp_invitee'], $params['cp_invitee'], $subject, $template, NULL, true );
			else
				mail($params['cp_invitee'],$subject,$template,cp_get_headers());
			return true;


		// all cases after this point, recipients all have a user object (they have already an account on the application)
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
			$subject = elgg_echo('cp_notify:subject:add_new_user',array(),'en') . ' | ' . elgg_echo('cp_notify:subject:add_new_user',array(),'fr');
			$email_only = true;
			break;


		case 'cp_validate_user': // uservalidationbyemail/lib/functions.php
			$message = array(
				'cp_validate_user' => $params['cp_validate_user'],
				'cp_validate_url' => $params['cp_validate_url'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:validate_user',array($params['cp_validate_user']['email']),'en') . ' | ' . elgg_echo('cp_notify:subject:validate_user',array($params['cp_validate_user']['email']),'fr');
			$to_recipients[] = get_user($params['cp_validate_user']['guid']);
			$email_only = true;
			break;



		
		// NOTIFICATIONS THAT REQUIRE TO BE SAVED IN SENT FOLDER OF SITE-INBOX
		//==================================================================================================================

		case 'cp_site_msg_type':	// messages/actions/messages/send.php
			$add_to_sent = true;	// since this is not a notification, it does need to go into the user's sent history
			$sender_guid = $params['cp_from']['guid'];		// special case: this is an actual user-to-user message, and thus should be sent from the user that sent it.
			$to_recipients[] = get_user($params['cp_to']['guid']);
			$subject = $params['cp_topic_title'];
			$message = array(
				'cp_msg_title' => $params['cp_topic_title'],
				'cp_msg_content' => $params['cp_topic_description'],
				'cp_sender' => $params['cp_from']['name'],
				'cp_msg_url' => $params['cp_topic_url'],
				'cp_msg_type' => 'cp_site_msg_type',
			);
			break;



		// NORMAL NOTIFICATIONS
		//==================================================================================================================

		case 'cp_wire_share': // thewire_tools/actions/add.php
			
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_shared_by' => $params['cp_shared_by'],
				'cp_content_reshare' => $params['cp_content_reshare'],
				'cp_content' => $params['cp_content'],
				'cp_recipient' => $params['cp_recipient'],
				'cp_wire_url' => $params['cp_wire_url'],
			);

			$parent_item = $params['cp_content']->getContainerEntity();


			

			error_log("reshare: {$params['cp_content_reshare']->description}");
			error_log("current content: {$params['cp_content']->description}");

			if ($params['cp_content']->getType() == 'group') {
				$type = $params['cp_content']->getType();
			} else {
				$type = cp_translate_subtype($params['cp_content']->getSubtype());
			}

			if (strcmp($params['cp_content']->getSubtype(),'thewire') == 0) {
				$subject = elgg_echo('cp_notify:wireshare_thewire:subject',array($params['cp_shared_by']->name,cp_translate_subtype($params['cp_content']->getSubtype()),'en'));
				$subject .= ' | '.elgg_echo('cp_notify:wireshare_thewire:subject',array($params['cp_shared_by']->name,cp_translate_subtype($params['cp_content']->getSubtype()),'fr'));
			} else {
				$subject = elgg_echo('cp_notify:wireshare:subject',array($params['cp_shared_by']->name,$type,$params['cp_content']->title),'en');
				$subject .= ' | '.elgg_echo('cp_notify:wireshare:subject',array($params['cp_shared_by']->name,$type,$params['cp_content']->title),'fr');
			}
			$to_recipients[] = $params['cp_recipient'];
			break;


		case 'cp_messageboard': // messageboard/actions/add.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_message_content' => $params['cp_message_content'],
				'cp_writer_name' => $params['cp_writer']->name,
				'cp_owner_profile' => $params['cp_recipient']->getURL(),
			);
			$subject = elgg_echo('cp_notify:messageboard:subject',array(),'en') . ' | ' . elgg_echo('cp_notify:messageboard:subject',array(),'fr');
			$to_recipients[] = $params['cp_recipient'];
			break;


		case 'cp_content_mention': // mentions/start.php
			$message = array(
				'cp_author' => $params['cp_author'],
				'cp_content' => $params['cp_content'],
				'cp_link' => $params['cp_link'],
				'cp_msg_type' => 'cp_mention_type',
				'cp_content_desc' => $params['cp_content_desc'],
			);
			$subject = elgg_echo('cp_notify:subject:mention',array($params['cp_author']),'en') . ' | ' . elgg_echo('cp_notify:subject:mention',array($params['cp_author']),'fr');
			$to_recipients[] = $params['cp_to_user'];
			break;


		case 'cp_add_grp_operator': // group_operators/actions/group_operators/add.php (adds group operator)
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_to_operator' => $params['cp_to_operator'],
				'cp_who_made_operator' => $params['cp_who_made_operator'], 
				'cp_group_name' => $params['cp_group_name'],
				'cp_who_made_operator' => $params['cp_who_made_operator'],
				'cp_group_url' => $params['cp_group_url'],
			);
			$subject = elgg_echo('cp_notify:subject:add_grp_operator',array($params['cp_group_name']),'en') . ' | ' . elgg_echo('cp_notify:subject:add_grp_operator',array($params['cp_group_name']),'fr');
			$to_recipients[] = $params['cp_to_user'];
			break;


		case 'cp_grp_admin_transfer': // group_tools/lib/functions.php (this is transfer of group owner)
			// note: gets called when you change owner through editing group
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_group_name' => $params['cp_group_name'],
				'cp_group_url' => $params['cp_group_url'],
				'cp_appointer' => $params['cp_appointer']
			);
			$subject = elgg_echo('cp_notify:subject:group_admin_transfer',array($params['cp_group_name']),'en') . ' | ' . elgg_echo('cp_notify:subject:group_admin_transfer',array($params['cp_group_name']),'fr');
			$to_recipients[] = $params['cp_new_owner_user'];
			break;


		case 'cp_wire_mention': // thewire_tools/lib/events.php (TODO: share option in notifications setting)
			$message = array(
				'cp_mention_by' => $params['cp_mention_by'],
				'cp_view_mention' => $params['cp_view_your_mention'],
				'cp_msg_type' => $cp_msg_type,
				'cp_wire_mention_url' => $params['cp_wire_mention_url'],
			);
			$subject = elgg_echo('cp_notify:subject:wire_mention',array($params['cp_mention_by']),'en') . ' | ' . elgg_echo('cp_notify:subject:wire_mention',array($params['cp_mention_by']),'fr');
			$to_recipients[] = $params['cp_send_to'];
			break;


		case 'cp_friend_approve': // friend_request/actions/approve
			$subject = elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'en') . ' | ' . elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'fr');
			$message = array(
				'cp_approver' => $params['cp_approver'],
				'cp_approver_profile' => $params['cp_approver_profile'],
				'cp_msg_type' => $cp_msg_type,
				);
			$to_recipients[] = get_user($params['cp_request_guid']);
			break;


		case 'cp_group_add':	// group_tools/lib/functions.php OR groups/actions/groups/membership/add.php ????
			$to_recipients[] = $params['cp_user_added'];
			$subject = elgg_echo('cp_notify:subject:group_add_user',array($params['cp_group']['name']),'en') . ' | ' . elgg_echo('cp_notify:subject:group_add_user',array($params['cp_group']['name']),'fr');
			$message = array(
				'cp_user_added' => $params['cp_user_added'],
				'cp_group' => $params['cp_group'],
				'cp_message' => $params['cp_added_msg'],
				'cp_msg_type' => $cp_msg_type
			);
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


		case 'cp_group_mail': // group_tools/actions/mail.php
			$message = array(
				'cp_group' => $params['cp_group'],
				'cp_group_subject' => $params['cp_group_subject'],
				'cp_group_message' => $params['cp_group_message'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:group_mail',array($params['cp_group_subject'],$params['cp_group']['name']),'en');
            $subject .= ' | '.elgg_echo('cp_notify:subject:group_mail',array($params['cp_group_subject'],$params['cp_group']['name']),'fr');
			foreach ($params['cp_group_mail_users'] as $to_user)
				$to_recipients[$to_user] = get_user($to_user);
			break;


		case 'cp_friend_request': // friend_request/lib/events.php
			$message = array(
				'cp_friend_request_from' => $params['cp_friend_requester'],
				'cp_friend_request_to' => $params['cp_friend_receiver'],
				'cp_friend_invitation_url' => $params['cp_friend_invite_url'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:friend_request',array($params['cp_friend_requester']['name']),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:friend_request',array($params['cp_friend_requester']['name']),'fr');
			$to_recipients[] = get_user($params['cp_friend_receiver']['guid']);
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
			$subject = elgg_echo('cp_notify:subject:hjpost',array($params['cp_topic_author'],$params['cp_topic_title']),'en'); 
			$subject .= ' | '.elgg_echo('cp_notify:subject:hjpost',array($params['cp_topic_author'],$params['cp_topic_title']),'fr');
			foreach ($t_user as $s_uer)
				$to_recipients[] = get_user($s_uer);
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
			$subject = elgg_echo('cp_notify:subject:hjtopic',array($params['cp_topic_author'],$params['cp_topic_title']),'en'); 
			$subject .= ' | '.elgg_echo('cp_notify:subject:hjtopic',array($params['cp_topic_author'],$params['cp_topic_title']),'fr');
			foreach ($t_user as $s_uer)
				$to_recipients[] = get_user($s_uer);
			break;

		// see - cp_create_notification
		/*case 'cp_event': // event_calendar/actions/event_calendar/add_personal.php AND /edit.php
			if ($params['is_minor_edit'] == 1)
				return false;

			$message = array(
				'cp_event_send_to_user' => $params['cp_event_send_to_user'], // cyu - will need to explode with delim ,
				'cp_event_invite_url' => $params['cp_event_invite_url'],
				'cp_event_time' => $params['cp_event_time'],
				'cp_event' => $params['cp_event'],
				'type_event' => $params['type_event'],
				'cp_msg_type' => $cp_msg_type
			);

			if (strcmp($params['type_event'],'UPDATE') == 0) {
				$subject = elgg_echo('cp_notify:event_update:subject', array($params['cp_event']->title), 'en');
				$subject .= ' | '.elgg_echo('cp_notify:event_update:subject', array($params['cp_event']->title), 'fr');
			} else {
				$subject = elgg_echo('cp_notify:event:subject', array(), 'en'); 
				$subject .= ' | '.elgg_echo('cp_notify:event:subject', array(), 'fr');
			}
			$to_recipients = $params['cp_event_send_to_user'];
			break;*/

		case 'cp_event_request': // event_calendar/actions/event_calendar/request_personal_calendar.php
			$message = array(
				'cp_event_request_user' => $params['cp_event_request_user'],
				'cp_event_request_url' => $params['cp_event_request_url'],
				'cp_event_object' => $params['cp_event_obj'],
				'type_event' => $params['type_event'], // create, request, cancel
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:event_request:subject',array($params['cp_event_request_user'], $params['cp_event_obj']->title),'en');
			$subject .= ' | '.elgg_echo('cp_notify:event_request:subject',array($params['cp_event_request_user'], $params['cp_event_obj']->title),'fr');
			$to_recipients[] = $params['cp_event_owner'];
			break;

		case 'cp_event_ics': // .../mod/event_calendar/actions/event_calendar/add_ics.php
			$message = array(
				'cp_event_send_to_user' => $params['cp_event_send_to_user'],
				//'cp_event_invite_url' => $params['cp_event_invite_url'],
				'startdate' => $params['startdate'],
				'enddate' => $params['enddate'],
				'cp_event' => $params['cp_event'],
				'cp_msg_type' => $cp_msg_type,
			);

			$event = $params['cp_event'];
			$startdate = $params['startdate'];
			$enddate = $params['enddate'];   
			// do we need this?
			$type_event = $params['type_event'];
 			$mime_boundary = "----Meeting Booking----".MD5(TIME());

   			$template = "--$mime_boundary\r\n";
    		$template .= "Content-Type: text/html; charset=UTF-8\n";
    		$template .= "Content-Transfer-Encoding: 8bit\n\n";

  			$template .= elgg_view('cp_notifications/email_template', $message);
    		$template .= "--$mime_boundary\r\n";	
	
			$ical = cp_ical_headers($type_event, $event, $startdate, $enddate);
		   
		    $template .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
		    $template .= "Content-Transfer-Encoding: 8bit\n\n";
		    $template .= $ical;
		    $subject = $event->title.' - '.elgg_get_logged_in_user_entity()->username; // Add to my Outlook calendar | Ajoutez a mon calendrier d'Outlook
		   
		     $event = 'event';
		   $to_recipients[] = $params['cp_event_send_to_user'];
			break;

		default:
			break;
	}

	if (empty($subject))
		return false;

	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

	foreach ($to_recipients as $to_recipient) {
		// username for link in footer (both email notification and site notification
		$message['user_name'] = $to_recipient->username;
		$message['_user_e-mail'] = $to_recipient->email;	// the links are different if users are from external facing of gcconnex
		if ($cp_msg_type != 'cp_event_ics'){ //template has to be before the ics section
			$template = elgg_view('cp_notifications/email_template', $message);
		}
		
		
		// appropriate for newsletter
		$newsletter_appropriate = array('cp_wire_share','cp_messageboard','cp_wire_mention','cp_hjpost','cp_hjtopic');
		if (strcmp(elgg_get_plugin_user_setting('cpn_bulk_notifications_email', $to_recipient->guid,'cp_notifications'),'bulk_notifications_email') == 0 && in_array($cp_msg_type,$newsletter_appropriate)) {
				$user = get_user($recipient_user->guid);
				$digest = get_entity((int)$recipient_user->cpn_newsletter);
				$timestamp = date("F j, Y, g:i a",$object->time_created);
				$digest->description .= "<div style='border:1px solid #000000; padding:10px 10px 10px 10px;'>";
				$digest->description .= "<p>{$timestamp}</p> <p><strong>{$subject}</strong></p>";
				$digest->description .= "</div> <br/>";
				$digest->save();
		} else {

			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template );
			else
				mail($to_recipient->email, $subject, $template, cp_get_headers($event));
		}

		messages_send($subject, $template, $to_recipient->guid, $sender_guid, 0, true, $add_to_sent);
			
	}
}



/*
 * cp_ical_headers()
 * 
 * returns the headers for ical
 */
function cp_ical_headers($type_event, $event, $startdate, $enddate) {

	$ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:'.$type_event. "\r\n" .
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
    //'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    //'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.$event->guid ."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="Eastern Time":'.date("Ymd\THis", strtotime($startdate)). "\r\n" .
    'DTEND;TZID="Eastern Time":'.date("Ymd\THis", strtotime($enddate)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:1'. "\r\n" .
	'SUMMARY:'.$event->title."\r\n" .
	'LOCATION:'.$event->venue."\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";

	return $ical;
}




/*
 * cp_create_annotation_notification is an event handler, invokes everytime a user likes something, edit something, etc
 * 
 * This contains the likes and the comments that get posted. we also filter out the 
 * following : blog revision, discussion replies (?), tasks, poll votes, folder creation
 *
 * @param string $event		the name of the event
 * @param string $type		the type of the object
 * @param mixed $object		the object/entity of the event
 */
function cp_create_annotation_notification($event, $type, $object) {

	$entity = get_entity($object->entity_guid);

	// cyu - this object is a minor edit... don't bother to send notifications
	if ($entity->entity_minor_edit)
		return;

	$dbprefix = elgg_get_config('dbprefix');
	$site = elgg_get_site_entity();
	$object_subtype = $object->getSubtype();
	$liked_content = get_entity($object->entity_guid);
	$type_of_like = $liked_content->getSubtype();

	// EDITS TO BLOGS AND PAGES, THEY ARE CONSIDERED ANNOTATION DUE TO REVISIONS AND MULTIPLE COPIES OF SAME CONTENT
	//==================================================================================================================
	if (strcmp($object_subtype,'likes') != 0) {

		$content = get_entity($object->entity_guid);

		//error_log("subtype: {$object_subtype} / status: {$entity->status} //// minor edit: {$entity->entity_minor_edit}" );


		// auto save -drafts or -published blogs, we don't send out notifications
		if (strcmp($object_subtype,'blog_auto_save') == 0 && (strcmp($entity->status,'draft') == 0 || strcmp($entity->status, 'published') == 0))
			return;

		// if we are publishing, or revising blogs then send out notification
		if (strcmp($object_subtype,'blog_revision') == 0 && strcmp($entity->status,'published') == 0) {

			$current_user = get_user($entity->getOwnerGUID());

			$subject = elgg_echo('cp_notify:subject:edit_content',array('The blog',$entity->title, $current_user->username),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:edit_content',array('Le blogue',$entity->title, $current_user->username),'fr');

			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

			$message = array(
				'cp_content' => $entity,
				'cp_user' => $current_user->username,
				'cp_msg_type' => 'cp_content_edit',
				'cp_fr_entity' => 'Ce blogue',
				'cp_en_entity' => 'blog',
			);

			$query = "SELECT DISTINCT u.guid, u.email, u.username FROM {$dbprefix}entity_relationships r, {$dbprefix}users_entity u WHERE r.guid_one <> {$current_user->guid} AND r.relationship LIKE 'cp_subscribed_to_%' AND r.guid_two = {$entity->getContainerGUID()} AND r.guid_one = u.guid";
			$watchers = get_data($query);

			foreach ($watchers as $watcher) {
				$message['user_name'] = $watcher->username;
				$message['_user_e-mail'] = $watcher->email;	// for P/T users
				$template = elgg_view('cp_notifications/email_template', $message);
				

				if ($watcher->guid != $current_user->getGUID()) { // make sure we don't send the notification to the owner themselves

					if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_email', $entity->getContainerGUID())) {
						

						if (strcmp(elgg_get_plugin_user_setting('cpn_bulk_notifications_email', $watcher->guid,'cp_notifications'),'bulk_notifications_email') == 0) {
							cp_digest_preparation($watcher->guid, $content, 'new_revision');
						
						
						} else {

							if (elgg_is_active_plugin('phpmailer'))
								phpmailer_send( $watcher->email, $watcher->name, $subject, $template, NULL, true );
							else
								mail($watcher->email, $subject, $template, cp_get_headers());
						}
					}

					if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_site_mail', $entity->getContainerGUID()))
						messages_send($subject, $template, $watcher->guid, $site->guid, 0, true, false);
				}
			}
			return true;
		} // end if (if subtype is blog, and published)

		if (strcmp($object_subtype,'page') == 0 || strcmp($object_subtype,'page_top') == 0 || strcmp($object_subtype,'task') == 0 || strcmp($object_subtype,'task_top') == 0) {
			$current_user = get_user($object->owner_guid);

			$subject = elgg_echo('cp_notify:subject:edit_content',array('The page', $entity->title, $current_user->username),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:edit_content',array('La page',$entity->title, $current_user->username),'fr');
			
			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

			$message = array(
				'cp_content' => $entity,
				'cp_user' => $current_user->username,
				'cp_msg_type' => 'cp_content_edit',
				'cp_fr_entity' => 'Cette page',
				'cp_en_entity' => 'page',
			);

			$query = "SELECT DISTINCT u.guid, u.email, u.username FROM {$dbprefix}entity_relationships r, {$dbprefix}users_entity u WHERE r.guid_one <> {$current_user->guid} AND r.relationship LIKE 'cp_subscribed_to_%' AND r.guid_two = {$entity->guid} AND r.guid_one = u.guid";
			$watchers = get_data($query);

			foreach ($watchers as $watcher) {
				$message['user_name'] = $watcher->username;
				$message['_user_e-mail'] = $watcher->email;	// fpr P/T users
				$template = elgg_view('cp_notifications/email_template', $message);
				

				if ($watcher->guid != $object->owner_guid) { // make sure we don't send the notification to the user who made the changes
					if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_email', $entity->getContainerGUID())) {
						
						if (strcmp(elgg_get_plugin_user_setting('cpn_bulk_notifications_email', $watcher->guid,'cp_notifications'),'bulk_notifications_email') == 0) {
						
	   
							cp_digest_preparation($watcher->guid, $content, 'new_revision');
						
						
						} else {

							if (elgg_is_active_plugin('phpmailer'))
								phpmailer_send( $watcher->email, $watcher->name, $subject, $template, NULL, true );
							else
								mail($watcher->email, $subject, $template, cp_get_headers());
						}
					}

					if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_site_mail', $entity->getContainerGUID()))
						messages_send($subject, $template, $watcher->guid, $site->guid, 0, true, false);
				}
			}
			return true;
		}
	

	} else {

		// LIKES TO COMMENTS AND DISCUSSION REPLIES
		//==================================================================================================================
	
    	$content_entity = get_entity($object->entity_guid); 			// get the comment object
		$comment_author = get_user($content_entity->owner_guid); 		// get the user who made the comment
		$content = get_entity($content_entity->getContainerGUID());		// get the location of comment
		$content_title = $content->title; 									// get title of content
		$liked_by = get_user($object->owner_guid); 							// get user who liked comment


	    switch ($type_of_like) {
	    	case 'comment':

	    		$subject = elgg_echo('cp_notify:subject:likes_comment', array($liked_by->name,$content_title),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_comment',array($liked_by->name,$content_title),'fr');

	    		$message = array(
	    			'cp_liked_by' => $liked_by->name,
	    			'cp_comment_from' => $content_title,
					'cp_msg_type' => 'cp_likes_comments',
				);

				$to_recipients[$comment_author->getGUID()] = $comment_author;
	    		break;
	    	
	    	case 'discussion_reply':

	    		$subject = elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name,$content_title),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name,$content_title),'fr');

				$message = array(
					'cp_liked_by' => $liked_by->name,
					'cp_comment_from' => $content_title,
					'cp_msg_type' => 'cp_likes_topic_replies',
				);

				$to_recipients[$comment_author->getGUID()] = $comment_author;
	    		break;

	    	default:

		    	if ($liked_content instanceof ElggUser) {

					// cyu - there doesn't seem to be any differentiation between updated avatar and colleague connection
		    		$liked_by = get_user($object->owner_guid); // get user who liked comment
		    		$subject = elgg_echo('cp_notify:subject:likes_user_update',array($liked_by->name),'en') . ' | ' . elgg_echo('cp_notify:subject:likes_user_update',array($liked_by->name),'fr');
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
						'cp_description' => $content->description,
						'cp_content_url' => $content->getURL(),
					);

	    			$to_recipients[$content_author->guid] = $content_author;
		    	}
	    		break;

		} // end switch statement
	}

	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);
	
	foreach ($to_recipients as $to_recipient_id => $to_recipient) {

		// we only send notification to user who owns the content (liking a comment, discussion reply or general likes to content)

		if ($to_recipient->getGUID() == $content_entity->getOwnerGUID()) {

			// pass in the information into the template to prepare the notification
			$message['user_name'] = get_user($to_recipient->guid)->username;
			$message['_user_e-mail'] = $to_recipient->email;	// for P/T user
			$template = elgg_view('cp_notifications/email_template', $message); 
			
			// bulk notifications
			if (strcmp(elgg_get_plugin_user_setting('cpn_bulk_notifications_email', $to_recipient->guid,'cp_notifications'),'bulk_notifications_email') == 0) {
				error_log("hey hey hey");
				cp_digest_preparation($to_recipient->guid, $content, 'new_like');

			} else {

				// TODO: split the notifications (site vs email)
				//if (strcmp(elgg_get_plugin_user_setting("cpn_likes_site", $to_recipient->getGUID(), 'cp_notifications'), 'likes_site') == 0) {
				//if (strcmp(elgg_get_plugin_user_setting("cpn_likes_email", $to_recipient->getGUID(), 'cp_notifications'), 'likes_email') == 0) {
				cp_notification_preparation_send($content_entity, $to_recipient, $message, $content_entity->getOwnerGUID(), $subject);

			}
		}
	}

} // end of function





/*
 * function cp_create_notification is an event handler, invokes everytime a new entity is created
 * This contains the notifications for new content posted on GCconnex
 * 
 * @param string $event		the name of the event
 * @param string $type		the type of object (eg "user", "group", ...)
 * @param mixed $object		the object/entity of the event
 */
function cp_create_notification($event, $type, $object) {

	$dbprefix = elgg_get_config('dbprefix');
	$subject = "";
	$no_notification = false;
	error_log("create notification for {$object->getSubtype()}");
	$do_not_subscribe_list = array('poll_choice','blog_revision','widget','folder','c_photo', 'cp_digest');
	if (in_array($object->getSubtype(), $do_not_subscribe_list))
		return true;

	error_log("create notification for {$object->getSubtype()} created");
	
	$site = elgg_get_site_entity();
	$to_recipients = array();

	switch ($object->getSubtype()) {

		case 'discussion_reply':
		case 'comment':

			// if mentions plugin is enabled... check to see if there were any mentions
			if (elgg_is_active_plugin('mentions') && $object->getSubtype() !== 'messages') 
				$cp_mentioned_users = cp_scan_mentions($object);

			// retrieve all necessary information for notification
			$container_entity = $object->getContainerEntity();
			$guid_two = $container_entity->getGUID();
			$content_originator = $object->getOwnerGUID();
			
			
			$user_comment = get_user($object->owner_guid);
			$topic_container = $container_entity->getContainerEntity();


			// comment or reply in a group
			if ($topic_container instanceof ElggGroup) {
				$entity_residence = 'grp';
				if (strcmp($object->getSubtype(), 'discussion_reply') == 0) {
					$subject = elgg_echo('cp_notify:subject:comments_discussion',array($topic_container->name),'en');
					$subject .= ' | '.elgg_echo('cp_notify:subject:comments_discussion',array($topic_container->name),'fr');
				} else {
					$subject = elgg_echo('cp_notify:subject:comments',array($topic_container->name),'en');
					$subject .= ' | '.elgg_echo('cp_notify:subject:comments',array($topic_container->name),'fr');
				}

			// comment or reply in a user
			} else {
				$entity_residence = 'usr';
				$subject = elgg_echo('cp_notify:subject:comments_user', array($topic_container->name), 'en');
				$subject .= ' | '.elgg_echo('cp_notify:subject:comments_user', array($topic_container->name), 'fr');
			}
	
			$message = array(
				'cp_container' => $entity_residence, 
				'cp_user_comment' => $user_comment,
				'cp_topic' => $container_entity,
				'cp_topic_type' => cp_translate_subtype($container_entity->getSubtype()),
				'cp_comment' => $object,
				'cp_msg_type' => 'cp_reply_type',
			);

			// the user creating the content is automatically subscribed to it
			add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $container_entity->getGUID());
			add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $container_entity->getGUID());
			break;


		// micromissions / opportunities
		case 'mission':
			$content_originator = $site->getGUID();
			$guid_two = $site->getGUID(); // do we allow sending notification to the poster?

			// get users who want to be notified about new opportunities by site message
			$op_siteusers = get_data("SELECT id, entity_guid FROM {$dbprefix}private_settings WHERE name = 'plugin:user_setting:cp_notifications:cpn_opportunities_site' AND value = 'opportunities_site'");

			foreach ($op_siteusers as $result){
				$userid = $result->entity_guid;
				$user_obj = get_user($userid);
				if ( userOptedIn( $user_obj, $object->job_type ) ){
					$to_recipients[$userid] = $user_obj;
				}
			}

			// get users who want to be notified about new opportunities by email
			$op_emailusers = get_data("SELECT * FROM {$dbprefix}private_settings WHERE name = 'plugin:user_setting:cp_notifications:cpn_opportunities_email' AND value = 'opportunities_email'");

			foreach ($op_emailusers as $result){
				$userid = $result->entity_guid;
				$user_obj = get_user($userid);
				if ( userOptedIn( $user_obj, $object->job_type ) )
					$to_recipients_email[$userid] = $user_obj;
			}

			$message = array(
				'cp_topic' => $object,
				'cp_msg_type' => 'cp_new_type',
			);
			$subject = "New micromission notification";
			// the user creating the content is automatically subscribed to it
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $object->getGUID());
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $object->getGUID());
			break;

		default:	
			
			//$cp_whitelist = array('site_notification','blog','file','thewire','album','image','bookmarks','poll','task_top','task','task','page','page_top','hjforum','hjforumtopic','groupforumtopic','event_calendar','idea');
			error_log("subtype thing: {$object->getSubtype()}");
			// cyu - there is an issue with regards to auto-saving drafts
			if (strcmp($object->getSubtype(),'blog') == 0) {
				if (strcmp($object->status,'draft') == 0 || strcmp($object->status,'unsaved_draft') == 0)
					return;
			}

			// the user creating the content is automatically subscribed to it (with exception that is not a widget, forum, etc..)
		
			add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $object->getGUID());
			add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $object->getGUID());

				
			$guid_two = $object->getContainerGUID();
			$content_originator = $object->getOwnerGUID();

			$user = get_user($object->owner_guid);
			$group = $object->getContainerEntity();

			// fem and mas are different (so the subject should be reflected on which subtype is passed)
			// for contents within a group
			$subtypes_gender_subject = array(
				'blog' => elgg_echo('cp_notify:subject:new_content_mas',array("blogue",$group->name),'fr'),
				'bookmarks' => elgg_echo('cp_notify:subject:new_content_mas',array("signet",$group->name),'fr'),
				'file' => elgg_echo('cp_notify:subject:new_content_mas',array("fichier",$group->name),'fr'),
				'poll' => elgg_echo('cp_notify:subject:new_content_mas',array("sondage",$group->name),'fr'),
				'event_calendar' => elgg_echo('cp_notify:subject:new_content_mas',array("nouvel événement",$group->name),'fr'),
				'album' => elgg_echo('cp_notify:subject:new_content_mas',array("album d'image",$group->name),'fr'),
				'groupforumtopic' => elgg_echo('cp_notify:subject:new_content_fem',array("discussion",$group->name),'fr'),
				'image' => elgg_echo('cp_notify:subject:new_content_fem',array("image",$group->name),'fr'),
				'idea' => elgg_echo('cp_notify:subject:new_content_fem',array("idée",$group->name),'fr'),
				'page' => elgg_echo('cp_notify:subject:new_content_fem',array("page",$group->name),'fr'),
				'page_top' => elgg_echo('cp_notify:subject:new_content_fem',array("page",$group->name),'fr'),
				'task_top' => elgg_echo('cp_notify:subject:new_content_fem',array("task",$group->name),'fr'),
				'task' => elgg_echo('cp_notify:subject:new_content_fem',array("task",$group->name),'fr'),
			);


			// cyu - if there is something missing, we can use a fallback string
			if ($subtypes_gender_subject[$object->getSubtype()] == '')
				$subj_gender = elgg_echo('cp_notify:subject:new_content_mas',array($user->name,$object->getSubtype(),$object->title),'fr');
			else
				$subj_gender = $subtypes_gender_subject[$object->getSubtype()];


			// subscribed to content within a group
			if ($object->getContainerEntity() instanceof ElggGroup) {
				$subject = elgg_echo('cp_notify:subject:new_content',array(cp_translate_subtype($object->getSubtype()),$group->name),'en');
				$subject .= ' | '.$subj_gender;


				// subscribed to users or friends
			} else {
				$content_originator = $object->getOwnerGUID();
				$guid_two = $object->getOwnerGUID();


				if (!$object->title) {
					$subject = elgg_echo('cp_notify_usr:subject:new_content2',array($object->getOwnerEntity()->username,$object->getSubtype()),'en');
					$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content2',array($object->getOwnerEntity()->username,$object->getSubtype()),'fr');
				} else {
					if($object->title1){
						$object->title = $object->title1;

					}
					$subject = elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username,$object->getSubtype(),$object->title),'en');
					$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username,$object->getSubtype(),$object->title),'fr');
				}
			}
				
			$message = array(
				'cp_topic' => $object, 
				'cp_msg_type' => 'cp_new_type',
				'cp_topic_description' => $object->description,
			);

			$email_only = false;

			break;

	} // end of switch statement


	// check for empty subjects or empty content 
	if (empty($subject))
		return false;

$subject = htmlspecialchars_decode($subject,ENT_QUOTES);
//$subject = html_entity_decode($subject);
//	$subject = utf8_encode ($subject);


	if (empty($to_recipients)) {
		$query = "SELECT DISTINCT u.guid, u.email, u.username FROM {$dbprefix}entity_relationships r, {$dbprefix}users_entity u WHERE r.guid_one <> {$content_originator} AND r.relationship LIKE 'cp_subscribed_to_%' AND r.guid_two = {$guid_two} AND r.guid_one = u.guid";
		$to_recipients = get_data($query);
	}


	//foreach ($to_recipients as $to_recipient_id => $to_recipient)
	foreach ($to_recipients as $to_recipient)
	{
		// user wants a collection of all their notification
		if (strcmp(elgg_get_plugin_user_setting('cpn_bulk_notifications_email', $to_recipient->guid,'cp_notifications'),'bulk_notifications_email') == 0) {
			cp_digest_preparation($to_recipient->guid, $object);

		// user did not enable notification collections (digest)
		} else {
			cp_notification_preparation_send($object, $to_recipient, $message, $guid_two, $subject);
		}
	}
}


/*
 * prepare the digest
 * 
 * @param int			$user_id		the recipient of the notification
 * @param ElggObject	$entity			the new entity that has been created
 * @param string		$action_type	the type of action (new object, edited, etc) default is  `new_object`
 */
function cp_digest_preparation($user_id, $entity, $action_type = 'new_object') {

	$user = get_user($user_id);
	//$notification_collection = get_entity($user->cpn_newsletter);
	$subtype = $entity->getSubtype();
	$dbprefix = elgg_get_config('dbprefix');
	
	if (strcmp($action_type,'new_revision') == 0) {

		$user_entity = get_user($user_id);
		$digest = get_entity($user_entity->cpn_newsletter); // get entity
		$digest_collection = json_decode($digest->description, true);

		// new entities had been created
		$digest_collection['new_revision'][$entity->getGUID()] = $entity->title;

		cp_save_to_db($digest, $digest_collection);
		
	} elseif (strcmp($action_type, 'new_like') == 0) {

		$user_entity = get_user($user_id);
		$digest = get_entity($user_entity->cpn_newsletter); // get entity
		$digest_collection = json_decode($digest->description, true);

		// new entities had been created
		$digest_collection['new_like'][$entity->getGUID()] = $entity->title;

		cp_save_to_db($digest, $digest_collection);

	} else {

		switch ($subtype) {
			case 'mission':
				$user_entity = get_user($user_id);
				$digest = get_entity($user_entity->cpn_newsletter); // get entity
				$digest_collection = json_decode($digest->description, true);

				// new entities had been created
				$digest_collection['new_mission'][$entity->getGUID()] = $entity->title;

				cp_save_to_db($digest, $digest_collection);
				break;

			case 'comment':
			case 'discussion_reply':

				$user_entity = get_user($user_id);
				$digest = get_entity($user_entity->cpn_newsletter); // get entity
				$digest_collection = json_decode($digest->description, true);

				// new comment or reply has been created (in either group or user)???
				// TODO: for comments, we can total up the amount of comments for the topic


				// extracting the title (english and french)
				if (elgg_is_active_plugin('wet4')) {
					$digest_collection['new_comment'][$entity->getGUID()] = gc_explode_translation($entity->getContainerEntity()->title3,'en').' / '.gc_explode_translation($entity->getContainerEntity()->title3,'fr');
				} else {
					$digest_collection['new_comment'][$entity->getGUID()] = $entity->getContainerEntity()->title;
				}

				cp_save_to_db($digest, $digest_collection);
				break;

			default:	// user created new core/main entity (blogs, discussion, bookmarks, etc)
				
				$user_entity = get_user($user_id);
				$digest = get_entity($user_entity->cpn_newsletter); // get entity
				$digest_collection = json_decode($digest->description, true);
				
				// new entity has been created (either in group or user)
				if ($entity->getContainerEntity() instanceof ElggGroup) {
					$digest_collection['new_group_content'][$entity->getGUID()] = $entity->title;

					// extracting the title (english and french)
					if (elgg_is_active_plugin('wet4')) {
						$digest_collection['new_group_content'][$entity->getGUID()] = gc_explode_translation($entity->title3,'en').' / '.gc_explode_translation($entity->title3,'fr');
					} else {
						$digest_collection['new_group_content'][$entity->getGUID()] = $entity->title;
					}

				} else {

					// extracting the title (english and french)
					if (elgg_is_active_plugin('wet4')) {
						$digest_collection['new_content'][$entity->getGUID()] = gc_explode_translation($entity->title3,'en').' / '.gc_explode_translation($entity->title3,'fr');
					} else {
						$digest_collection['new_content'][$entity->getGUID()] = $entity->title;
					}
				}

				cp_save_to_db($digest, $digest_collection);

		} // end switch
	}
}


/*
 * save the digest to the object, for ease of access
 * 
 * @param ElggObject $entity			the object that will contain the collection array
 * @param array		 $new_collection	the array that will be the digest
 */
function cp_save_to_db($entity, $new_collection) {
	// ignore access temporarily to set the digest
	$ia = elgg_set_ignore_access(true);

	$entity->description = json_encode($new_collection);
	$entity->save();

	// set old access back to the way it was
	elgg_set_ignore_access($ia);
}

/* (WIP) cyu - recursively go through the parents of the wire posts (thread - kind of) */
function cp_sub_to_wire_thread($wire_id) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT guid_two FROM {$dbprefix}entity_relationships WHERE relationship = 'parent' AND guid_one = {$wire_id}";
	$parent_id = get_data($query);


	/*
	if (!$parent_id) {

	} else {
		$wire_id = 
		cp_sub_to_wire_thread($wire_id);
	}*/
}




/*
 * check if user has access then prepare the notification and send (if applicable)
 * 
 * @param ElggObject					$entity			entity that has been created
 * @param array(guid, email, username)	$to_user		recipient
 * @param array(various)				$message		message that will be in the notification
 * @param int							$guid_two		author or group id (check if subscribe to friend or group)
 */
function cp_notification_preparation_send($entity, $to_user, $message, $guid_two, $subject) {

	$template = elgg_view('cp_notifications/email_template', $message);

	// TODO: fix up mission
	if (strcmp($entity->getSubtype(),'mission') == 0) {
		// send out emails
		if ($to_user->getGUID() != elgg_get_logged_in_user_guid()) { // prevents notification to be sent to the sender
			if ($to_user instanceof ElggUser) {
				if (elgg_is_active_plugin('phpmailer'))
					phpmailer_send( $to_user->email, $to_user->name, $subject, $template, NULL, true );
				else
					mail($to_user->email,$subject,$template,cp_get_headers());
			}


		} else {

			// check if user has access to the content (DO NOT send if user has no access to this object)
			if (cp_check_permissions($entity, $to_user->guid)) {

				//  GCCON-175: assemble the email content with correct username (for notification page)
				$message['user_name'] = $to_user->username;

				// check if user subscribed to receiving notifications
				if (check_entity_relationship($to_user->guid, 'cp_subscribed_to_email', $guid_two)) 
				{	
					if (elgg_is_active_plugin('phpmailer'))
						phpmailer_send( $to_user->email, $to_user->name, $subject, $template, NULL, true );
					else
						mail($to_user->email,$subject,$template,cp_get_headers());
				}

				// send a site notification
				if (check_entity_relationship($to_user->guid, 'cp_subscribed_to_site_mail', $guid_two)) {
					messages_send($subject, $template, $to_recipient->guid, $site->guid, 0, true, false);
				}
			} // end if (check for access)

		}
	}
}


/*
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





/*
 * cp_send_new_password_request
 * 
 * In order to modify core code, this action had to be overwritten.
 * This is a mirror image of the core function: /engine/classes/Elgg/PasswordService.php
 *
 * Only need to send an e-mail notification out, no need to send a site-mail
 */
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
	$link = _elgg_services()->config->getSiteUrl() . "changepassword?u={$user_guid}&c={$code}";

	// generate email
	$ip_address = _elgg_services()->request->getClientIp();
	// we don't need to check if the plugin (cp_notifications) is enabled here
	$message = array(
		'cp_password_request_user' => $user->username,
		'cp_password_request_ip' => $ip_address,
		'cp_password_request_url' => $link,
		'cp_msg_type' => 'cp_forgot_password',
	);

	$subject = elgg_echo('cp_notify:subject:forgot_password', array(), "en");
	$subject .= ' | '.elgg_echo('cp_notify:subject:forgot_password', array(), "fr");
	$template = elgg_view('cp_notifications/email_template', $message);

	if (elgg_is_active_plugin('phpmailer'))
	phpmailer_send( $user->email, $user->name, $subject, $template );
	else
		mail($user->email,$subject,$template,cp_get_headers());
}


/*
 * cp_get_headers
 * 
 * We need to modify the headers so that emails can go out (header spoofing)
 *
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
    //$headers .= 'Content-class: urn:content-classes:calendarmessage'."\r\n";
	//$headers .='Content-Disposition: inline; filename=calendar.ics'."\r\n";
	return $headers;
}


/*
 * cp_membership_request
 * 
 * replaced the event (see init()) so we can send out notifications through this plugin instead
 *
 */

function cp_membership_request($event, $type, $object) { 	// MUST always be sending notification
	$request_user = get_user($object->guid_one); 			// user who sends request to join
	$group_request = get_entity($object->guid_two);			// group that is being requested

	$message = array(
		'cp_group_req_user' => $request_user,
		'cp_group_req_group' => $group_request,
		'cp_msg_type' => 'cp_closed_grp_req_type',
	);
	$template = elgg_view('cp_notifications/email_template', $message);
	$subject = elgg_echo('cp_notify:subject:group_request',array($request_user->name, $group_request->name),'en');
	$subject .= ' | '.elgg_echo('cp_notify:subject:group_request',array($request_user->name, $group_request->name),'fr');
	
	$to_user = get_user($group_request->owner_guid);
	if (elgg_is_active_plugin('phpmailer')) {
		phpmailer_send( $to_user->email, $to_user->name, $subject, $template, NULL, true );
	} else {
		mail($to_user->email,$subject,$template,cp_get_headers());
	}
	messages_send($subject, $template, $to_user->guid, elgg_get_site_entity()->guid, 0, true, false);
}




/*
 * cp_scan_mentions
 * 
 * scans the text object for any @mentions
 *
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



/*
 * cpn_email_handler_hook
 * 
 * intercepts all email and stops emails from sending
 *
 */

function cpn_email_handler_hook($hook, $type, $notification, $params) {
	return false;
}



/*
 * notify_entity_menu_setup
 * 
 * this is where the bell icon is implemented
 *
 */

function notify_entity_menu_setup($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$do_not_subscribe_list = array('comment','discussion_reply','widget');
	if (elgg_in_context('widgets') || in_array($entity->getSubtype(), $do_not_subscribe_list))
		return $return;

	// cyu - check for everything to put the bell thingy (xor)
	$allow_subscription = false;
	if ( $entity->getContainerEntity() instanceof ElggGroup ) {
		if ($entity->getContainerEntity()->isMember(elgg_get_logged_in_user_entity()) == 1 ) 
			$allow_subscription = true;
	
	} else if ($entity instanceof ElggGroup) {
		if ($entity->isMember(elgg_get_logged_in_user_entity()) == 1 )
			$allow_subscription = true;
	
	} else if ( $entity->getContainerEntity() instanceof ElggUser )
		$allow_subscription = true;

	
	if ($allow_subscription && elgg_is_logged_in()) {
	    if ( check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $entity->getGUID()) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $entity->getGUID()) ) {

			if (elgg_is_active_plugin('wet4')) // check if plugin for wet is enabled (if disabled, FontAwesome will not show up)
			 	$bell_status = '<i class="icon-unsel fa fa-lg fa-bell"></i>';
		    else
			    $bell_status = elgg_echo('cp_notify:stop_subscribe');
		
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

		    if (elgg_is_active_plugin('wet4')) // check if plugin for wet is enabled
			   $bell_status = '<i class="icon-unsel fa fa-lg fa-bell-slash-o"></i>';
		    else
			   $bell_status = elgg_echo('cp_notify:start_subscribe');

		    $return[] = ElggMenuItem::factory(array(
			    'name' => 'set_notify',
			    'href' => elgg_add_action_tokens_to_url("/action/cp_notify/subscribe?guid={$entity->guid}"),
			    'text' => $bell_status,
			    'title' => elgg_echo('cp_notify:subBell'),
			    'priority' => 1000,
			    'class' => '',
			    'item_class' => ''
		    ));
		} // end if display subscribe bell or unsubscribe bell
	}
	return $return;
}



/*
 * cp_translate_subtype
 * 
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


/*
 * Helper function for notifications about new opportunities
 */
function userOptedIn( $user_obj, $mission_type ){
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

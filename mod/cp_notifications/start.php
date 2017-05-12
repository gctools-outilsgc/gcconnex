<?php

elgg_register_event_handler('init','system','cp_notifications_init');




function cp_notifications_init() {

	elgg_register_library('elgg:gc_notification:functions', elgg_get_plugins_path() . 'cp_notifications/lib/functions.php');

	elgg_register_css('cp_notifications-css','mod/cp_notifications/css/notifications-table.css');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'notify_entity_menu_setup', 400);

	$actions_base = elgg_get_plugins_path() . 'cp_notifications/actions/cp_notifications';
	elgg_register_action('cp_notify/subscribe', "$actions_base/subscribe.php");
	elgg_register_action('cp_notify/unsubscribe', "$actions_base/unsubscribe.php");
	elgg_register_action('user/requestnewpassword', "$actions_base/request_new_password.php", 'public');

	elgg_register_action('cp_notify/retrieve_group_contents', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_group_contents.php'); // ajaxy
	elgg_register_action('cp_notify/retrieve_personal_content', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_personal_content.php'); // ajaxy

	elgg_register_action('cp_notify/retrieve_pt_users', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_pt_users.php'); // ajaxy
	elgg_register_action('cp_notify/retrieve_messages', elgg_get_plugins_path().'cp_notifications/actions/ajax_usersettings/retrieve_messages.php'); // ajaxy

	elgg_register_action('cp_notify/retrieve_user_info', elgg_get_plugins_path().'cp_notifications/actions/ajax_settings/retrieve_user_info.php'); // ajaxy

	elgg_register_plugin_hook_handler('email', 'system', 'cpn_email_handler_hook');	// intercepts and blocks emails and notifications to be sent out
	elgg_register_event_handler('create','object','cp_create_notification');		// send notifications when the action is sent out
	elgg_register_event_handler('create','annotation','cp_create_annotation_notification');	// likes notification

	elgg_register_event_handler('create', 'membership_request', 'cp_membership_request');

	// we need to check if the mention plugin is installed and activated because it does notifications differently...
	if (elgg_is_active_plugin('mentions')) {
		elgg_unregister_event_handler('create', 'object','mentions_notification_handler');
		elgg_unregister_event_handler('update', 'annotation','mentions_notification_handler');
	}

	//if (elgg_is_active_plugin('thewire_tools'))
	//	elgg_unregister_event_handler('create', 'object', 'thewire_tools_create_object_event_handler');

	// since most of the notifications are built within the action file itself, the trigger_plugin_hook was added to respected plugins
	elgg_register_plugin_hook_handler('cp_overwrite_notification', 'all', 'cp_overwrite_notification_hook');

	elgg_unregister_action('useradd');
	elgg_register_action('useradd',"$actions_base/useradd.php",'admin');	// cyu - actions/useradd.php (core file)

    elgg_extend_view("js/elgg", "js/notification");							// add some notification js
    elgg_extend_view("js/elgg", "js/popup");
    elgg_extend_view("js/elgg","js/wet4/language_ajax");							// add some notification js

    // remove core notification settings portion of the main settings page
    elgg_unextend_view('forms/account/settings', 'core/settings/account/notifications');

    $action_path = elgg_get_plugins_path() . 'cp_notifications/actions/cp_notifications';
	elgg_register_action('cp_notifications/set_personal_subscription', "$action_path/set_personal_subscription.php");
	elgg_register_action('cp_notifications/reset_personal_subscription', "$action_path/reset_personal_subscription.php");

    elgg_register_action('cp_notifications/subscribe_users_to_group_content',"$actions_base/subscribe_users_to_group_content.php");
    elgg_register_action('cp_notifications/undo_subscribe_users_to_group_content',"$actions_base/undo_subscribe_users_to_group_content.php");

    elgg_register_action('cp_notifications/usersettings/save', elgg_get_plugins_path() . 'cp_notifications/actions/usersettings/save.php');
	elgg_register_action('cp_notifications/user_autosubscription',"{$action_path}/user_autosubscription.php");
	elgg_register_action('cp_notifications/fix_inconsistent_subscription_script',"{$action_path}/fix_inconsistent_subscription_script.php");

	elgg_register_plugin_hook_handler('cron', 'daily', 'cp_digest_daily_cron_handler');
	elgg_register_plugin_hook_handler('cron', 'weekly', 'cp_digest_weekly_cron_handler');
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
	$email_only = false;
	$add_to_sent = false;
	$sender_guid = elgg_get_site_entity()->guid;
	elgg_load_library('elgg:gc_notification:functions');

	switch($cp_msg_type) {

		/// EMAIL NOTIFICATIONS ONLY (password reset, registration, etc)
		case 'cp_friend_invite': // invitefriends/actions/invite.php
			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_from_user' => $params['cp_from']->name,
				'cp_to_user' => $params['cp_to'],
				'cp_join_url' => $params['cp_join_url'],
				'cp_msg' => $params['cp_email_msg'],
				'_user_e-mail' => $params['cp_to'],
			);
			$subject = elgg_echo('cp_notify:subject:invite_new_user',array(),'en') . ' | ' . elgg_echo('cp_notify:subject:invite_new_user',array(),'fr');
			$template = elgg_view('cp_notifications/email_template', $message);
			$site_template = elgg_view('cp_notifications/site_template', $message);
			$user_obj = get_user_by_email($params['cp_to']);

			$result = (elgg_is_active_plugin('phpmailer')) ? phpmailer_send($params['cp_to'], $params['cp_to'], $subject, $template, NULL,true) : mail($params['cp_to'],$subject,$template,cp_get_headers());
			return true;


		case 'cp_forgot_password':	// send email notifications only - /wet4/users/action/password
			cp_send_new_password_request($params['cp_password_requester']);
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
				'_user_e-mail' => $params['cp_invitee'],
				'group_link' => $params['group_link'],
				'cp_user_profile' => $params['cp_user_profile'],
			);
			$template = elgg_view('cp_notifications/email_template', $message);
			$site_template = elgg_view('cp_notifications/site_template', $message);
			$user_obj = get_user_by_email($params['cp_invitee']);

			$result = (elgg_is_active_plugin('phpmailer')) ? phpmailer_send( $params['cp_invitee'], $params['cp_invitee'], $subject, $template, NULL, true ) : mail($params['cp_invitee'],$subject,$template,cp_get_headers());
			return true;

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

		case 'cp_site_msg_type':	// messages/actions/messages/send.php
			$add_to_sent = true;
			$sender_guid = $params['cp_from']['guid'];
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

		/// NORMAL NOTIFICATIONS that will send out both email and site notification
		case 'cp_wire_share': // thewire_tools/actions/add.php

			$message = array(
				'cp_msg_type' => $cp_msg_type,
				'cp_shared_by' => $params['cp_shared_by'],
				'cp_content_reshare' => $params['cp_content_reshared'],
				'cp_content' => $params['cp_content'],
				'cp_recipient' => $params['cp_recipient'],
				'cp_wire_url' => $params['cp_wire_url'],
			);

			$parent_item = $params['cp_content']->getContainerEntity();

			$type = (strcmp($params['cp_content']->getType(),'group') == 0) ? $params['cp_content']->getType() : cp_translate_subtype($params['cp_content']->getSubtype());

			if (strcmp($params['cp_content']->getSubtype(),'thewire') == 0) {
				$subject = elgg_echo('cp_notify:wireshare_thewire:subject',array($params['cp_shared_by']->name,cp_translate_subtype($params['cp_content']->getSubtype()),'en'));
				$subject .= ' | '.elgg_echo('cp_notify:wireshare_thewire:subject',array($params['cp_shared_by']->name,cp_translate_subtype($params['cp_content']->getSubtype()),'fr'));
			} else {
				$subject = elgg_echo('cp_notify:wireshare:subject',array($params['cp_shared_by']->name,$type,$params['cp_content']->title),'en');
				$subject .= ' | '.elgg_echo('cp_notify:wireshare:subject',array($params['cp_shared_by']->name,$type,$params['cp_content']->title),'fr');
			}
			$to_recipients[] = $params['cp_recipient'];

			$content_entity = $params['cp_content_reshared'];
			$author = $params['cp_shared_by'];
			$content_url = $params['cp_content_reshared']->getURL();
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

			$content_entity = $params['cp_message_content'];
			$author = $params['cp_writer'];
			break;


		// case 'cp_content_mention': // mentions/start.php
		// 	$message = array(
		// 		'cp_author' => $params['cp_author'],
		// 		'cp_content' => $params['cp_content'],
		// 		'cp_link' => $params['cp_link'],
		// 		'cp_msg_type' => 'cp_mention_type',
		// 		'cp_content_desc' => $params['cp_content_desc'],
		// 	);
		// 	$subject = elgg_echo('cp_notify:subject:mention',array($params['cp_author']),'en') . ' | ' . elgg_echo('cp_notify:subject:mention',array($params['cp_author']),'fr');
		// 	$to_recipients[] = $params['cp_to_user'];

		// 	$content_entity = $params['cp_content'];
		// 	$author = $params['cp_author'];

		// 	break;


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


		case 'cp_grp_admin_transfer': // group_tools/lib/functions.php (this is transfer of group owner through group edit)
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

			$content_entity = $params['cp_wire_entity'];
			$author = $content_entity->getOwnerEntity();
			break;


		case 'cp_friend_approve': // friend_request/actions/approve
			$subject = elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'en') . ' | ' . elgg_echo('cp_notify:subject:approve_friend',array($params['cp_approver']),'fr');
			$message = array(
				'cp_approver' => $params['cp_approver'],
				'cp_approver_profile' => $params['cp_approver_profile'],
				'cp_msg_type' => $cp_msg_type,
				);
			$to_recipients[] = get_user($params['cp_request_guid']);

			$content_entity = $params['cp_approver_profile'];
			$author = $params['cp_friend_approver'];
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

			$content_entity = $params['cp_invite_to_group'];
			$author = $params['cp_inviter'];
			break;


		case 'cp_group_mail': // group_tools/actions/mail.php
			$message = array(
				'cp_group' => $params['cp_group'],
				'cp_group_subject' => $params['cp_group_subject'],
				'cp_group_message' => $params['cp_group_message'],
				'cp_msg_type' => $cp_msg_type
			);
			$subject = elgg_echo('cp_notify:subject:group_mail',array($params['cp_group_subject'],$params['cp_group']['name']),'en') . ' | ' . elgg_echo('cp_notify:subject:group_mail',array($params['cp_group_subject'],$params['cp_group']['name']),'fr');
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
			$subject = elgg_echo('cp_notify:subject:friend_request',array($params['cp_friend_requester']['name']),'en') . ' | ' . elgg_echo('cp_notify:subject:friend_request',array($params['cp_friend_requester']['name']),'fr');
			$to_recipients[] = get_user($params['cp_friend_receiver']['guid']);

			$content_entity = $params['cp_friend_invite_url'];
			$author = $params['cp_friend_requester'];

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

			$content_entity = $params['cp_post'];
			$content_url = $params['cp_topic_url'];
			$author = $params['cp_post']->getOwnerEntity();

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

			$content_url = $params['cp_topic_url'];
			$content_entity = $params['cp_topic'];
			$author = $params['cp_topic']->getOwnerEntity();
			break;

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
		if ($cp_msg_type != 'cp_event_ics') {
			$template = elgg_view('cp_notifications/email_template', $message);
			$site_template = elgg_view('cp_notifications/site_template', $message);
		}

		$newsletter_appropriate = array('cp_wire_share','cp_messageboard','cp_wire_mention','cp_hjpost','cp_hjtopic', 'cp_friend_request', 'cp_friend_approve');
		if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid,'cp_notifications'),'set_digest_yes') == 0 && in_array($cp_msg_type, $newsletter_appropriate)) {
			$result = create_digest($author, $cp_msg_type, $content_entity, $to_recipient, $content_url);
			continue;
		} else
			$result = (elgg_is_active_plugin('phpmailer')) ? phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template ) : mail($to_recipient->email, $subject, $template, cp_get_headers($event));

		messages_send($subject, $site_template, $to_recipient->guid, $sender_guid, 0, true, $add_to_sent);
	}
}


/*
 * returns the headers for ical
 *
 * @param string 		$type_event
 * @param ElggObject 	$event
 * @param string 		$start_date
 * @param string 		$end_date
 */
function cp_ical_headers($event_type, $event, $start_date, $end_date) {

	$end_date = date("Ymd\THis", strtotime($end_date));
	$start_date = date("Ymd\THis", strtotime($startdate));
	$current_date = date("Ymd\TGis");

	$ical = "
	BEGIN:VCALENDAR \r\n
    PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN \r\n
    VERSION:2.0 \r\n
    METHOD: {$type_event} \r\n
    BEGIN:VTIMEZONE \r\n
    TZID:Eastern Time \r\n
    BEGIN:STANDARD \r\n
    DTSTART:20091101T020000 \r\n
    RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11 \r\n
    TZOFFSETFROM:-0400 \r\n
    TZOFFSETTO:-0500 \r\n
    TZNAME:EST \r\n
    END:STANDARD \r\n
    BEGIN:DAYLIGHT \r\n
    DTSTART:20090301T020000 \r\n
    RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3 \r\n
    TZOFFSETFROM:-0500 \r\n
    TZOFFSETTO:-0400 \r\n
    TZNAME:EDST \r\n
    END:DAYLIGHT \r\n
    END:VTIMEZONE \r\n
    BEGIN:VEVENT \r\n
    LAST-MODIFIED: {$current_date} \r\n
    UID: {$event->guid} \r\n
    DTSTAMP:  \r\n
    DTSTART;TZID='Eastern Time': {$start_date} \r\n
    DTEND;TZID='Eastern Time': {$end_date} \r\n
    TRANSP:OPAQUE \r\n
    SEQUENCE:1 \r\n
	SUMMARY: {$event->title} \r\n
	LOCATION: {$event->venue} \r\n
    CLASS:PUBLIC \r\n
    PRIORITY:5 \r\n
    BEGIN:VALARM \r\n
    TRIGGER:-PT15M \r\n
    ACTION:DISPLAY \r\n
    DESCRIPTION:Reminder \r\n
    END:VALARM \r\n
    END:VEVENT \r\n
    END:VCALENDAR \r\n";

	return $ical;
}




/**
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

	elgg_load_library('elgg:gc_notification:functions');
	$entity = get_entity($object->entity_guid);

	if ($entity->entity_minor_edit)	return;

	$dbprefix = elgg_get_config('dbprefix');
	$site = elgg_get_site_entity();
	$object_subtype = $object->getSubtype();
	$liked_content = get_entity($object->entity_guid);
	$type_of_like = $liked_content->getSubtype();
	$action_type = "content_revision";
	$author = $liked_by;

	/// EDITS TO BLOGS AND PAGES, THEY ARE CONSIDERED ANNOTATION DUE TO REVISIONS AND MULTIPLE COPIES OF SAME CONTENT
	if (strcmp($object_subtype,'likes') != 0) {

		$content = get_entity($object->entity_guid);

		// auto save -drafts or -published blogs, we don't send out notifications
		if (strcmp($object_subtype,'blog_auto_save') == 0 && (strcmp($entity->status,'draft') == 0 || strcmp($entity->status, 'published') == 0)) return;


		// if we are publishing, or revising blogs then send out notification
		if (strcmp($object_subtype,'blog_revision') == 0 && strcmp($entity->status,'published') == 0) {
			$current_user = get_user($entity->getOwnerGUID());
			$subject = elgg_echo('cp_notify:subject:edit_content',array('The blog',$entity->title, $current_user->username),'en') . ' | ' . elgg_echo('cp_notify:subject:edit_content:m',array('Le blogue',$entity->title, $current_user->username),'fr');
			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

			$message = array(
				'cp_content' => $entity,
				'cp_user' => $current_user->username,
				'cp_msg_type' => 'cp_content_edit',
				'cp_fr_entity' => 'Ce blogue',
				'cp_en_entity' => 'blog',
			);

			$author = $current_user;
			$content_entity = $entity;

			$watchers = get_subscribers($dbprefix, $entity->getOwnerGUID(), $entity->getContainerGUID());

			foreach ($watchers as $watcher) {
				$message['user_name'] = $watcher->username;

				$template = elgg_view('cp_notifications/email_template', $message);
				$site_template = elgg_view('cp_notifications/site_template', $message);

				// create the digest if the digest is enabled
				if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $watcher->guid,'cp_notifications'), 'set_digest_yes') == 0)
					create_digest($author, $action_type, $content_entity, get_entity($watcher->guid));

				// create the instant notification if digest is not enabled
				else
					(elgg_is_active_plugin('phpmailer')) ? phpmailer_send($watcher->email, $watcher->name, $subject, $template, NULL, true) : mail($watcher->email, $subject, $template, cp_get_headers());
			

				if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_site_mail', $entity->getContainerGUID())) 
					messages_send($subject, $template, $watcher->guid, $site->guid, 0, true, false);

				return true;
			}
		}


		// checks for condition if the content being modified is a page or task
		if (strcmp($object_subtype,'page') == 0 || strcmp($object_subtype,'page_top') == 0 || strcmp($object_subtype,'task') == 0 || strcmp($object_subtype,'task_top') == 0) {
			$current_user = get_user($object->owner_guid);
			$subject = elgg_echo('cp_notify:subject:edit_content',array('The page', $entity->title, $current_user->username),'en');
			$subject .= ' | '.elgg_echo('cp_notify:subject:edit_content:f',array('La page',$entity->title, $current_user->username),'fr');

			$subject = htmlspecialchars_decode($subject,ENT_QUOTES);

			$message = array(
				'cp_content' => $entity,
				'cp_user' => $current_user->username,
				'cp_msg_type' => 'cp_content_edit',
				'cp_fr_entity' => 'Cette page',
				'cp_en_entity' => 'page',
			);

			$author = $current_user;
			$content_entity = $entity;

			$watchers = get_subscribers($dbprefix, $current_user->guid, $entity->guid);

			foreach ($watchers as $watcher) {
				$message['user_name'] = $watcher->username;

				$template = elgg_view('cp_notifications/email_template', $message);

				// create the digest if digest is enabled
				if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $watcher->guid,'cp_notifications'),'set_digest_yes') == 0)
					create_digest($author, $action_type, $content_entity, get_entity($watcher->guid));

				// create the instant notification if digest is not enabled
				else
					(elgg_is_active_plugin('phpmailer')) ? phpmailer_send( $watcher->email, $watcher->name, $subject, $template, NULL, true ) : mail($watcher->email, $subject, $template, cp_get_headers());

			
				if (check_entity_relationship($watcher->guid, 'cp_subscribed_to_site_mail', $entity->getContainerGUID())) {
					$site_template = elgg_view('cp_notifications/site_template', $message);
					messages_send($subject, $site_template, $watcher->guid, $site->guid, 0, true, false);
				}
			}

			return true;
		}



	} else {

		/// LIKES TO COMMENTS AND DISCUSSION REPLIES
    	$content_entity = get_entity($object->entity_guid); 			// get the comment object
		$comment_author = get_user($content_entity->owner_guid); 		// get the user who made the comment
		$content = get_entity($content_entity->getContainerGUID());		// get the location of comment
		$content_title = $content->title; 									// get title of content
		$liked_by = get_user($object->owner_guid); 							// get user who liked comment

		$action_type = "post_likes";
	    switch ($type_of_like) {
	    	case 'comment':
	    		$subject = elgg_echo('cp_notify:subject:likes_comment', array($liked_by->name,$content_title),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_comment',array($liked_by->name,$content_title),'fr');

	    		$message = array(
	    			'cp_liked_by' => $liked_by->name,
	    			'cp_comment_from' => "<a href='{$content->getURL()}'>{$content_title}</a>",
					'cp_msg_type' => 'cp_likes_comments',
				);

	    		$author = $liked_by;
	    		$action_type = "like_comment";

	    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $comment_author->getGUID(),'cp_notifications'),'likes_email') == 0)
    				$to_recipients[$comment_author->getGUID()] = $comment_author;
    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $comment_author->getGUID(),'cp_notifications'),'likes_site') == 0)
    				$to_recipients_site[$comment_author->getGUID()] = $comment_author;
	    		break;

	    	case 'discussion_reply':

	    		$subject = elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name,$content_title),'en');
	    		$subject .= ' | '.elgg_echo('cp_notify:subject:likes_discussion',array($liked_by->name,$content_title),'fr');

				$message = array(
					'cp_liked_by' => $liked_by->name,
					'cp_comment_from' => "<a href='{$content->getURL()}'>{$content_title}</a>",
					'cp_msg_type' => 'cp_likes_topic_replies',
				);
				$author = $liked_by;
				$action_type = "like_reply";

	    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $comment_author->getGUID(),'cp_notifications'),'likes_email') == 0)
    				$to_recipients[$comment_author->getGUID()] = $comment_author;
    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $comment_author->getGUID(),'cp_notifications'),'likes_site') == 0)
    				$to_recipients_site[$comment_author->getGUID()] = $comment_author;
	    		break;


	    	default:
	    		$type_of_like = 'user_update';
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

		    		$type_of_like = 'content';
		    		$liked_by = get_user($object->owner_guid); // get user who liked content
		    		$content = get_entity($object->entity_guid);

		    		$content_entity = $content;
		    		$author = $liked_by;
		    		// cyu - patching issue #323 (liking wire post)
		    		if ($content->getSubtype() === 'thewire') {
		    			$subject = elgg_echo('cp_notify:subject:likes_wire',array($liked_by->name,$content->title),'en') . ' | ' . elgg_echo('cp_notify:subject:likes_wire',array($liked_by->name,$content->title),'fr');
		    			$content_subtype = 'thewire';

		    		} else {
		    			$subject = elgg_echo('cp_notify:subject:likes',array($liked_by->name,$content->title),'en') . ' | ' . elgg_echo('cp_notify:subject:likes',array($liked_by->name,$content->title),'fr');
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

		    		if (strcmp(elgg_get_plugin_user_setting('cpn_likes_email', $content->getOwnerGUID(),'cp_notifications'),'likes_email') == 0)
	    				$to_recipients[$content->getOwnerGUID()] = $content->getOwnerEntity();

	    			if (strcmp(elgg_get_plugin_user_setting('cpn_likes_site', $content->getOwnerGUID(),'cp_notifications'),'likes_site') == 0)
	    				$to_recipients_site[$content->getOwnerGUID()] = $content->getOwnerEntity();
		    	}
	    		break;

		} // end switch statement
	}

	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);


	// send notification out via email
	foreach ($to_recipients as $to_recipient_id => $to_recipient) {

		$message['user_name'] = get_user($to_recipient->guid)->username;

		if ($liked_by->guid == $entity->getOwnerGUID() && $to_recipient->guid == $liked_by->guid)  {
			continue;
		}
		
	

		if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid,'cp_notifications'),'set_digest_yes') == 0) {
			create_digest($author, $action_type, $content_entity, $to_recipient);
		} else {

			$template = elgg_view('cp_notifications/email_template', $message);

			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template, NULL, true );
			else
				mail($to_recipient->email, $subject, $template,cp_get_headers());
		}
	}

	// send notification out via site
	foreach ($to_recipients_site as $to_recipient_id => $to_recipient) {
		$site_template = elgg_view('cp_notifications/site_template', $message);
		if (strcmp(elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid,'cp_notifications'),'set_digest_yes') !== 0)
			messages_send($subject, $site_template, $to_recipient->guid, $site->guid, 0, true, false);
	}

} // end of function





/**
 * function cp_create_notification is an event handler, invokes everytime a new entity is created
 * This contains the notifications for new content posted on GCconnex
 *
 * @param string $event		the name of the event
 * @param string $type		the type of object (eg "user", "group", ...)
 * @param mixed $object		the object/entity of the event
 */
function cp_create_notification($event, $type, $object) {

	$do_not_subscribe_list = array('tidypics_batch', 'hjforumtopic', 'messages', 'hjforumpost', 'site_notification', 'poll_choice','blog_revision','widget','folder','c_photo', 'cp_digest','MySkill', 'education', 'experience', 'poll_choice3');
	if (in_array($object->getSubtype(), $do_not_subscribe_list)) return true;

	elgg_load_library('elgg:gc_notification:functions');
	$dbprefix = elgg_get_config('dbprefix');
	$no_notification = false;
	$site = elgg_get_site_entity();
	$to_recipients = array();
	$subject = "";

	switch ($object->getSubtype()) {

		case 'discussion_reply':
		case 'comment':

			// if mentions plugin is enabled... check to see if there were any mentions
			$cp_mentioned_users = (elgg_is_active_plugin('mentions') && $object->getSubtype() !== 'messages') ? cp_scan_mentions($object) : "";

			// send mentioned users a notification
			if (sizeof($cp_mentioned_users) > 0 && is_array($cp_mentioned_users)) {
				for ($i = 0; $i < sizeof($cp_mentioned_users); $i++) {
					$cp_mentioned_user = $cp_mentioned_users[$i];
					$mentioned_user = get_user_by_username(substr($cp_mentioned_user, 1));

					if (!$mentioned_user)
						break;

					$subject = elgg_echo('cp_notify:subject:mention',array($object->getOwnerEntity()->name), 'en') .' | ' . elgg_echo('cp_notify:subject:mention',array($object->getOwnerEntity()->name), 'fr');
					$message = array(
						'cp_msg_type' => 'cp_mention_type',
						'cp_author' => $object->getOwnerEntity()->name,
						'cp_content_desc' => $object->description,
						'cp_cp_link' => $object->getURL()
					);
					$template = elgg_view('cp_notifications/email_template', $message);
					$user_setting = elgg_get_plugin_user_setting('cpn_mentions_email', $mentioned_user->guid, 'cp_notifications');

					if (strcmp($user_setting, 'mentions_email') == 0) {
						$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $mentioned_user->guid, 'cp_notifications');

						// send digest
						if (strcmp($user_setting, "set_digest_yes") == 0) {
							create_digest($object->getOwnerEntity(), "cp_mention", $object, $mentioned_user);

						// send email and site notification
						} else {
							
							if (elgg_is_active_plugin('phpmailer'))
								phpmailer_send( $mentioned_user->email, $mentioned_user->name, $subject, $template, NULL, true );
							else
								mail($mentioned_user->email,$subject,$template,cp_get_headers());
						}
					}

					$user_setting = elgg_get_plugin_user_setting('cpn_mentions_site', $mentioned_user->guid, 'cp_notifications');
					$site_template = elgg_view('cp_notifications/site_template', $message);
					if (strcmp($user_setting, 'mentions_site') == 0)
						messages_send($subject, $site_template, $mentioned_user->guid, $site->guid, 0, true, false);
				}
			}

			// retrieve all necessary information for notification
			$container_entity = $object->getContainerEntity();

			$user_comment = get_user($object->owner_guid);
			$topic_container = $container_entity->getContainerEntity();

			// comment or reply in a group
			if ($topic_container instanceof ElggGroup) {
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

			// digest information purposes
			$content_entity = $container_entity;
			$author = $user_comment;

			// the user creating the content is automatically subscribed to it
			if (elgg_instanceof($container, 'group')) {
	 			if($container->isMember($user_comment)){
					add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $container_entity->getGUID());
					add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $container_entity->getGUID());
				}
			} else {
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $container_entity->getGUID());
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $container_entity->getGUID());
			}


			$to_recipients = get_subscribers($dbprefix, $object->getOwnerGUID(), $object->getContainerGUID());
			$to_recipients_site = get_subscribers($dbprefix, $object->getOwnerGUID(), $object->getContainerGUID());


			break;

		// micromissions / opportunities
		case 'mission':

			// get users who want to be notified about new opportunities by site message
			$op_siteusers = get_data("SELECT id, entity_guid FROM {$dbprefix}private_settings WHERE name = 'plugin:user_setting:cp_notifications:cpn_opportunities_site' AND value = 'opportunities_site'");

			foreach ($op_siteusers as $result) {
				$userid = $result->entity_guid;
				$user_obj = get_user($userid);
				if (userOptedIn($user_obj, $object->job_type)) $to_recipients_site[$userid] = $user_obj;
			}

			// get users who want to be notified about new opportunities by email
			$op_emailusers = get_data("SELECT * FROM {$dbprefix}private_settings WHERE name = 'plugin:user_setting:cp_notifications:cpn_opportunities_email' AND value = 'opportunities_email'");

			foreach ($op_emailusers as $result) {
				$userid = $result->entity_guid;
				$user_obj = get_user($userid);
				if ( userOptedIn( $user_obj, $object->job_type ) ) $to_recipients[$userid] = $user_obj;

			}

			$message = array(
				'cp_topic' => $object,
				'cp_msg_type' => 'new_mission',
			);

			// digest information purposes
			$content_entity = $object;
			$author = $object->getOwnerEntity();

			$subject = elgg_echo('cp_new_mission:subject',array(),'en') . ' | ' . elgg_echo('cp_new_mission:subject',array(),'fr');

			// the user creating the content is automatically subscribed to it
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $object->getGUID());
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $object->getGUID());
			break;

		default:

			// cyu - there is an issue with regards to auto-saving drafts
			if (strcmp($object->getSubtype(),'blog') == 0) {
				if (strcmp($object->status,'draft') == 0 || strcmp($object->status,'unsaved_draft') == 0) return;
			}

			// the user creating the content is automatically subscribed to it (with exception that is not a widget, forum, etc..)
			$cp_whitelist = array('blog', 'bookmarks', 'poll', 'groupforumtopic', 'image', 'idea', 'page', 'page_top', 'thewire', 'task_top');
			if (in_array($object->getSubtype(),$cp_whitelist)) {
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_email', $object->getGUID());
				add_entity_relationship($object->getOwnerGUID(), 'cp_subscribed_to_site_mail', $object->getGUID());
            }


			$user = get_user($object->owner_guid);
			$group = $object->getContainerEntity();

			// fem and mas are different (so the subject should be reflected on which subtype is passed)
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
			$subj_gender = ($subtypes_gender_subject[$object->getSubtype()] == '') ? elgg_echo('cp_notify:subject:new_content_mas',array($user->name,$object->getSubtype(),$object->title),'fr') : $subtypes_gender_subject[$object->getSubtype()];

			// subscribed to content within a group
			if ($object->getContainerEntity() instanceof ElggGroup) {
				$subject = elgg_echo('cp_notify:subject:new_content',array(cp_translate_subtype($object->getSubtype()),$group->name),'en');
				$subject .= ' | '.$subj_gender;

				//$to_recipients = get_subscribers($dbprefix, $object->getContainerGUID(), $object->guid);
				$guidone = $object->getContainerGUID();

				$author_id = $object->getOwnerGUID();
				$content_id = $object->getContainerGUID();

			// subscribed to users or friends
			} else {

				if (!$object->title) {
					if (strstr($object->getSubtype(),"poll_choice") !== false)
						return true;

					$subject = elgg_echo('cp_notify_usr:subject:new_content2',array($object->getOwnerEntity()->username,cp_translate_subtype($object->getSubtype())),'en');
					$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content2',array($object->getOwnerEntity()->username,cp_translate_subtype($object->getSubtype(), false)),'fr');
				} else {

					if (strcmp($object->getSubtype(), 'hjforumpost') != 0 || strcmp($object->getSubtype(), 'hjforumtopic') != 0) {

						$subject = elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username, cp_translate_subtype($object->getSubtype()), $object->title),'en');
						$subject .= ' | '.elgg_echo('cp_notify_usr:subject:new_content',array($object->getOwnerEntity()->username, cp_translate_subtype($object->getSubtype(), false), $object->title),'fr');
					}
				}

				$guidone = $object->getOwnerGUID();
				//$to_recipients = get_subscribers($dbprefix, $object->getOwnerGUID(), $object->guid);
				$author_id = $object->getOwnerGUID();
				//$content_id = $object->guid;
			}

			// cyu - client wants the html tags stripped from the notifications
			$object_description = ($object->description != strip_tags($object->description)) ? "" : $object->description;


			$message = array(
				'cp_topic' => $object,
				'cp_msg_type' => 'cp_new_type',
				'cp_topic_description_discussion' => $object->description,
				'cp_topic_description_discussion2' => $object->description2,
			);

			$content_entity = $object;
			$author = $object->getOwnerEntity();

			$to_recipients = get_subscribers($dbprefix, $author_id, $content_id);
			$to_recipients_site = get_site_subscribers($dbprefix, $author_id, $content_id);
			$email_only = false;
			break;

	} // end of switch statement


	// check for empty subjects or empty content
	if (empty($subject)) return false;
	$subject = htmlspecialchars_decode($subject,ENT_QUOTES);


	foreach ($to_recipients as $to_recipient)
	{

		$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid, 'cp_notifications');

		if ($to_recipient->guid == $author->guid)
			continue;

		// send digest
		if (strcmp($user_setting, "set_digest_yes") == 0)
			create_digest($author, $object->getSubtype(), $content_entity, get_entity($to_recipient->guid));

		// send email and site notification
		else {
			$template = elgg_view('cp_notifications/email_template', $message);

			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send( $to_recipient->email, $to_recipient->name, $subject, $template, NULL, true );
			else
				mail($to_recipient->email,$subject,$template,cp_get_headers());

		}
	}

	foreach ($to_recipients_site as $to_recipient) {
		$user_setting = elgg_get_plugin_user_setting('cpn_set_digest', $to_recipient->guid, 'cp_notifications');

		if ($to_recipient->guid == $author->guid)
			continue;

		if (strcmp($user_setting, "set_digest_yes") == 0)
			continue;

		$site_template = elgg_view('cp_notifications/site_template', $message);
		messages_send($subject, $site_template, $to_recipient->guid, $site->guid, 0, true, false);
	}
}

/**
 * get all the users that are subscribed to a specified entity (content or user id)
 * and return the array of users
 *
 * @param string 			$dbprefix
 * @param integer 			$user_guid
 * @param optional integer 	$entity_guid

 * @param email vs site_mail
 * @return Array <ElggUser>

 */

function get_subscribers($dbprefix, $user_guid, $entity_guid = '') {
	$subscribed_to = ($entity_guid != '') ? $entity_guid : $user_guid;

	$query = "	SELECT DISTINCT u.guid, u.email, u.username, u.name
				FROM {$dbprefix}entity_relationships r LEFT JOIN {$dbprefix}users_entity u ON r.guid_one = u.guid 
				WHERE r.guid_one <> {$user_guid} AND r.relationship = 'cp_subscribed_to_email' AND r.guid_two = {$subscribed_to}";
  
	return get_data($query);
}

function get_site_subscribers($dbprefix, $user_guid, $entity_guid = '') {
	$subscribed_to = ($entity_guid != '') ? $entity_guid : $user_guid;

	$query = " SELECT DISTINCT u.guid, u.email, u.username, u.name
	FROM {$dbprefix}entity_relationships r LEFT JOIN {$dbprefix}users_entity u ON r.guid_one = u.guid
	WHERE r.guid_one <> {$user_guid} AND r.relationship = 'cp_subscribed_to_site_mail' AND r.guid_two = {$subscribed_to}";

	return get_data($query);
}


/**
 * due to a recent update to the core functionality (for Government of Canada instance of Elgg - GCconnex), the
 * titles are now modified to using json string for ability to change content to preferred language (english/french)
 *
 * @param string 	$string
 * @return boolean 	true/false
 */
// function isJson($string) {
// 	json_decode($string);
// 	return (json_last_error() == JSON_ERROR_NONE);
// }


/**
 * setup crontab either on a daily or weekly basis
 * get users who are subscribed to digest
 * run crontab, retrieve users, send digest, reset timer (update timestamp)
 *
 * @param -		$hook
 * @param - 	$entity_type
 * @param - 	$return_value
 * @param - 	$params
 */
function cp_digest_weekly_cron_handler($hook, $entity_type, $return_value, $params) {
	elgg_load_library('elgg:gc_notification:functions');
	$dbprefix = elgg_get_config('dbprefix');

	echo "Starting up the cron job for the Notifications (cp_notifications plugin) <br/>";

	$options = array(
		'type' => 'object',
		'subtype' => 'cp_digest',
		'limit' => false,
	);
	$current_digest = elgg_get_entities($options);

	foreach ($current_digest as $digest) {

		$newsletter_title = explode('|', $digest->title);

		$userid = $newsletter_title[1];
		$query = "SELECT guid, email, name, username FROM {$dbprefix}users_entity WHERE guid = '{$userid}'";


		$user = get_data($query);

		$to = $user[sizeof($user) - 1];
		$user = get_entity($to->guid);

		$enable = elgg_get_plugin_user_setting('cpn_set_digest', $user->guid,'cp_notifications');
		$frequency = elgg_get_plugin_user_setting('cpn_set_digest_frequency', $user->guid, 'cp_notifications');

		if ($user instanceof ElggUser && strcmp($enable,'set_digest_yes') == 0 && strcmp($frequency,'set_digest_weekly') == 0 ) {

			$newsletter_id = $user->cpn_newsletter;
			$newsletter_object = get_entity($newsletter_id);
			$newsletter_content = json_decode($newsletter_object->description, true);

			$subject = elgg_echo('cp_newsletter:subject:weekly',$language_preference);

			if (sizeof($newsletter_content) > 0 || !empty($newsletter_content))
				$template = elgg_view('cp_notifications/newsletter_template', array('to' => $to, 'newsletter_content' => $newsletter_content));
			else
				$template = elgg_view('cp_notifications/newsletter_template_empty', array('to' => $to));


			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send($to->email, $to->name, $subject,$template, NULL, true );
			else
				mail($to->email, $subject, $template, cp_get_headers());

			echo "<p>Digest sent to user email: {$to->email}</p>";

			// TODO: authenticate cronjobs - since crons dont have a valid admin login, thhis portion fails
			// temporarily strip the access
			$ia = elgg_set_ignore_access(true);

			// clean up the newsletter
			$newsletter_object->description = json_encode(array());
			$newsletter_object->save();

			// see above comment about access
			elgg_set_ignore_access($ia);
		}
	}
}



/**
 * setup crontab either on a daily or weekly basis
 * get users who are subscribed to digest
 * run crontab, retrieve users, send digest, reset timer (update timestamp)
 *
 * @param -		$hook
 * @param - 	$entity_type
 * @param - 	$return_value
 * @param - 	$params
 */
function cp_digest_daily_cron_handler($hook, $entity_type, $return_value, $params) {
	elgg_load_library('elgg:gc_notification:functions');
	$dbprefix = elgg_get_config('dbprefix');

	echo "Starting up the cron job for the Notifications (cp_notifications plugin) <br/>";

	$options = array(
		'type' => 'object',
		'subtype' => 'cp_digest',
		'limit' => false,
	);
	$current_digest = elgg_get_entities($options);


	foreach ($current_digest as $digest) {

		$newsletter_title = explode('|', $digest->title);
		// initially set with a user's email address, but if we need the user information, might as well put the id

		$userid = $newsletter_title[1];
		$query = "SELECT guid, email, name, username FROM {$dbprefix}users_entity WHERE guid = '{$userid}'";
		$user = get_data($query);

		$to = $user[sizeof($user) - 1];
		$user = get_entity($to->guid);

		$enable = elgg_get_plugin_user_setting('cpn_set_digest', $user->guid,'cp_notifications');
		$frequency = elgg_get_plugin_user_setting('cpn_set_digest_frequency', $user->guid, 'cp_notifications');

		if ($user instanceof ElggUser && strcmp($enable,'set_digest_yes') == 0 && strcmp($frequency,'set_digest_daily') == 0 ) {

			$newsletter_id = $user->cpn_newsletter;
			$newsletter_object = get_entity($newsletter_id);
			$newsletter_content = json_decode($newsletter_object->description, true);

			$language_preference_en = elgg_get_plugin_user_setting('cpn_set_digest_language', $to->guid, 'cp_notifications');
			if (strcmp($language_preference_en,'set_digest_en') == 0)
				$language_preference = 'en';

			$language_preference_fr = elgg_get_plugin_user_setting('cpn_set_digest_language', $to->guid, 'cp_notifications');
			if (strcmp($language_preference_fr,'set_digest_fr') == 0)
				$language_preference = 'fr';

			$subject = elgg_echo('cp_newsletter:subject:daily',$language_preference);

			if (sizeof($newsletter_content) > 0 || !empty($newsletter_content))
				$template = elgg_view('cp_notifications/newsletter_template', array('to' => $to, 'newsletter_content' => $newsletter_content));
			else
				$template = elgg_view('cp_notifications/newsletter_template_empty', array('to' => $to));
 

			if (elgg_is_active_plugin('phpmailer'))
				phpmailer_send($to->email, $to->name, $subject, $template, NULL, true );
			else
				mail($to->email, $subject, $template, cp_get_headers());
	


			//echo $template;
			echo "<p>Digest sent to user email: {$to->email} ({$to->guid})</p>";

			//echo "<br/><br/>";
			echo $template;

			// TODO: authenticate cronjobs - since crons dont have a valid admin login, thhis portion fails
			// temporarily strip the access
			$ia = elgg_set_ignore_access(true);

			// clean up the newsletter
			$newsletter_object->description = json_encode(array());
			$newsletter_object->save();

			// see above comment about access
			elgg_set_ignore_access($ia);
		}
	}
}


/**
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


/**
 * cp_send_new_password_request
 *
 * In order to modify core code, this action had to be overwritten.
 * This is a mirror image of the core function: /engine/classes/Elgg/PasswordService.php
 *
 * Only need to send an e-mail notification out, no need to send a site-mail
 */
function cp_send_new_password_request($user) {
	if (!$user instanceof ElggUser)
		return false;

	// generate code
	$code = generate_random_cleartext_password();
	$user->setPrivateSetting('passwd_conf_code', $code);
	$user->setPrivateSetting('passwd_conf_time', time());

	// generate link
	$link = elgg_get_site_url()."changepassword?u={$user->guid}&c={$code}";

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
 * intercepts all email and stops emails from sending
 *
 */
function cpn_email_handler_hook($hook, $type, $notification, $params) {
	return false;
}


/**
 * this is where the bell icon is implemented
 *
 * @param - 	$hook
 */
function notify_entity_menu_setup($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$do_not_subscribe_list = array('comment','discussion_reply','widget');
	if (elgg_in_context('widgets') || in_array($entity->getSubtype(), $do_not_subscribe_list))  return $return;

	// cyu - check for everything to put the bell thingy (xor)
	$allow_subscription = false;
	if ( $entity->getContainerEntity() instanceof ElggGroup ) {
		$allow_subscription = ($entity->getContainerEntity()->isMember(elgg_get_logged_in_user_entity()) == 1 ) ? true : false;

	} else if ($entity instanceof ElggGroup) {
		$allow_subscription =  ($entity->isMember(elgg_get_logged_in_user_entity()) == 1 ) ? true : false;

	} else if ( $entity->getContainerEntity() instanceof ElggUser )
		$allow_subscription = true;

		if($entity instanceof ElggGroup){
			$entType = 'group';
			if($entity->title3){
					$entName = gc_explode_translation($entity->title3, get_current_language());
			}else{
					$entName = $entity->name;
			}
		} else {
			if(!in_array($entity->getSubtype(), array('comment', 'discussion_reply', 'thewire'))){
				if($entity->title3){
						$entName = gc_explode_translation($entity->title3, get_current_language());
				}else{
						$entName = $entity->title;
				}
			} else {
				$entName = $entity->getOwnerEntity()->name;
			}
			$entType = $entity->getSubtype();
		}

	if ($allow_subscription && elgg_is_logged_in()) {
	    if ( check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $entity->getGUID()) || check_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $entity->getGUID()) ) {


			$bell_status = (elgg_is_active_plugin('wet4')) ? '<i class="icon-unsel fa fa-lg fa-bell"><span class="wb-inv">'.elgg_echo('entity:unsubscribe:link:'.$entType, array($entName)).'</span></i>' : elgg_echo('cp_notify:stop_subscribe');


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

		    $bell_status = (elgg_is_active_plugin('wet4')) ? '<i class="icon-unsel fa fa-lg fa-bell-slash-o"><span class="wb-inv">'.elgg_echo('entity:subscribe:link:'.$entType, array($entName)).'</span></i>' : elgg_echo('cp_notify:start_subscribe');


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

<?php
 
/**
 * cyu - 04/30/2015: Revamping the whole module, cleaning up the manifest.xml
 *
 */

elgg_register_event_handler('init', 'system', 'c_notification_messages');

function c_notification_messages() {

	// registers then loads the library for this module
	elgg_register_library('c_notify_msg', elgg_get_plugins_path().'c_notification_messages/lib/functions.php');
	elgg_load_library('c_notify_msg');

	$action_path = elgg_get_plugins_path().'c_notification_messages/actions';

	// require html_email_handler module
	if (elgg_is_active_plugin('html_email_handler') || elgg_get_plugin_setting("notifications","html_email_handler") == "yes") {
		set_view_location("html_email_handler/notification/body", elgg_get_plugins_path().'c_notification_messages/views/');
		register_notification_handler("email", "c_html_email_handler_notification_handler");
	} else {
		// cyu - must change the notification handler so it doesn't send out blank emails etc
		//unregister_notification_handler('email');
		register_notification_handler('email', 'c_email_notify_handler');
	}
	
	// TODO: remove the cron option within the forms from the even calendar
	// elgg_unregister_plugin_hook_handler('cron','fiveminute','event_calendar_handle_reminders_cron');
	// elgg_register_plugin_hook_handler('cron','fiveminute','c_event_calendar_handle_reminders_cron',400);

	elgg_register_action('comments/add',"$action_path/comments/add.php");
	
	if (elgg_is_active_plugin('likes')) elgg_register_action('likes/add',"$action_path/likes/add.php");
	if (elgg_is_active_plugin('groups')) {
		elgg_register_action('groups/addtogroup',"$action_path/groups/membership/add.php");
		elgg_register_action('groups/invite',"$action_path/groups/membership/invite.php");
		elgg_register_action("groups/join", "$action_path/groups/membership/join.php");
	}
	if (elgg_is_active_plugin('tidypics')) {
		elgg_register_action('photos/image/ajax_upload_complete',"$action_path/photos/image/ajax_upload_complete.php",'logged_in');
		elgg_register_action('photos/image/upload',"$action_path/photos/image/upload.php");
		elgg_register_action('photos/album/save',"$action_path/photos/album/save.php");
		elgg_register_action('photos/image/tag',"$action_path/photos/image/tag.php");
		elgg_unregister_plugin_hook_handler('notify:entity:message', 'object', 'tidypics_notify_message');
    	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'c_tidypics_notify_message');
	}

	if (elgg_is_active_plugin('messageboard')) elgg_register_action("messageboard/add", "$action_path/messageboard/add.php");
	if (elgg_is_active_plugin('messages')) elgg_register_action("messages/send","$action_path/messages/send.php");

	elgg_register_action('useradd',"$action_path/user/useradd.php",'admin');
	elgg_register_action('user/requestnewpassword',"$action_path/user/requestnewpassword.php",'public');
	elgg_register_action('user/passwordreset',"$action_path/user/passwordreset.php",'public');
	elgg_register_action('admin/user/resetpassword', "$action_path/admin/resetpassword.php");

    // module: blog
    if (elgg_is_active_plugin('blog')) {
		elgg_register_action('blog/save',"$action_path/blog/save.php");
		elgg_unregister_plugin_hook_handler('notify:entity:message','object','blog_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message','object','c_blog_notify_message');
 	}

 	// module: bookmarks
 	if (elgg_is_active_plugin('bookmarks')) {
		register_notification_object('object','bookmarks',elgg_echo('bookmarks:new'));
		elgg_unregister_plugin_hook_handler('notify:entity:message','object','bookmarks_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message','object','c_bookmarks_notify_message');
	}

	// module: event calendar
	if (elgg_is_active_plugin('event_calendar')) {
		register_notification_object('object','event_calendar',elgg_echo('event_calendar:new_event'));
		elgg_register_plugin_hook_handler('notify:entity:message','object','c_event_notify_message');
		elgg_register_action("event_calendar/request_personal_calendar","$action_path/event_calendar/request_personal_calendar.php");
	}

	// module: advanced notifications
	if (elgg_is_active_plugin('advanced_notifications')) {
		elgg_unregister_plugin_hook_handler("notify:annotation:subject", "group_topic_post", "advanced_notifications_discussion_reply_subject_hook");
		elgg_register_plugin_hook_handler("notify:annotation:subject", "group_topic_post", "c_advanced_notifications_discussion_reply_subject_hook");
	}

	// module: groups
	if (elgg_is_active_plugin('groups')) {
		elgg_unregister_plugin_hook_handler('notify:annotation:message','group_topic_post','discussion_create_reply_notification');
		elgg_register_plugin_hook_handler('notify:annotation:message','group_topic_post','c_discussion_create_reply_notification');
		register_notification_object('object', 'groupforumtopic', elgg_echo('discussion:notification:topic:subject'));
	}
	
	// module: messages
	if (elgg_is_active_plugin('messages')) {
		elgg_unregister_plugin_hook_handler('notify:entity:message', 'object', 'groupforumtopic_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message','object','c_groupforumtopic_notify_message');
	}

	// module: file
	if (elgg_is_active_plugin('file')) {
		elgg_unregister_plugin_hook_handler('notify:entity:message', 'object', 'file_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'c_file_notify_message');
	}

	// module: pages
	if (elgg_is_active_plugin('pages')) {
		elgg_unregister_plugin_hook_handler('notify:entity:message','object','page_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message','object','c_page_notify_message');
	}

	// module: tasks
	if (elgg_is_active_plugin('tasks')) {
		elgg_unregister_plugin_hook_handler('notify:entity:message','object','task_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message','object','c_task_notify_message');
	}
	
	// module: friend request
	// cyu - 04/28/2015: check if friend_request is installed and activated
	if (elgg_is_active_plugin('friend_request')) {
		// cyu - 04/28/2015: if friend_request is installed, unregister the function and put mine in
		elgg_register_event_handler("create", "friendrequest", "c_friend_request_event_create_friendrequest");
		elgg_register_action("friend_request/approve", "$action_path/friends/approve.php");
	} else {
		// cyu - 04/28/2015: else unregister core function and put mine in
		elgg_unregister_event_handler('create','friend','relationship_notification_hook');
		elgg_register_event_handler('create','friend','c_relationship_notification_hook'); 
	}
	elgg_register_action("friends/add", "$action_path/friends/add.php");	// cyu - 04/30/2015: overwrites the friend requesting stuff

	// module: wire
	if (elgg_is_active_plugin('thewire')) {
		elgg_register_action("thewire/add", "$action_path/thewire/add.php");
		elgg_unregister_plugin_hook_handler('notify:entity:message', 'object', 'thewire_notify_message');
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'c_thewire_notify_message');
	}

	// disables a user upon registration
	if (elgg_is_active_plugin('uservalidationbyemail')) {
		elgg_unregister_plugin_hook_handler('register','user','uservalidationbyemail_disable_new_user');
		elgg_register_plugin_hook_handler('register','user','c_uservalidationbyemail_disable_new_user');
		elgg_register_action('uservalidationbyemail/resend_validation', "$action_path/uservalidationbyemail/resend_validation.php", 'admin');
	}

	// other notifications
	if (elgg_action_exists('invitefriends/invite'))	{
		elgg_unregister_action('invitefriends/invite');
		elgg_register_action('invitefriends/invite',"$action_path/invitefriends/invite.php");
	}
	
	if (elgg_is_active_plugin('group_tools')) {
		elgg_unregister_event_handler("create", "membership_request", "group_tools_membership_request");
		elgg_register_event_handler("create", "membership_request", "c_group_tools_membership_request");
		elgg_register_action('group_tools/mail',"$action_path/group_tools/mail.php");
		elgg_register_action("group_tools/admin_transfer", "$action_path/group_tools/admin_transfer.php");
	}

	// cyu - 01/29/2015: need to overwrite the pam_handler so that users who forgot to validate will receive proper email
 	unregister_pam_handler('uservalidationbyemail_check_auth_attempt');
	register_pam_handler('c_uservalidationbyemail_check_auth_attempt', "required");
}

// function c_event_calendar_handle_reminders_cron() {
// 	elgg_load_library('c_notify_msg');
// 	c_event_calendar_queue_reminders();
// }


function c_html_email_handler_notification_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL){
	
	if (!$from) {
		$msg = elgg_echo("NotificationException:MissingParameter", array("from"));
		throw new NotificationException($msg);
	}

	if (!$to) {
		$msg = elgg_echo("NotificationException:MissingParameter", array("to"));
		throw new NotificationException($msg);
	}

	if ($to->email == "") {
		$msg = elgg_echo("NotificationException:NoEmailAddress", array($to->guid));
		throw new NotificationException($msg);
	}

	if (!$subject || $subject == '') {
		$msg = elgg_echo('NotificationException:MissingParameter', array('subject'));
		throw new NotificationException($msg);
	}

	// To
	$to = html_email_handler_make_rfc822_address($to);

	// From
	$site = elgg_get_site_entity();
	// If there's an email address, use it - but only if its not from a user.
	if (!($from instanceof ElggUser) && !empty($from->email)) {
	    $from = html_email_handler_make_rfc822_address($from);
	} elseif (!empty($site->email)) {
	    // Use email address of current site if we cannot use sender's email
	    $from = html_email_handler_make_rfc822_address($site);
	} else {
		// If all else fails, use the domain of the site.
		if(!empty($site->name)){
			$name = $site->name;
			if (strstr($name, ',')) {
				$name = '"' . $name . '"'; // Protect the name with quotations if it contains a comma
			}
			
			$name = '=?UTF-8?B?' . base64_encode($name) . '?='; // Encode the name. If may content nos ASCII chars.
			$from = $name . " <noreply@" . get_site_domain($site->getGUID()) . ">";
		} else {
			$from = "noreply@" . get_site_domain($site->getGUID());
		}
	}
	
	// generate HTML mail body
	$html_message = html_email_handler_make_html_body($subject, $message);

	// set options for sending
	$options = array(
		"to" => $to,
		"from" => $from,
		"subject" => '=?UTF-8?B?' . base64_encode($subject) . '?=',
		"html_message" => $html_message,
		"plaintext_message" => $message
	);
	
	if(!empty($params) && is_array($params)){
		$options = array_merge($options, $params);
	}
	
	return html_email_handler_send_email($options);
}





/**
 * Send a notification via email.
 *
 * @param ElggEntity $from    The from user/site/object
 * @param ElggUser   $to      To which user?
 * @param string     $subject The subject of the message.
 * @param string     $message The message body
 * @param array      $params  Optional parameters (none taken in this instance)
 *
 * @return bool
 * @throws NotificationException
 * @access private
 */
function c_email_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL) {

	global $CONFIG;

	if (!$from) {
		$msg = elgg_echo('NotificationException:MissingParameter', array('from'));
		throw new NotificationException($msg);
	}

	if (!$to) {
		$msg = elgg_echo('NotificationException:MissingParameter', array('to'));
		throw new NotificationException($msg);
	}

	if ($to->email == "") {
		$msg = elgg_echo('NotificationException:NoEmailAddress', array($to->guid));
		throw new NotificationException($msg);
	}

	if (!$subject || $subject == '') {
		$msg = elgg_echo('NotificationException:MissingParameter', array('subject'));
		throw new NotificationException($msg);
	}

	// To
	$to = $to->email;

	// From
	$site = elgg_get_site_entity();
	// If there's an email address, use it - but only if its not from a user.
	if (!($from instanceof ElggUser) && $from->email) {
		$from = $from->email;
	} else if ($site && $site->email) {
		// Use email address of current site if we cannot use sender's email
		$from = $site->email;
	} else {
		// If all else fails, use the domain of the site.
		$from = 'noreply@' . get_site_domain($CONFIG->site_guid);
	}

	return elgg_send_email($from, $to, $subject, $message);
}

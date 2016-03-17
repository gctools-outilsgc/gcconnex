<?php
/**
* Ssend a message action
* 
* @package ElggMessages
*/

$subject = strip_tags(get_input('subject'));
$body = get_input('body');
$recipient_username = get_input('recipient_username');
$original_msg_guid = (int)get_input('original_guid');

elgg_make_sticky_form('messages');

if (!$recipient_username) {
	register_error(elgg_echo("messages:user:blank"));
	forward("messages/compose");
}

if ($recipient_username == elgg_get_logged_in_user_entity()->username) {
	register_error(elgg_echo("messages:user:self"));
	forward("messages/compose");	
}

$user = get_user_by_username($recipient_username);
if (!$user) {
	register_error(elgg_echo("messages:user:nonexist"));
	forward("messages/compose");
}

// Make sure the message field, send to field and title are not blank
if (!$body || !$subject) {
	register_error(elgg_echo("messages:blank"));
	forward("messages/compose");
}

// cyu - 03/16/2016: modified to improve notifications
if (elgg_is_active_plugin('cp_notifications')) {
	$from_user = elgg_get_logged_in_user_entity();
	$message = array(
		'cp_topic_author' => $from_user->guid,
		'cp_topic_title' => $subject,
		'cp_topic_description' => $body,
		'cp_msg_type' => 'cp_site_msg_type',
		'cp_topic_url' => elgg_get_site_url().'/messages/inbox/',
		);
	$template = elgg_view('cp_notifications/email_template', $message);
	
	$subject = elgg_echo('cp_notify:subject:site_message',array($from_user->name,$subject));
	$result = messages_send($subject, $template, $user->guid, 0, $original_msg_guid);
} else 
	// Otherwise, 'send' the message 
	$result = messages_send($subject, $body, $user->guid, 0, $original_msg_guid);



// Save 'send' the message
if (!$result) {
	register_error(elgg_echo("messages:error"));
	forward("messages/compose");
}

elgg_clear_sticky_form('messages');
	
system_message(elgg_echo("messages:posted"));

forward('messages/inbox/' . elgg_get_logged_in_user_entity()->username);

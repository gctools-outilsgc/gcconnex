<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action sends a message to the given user or set of users.
 */
$recipient_string = get_input('recipients');
$subject = get_input('subject');
$body = get_input('body');

// Turns the string input into an array of given users.
$recipient_array = array_filter(explode(',', str_replace(', ', ',', $recipient_string)));
$err = '';

if(count($recipient_array) == 0) {
	$err .= elgg_echo('missions:error:no_recipients_entered') . "\n";
}
else {
	$count = 0;
	foreach($recipient_array as $recipient) {
		$user = get_user_by_username($recipient);
		if($user == '') {
			$err .= elgg_echo('missions:error:username_does_not_exist', array($recipient)) . "\n";
		}
		else {
			// Messaging yourself is not allowed.
			if($user->guid == elgg_get_logged_in_user_guid()) {
				$err .= elgg_echo('missions:error:cannot_message_yourself') . "\n";
			}
			else {
				$count++;
				mm_notify_user($user->guid, elgg_get_logged_in_user_guid(), $subject, nl2br($body));
			}
		}
	}
	
	// This let's the user know how many of their messages went out.
	if(count($recipient_array) > 1) {
		system_message(elgg_echo('missions:number_of_messages_processed', array($count, count($recipient_array))));
	}
	else {
		if($err == '') {
			system_message(elgg_echo('missions:succesfully_shared'));
		}
	}
}

if($err != '') {
	register_error($err);
	forward(REFERER);
}
else {
	forward(elgg_get_site_url() . 'missions/main');
}
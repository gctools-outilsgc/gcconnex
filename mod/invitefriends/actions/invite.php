<?php

/**
 * Elgg invite friends action
 *
 * @package ElggInviteFriends
 */

elgg_make_sticky_form('invitefriends');

if (!elgg_get_config('allow_registration')) {
	register_error(elgg_echo('invitefriends:registration_disabled'));
	forward(REFERER);
}

$site = elgg_get_site_entity();

$emails = json_decode(get_input('emails'));
$emailmessage = get_input('emailmessage');

if (!is_array($emails) || count($emails) == 0) {
	register_error(elgg_echo('invitefriends:noemails'));
	forward(REFERER);
}

$current_user = elgg_get_logged_in_user_entity();

if (elgg_is_active_plugin('gcRegistration_invitation')) {
	$data = array('inviter' => $current_user->guid, 'emails' => $emails);
	elgg_trigger_plugin_hook('gcRegistration_email_invitation', 'all', $data);
}

$error = FALSE;
$bad_emails = array();
$already_members = array();
$sent_total = 0;
foreach ($emails as $email) {

	$email = trim($email);
	if (empty($email)) {
		continue;
	}

	// send out other email addresses
	if (!is_email_address($email)) {
		$error = TRUE;
		$bad_emails[] = $email;
		continue;
	}

	if (get_user_by_email($email)) {
		$error = TRUE;
		$already_members[] = $email;
		continue;
	}

	$link = elgg_get_site_url() . 'register?' . http_build_query(array(
		'friend_guid' => $current_user->guid,
		'invitecode' => generate_invite_code($current_user->username),
	));
	$message = elgg_echo('invitefriends:email', array(
		$site->name,
		$current_user->name,
		$emailmessage,
		$link,
	));

	$subject = elgg_echo('invitefriends:subject', array($site->name));

	// create the from address
	$site = get_entity($site->guid);
	if ($site && $site->email) {
		$from = $site->email;
	} else {
		$from = 'noreply@' . $site->getDomain();
	}

	if (elgg_is_active_plugin('cp_notifications')) {
		$from_user = elgg_get_logged_in_user_entity();
		$message = array(
			'cp_from' => $current_user,
			'cp_msg_type' => 'cp_friend_invite',
			'cp_email_msg' => $emailmessage,
			'cp_join_url' => $link,
			'cp_to' => $email,
		);
		$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
	} else {
		elgg_send_email($from, $email, $subject, $message);
	}
	$sent_total++;
}

if ($error) {
	register_error(elgg_echo('invitefriends:invitations_sent', array($sent_total)));

	if (count($bad_emails) > 0) {
		register_error(elgg_echo('invitefriends:email_error', array(implode(', ', $bad_emails))));
	}

	if (count($already_members) > 0) {
		register_error(elgg_echo('invitefriends:already_members', array(implode(', ', $already_members))));
	}

} else {
	elgg_clear_sticky_form('invitefriends');
	system_message(elgg_echo('invitefriends:success'));
}

forward(REFERER);

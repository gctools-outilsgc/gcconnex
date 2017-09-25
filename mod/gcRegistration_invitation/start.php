<?php

elgg_register_event_handler('init', 'system', 'gcRegistration_invitation_init');

function gcRegistration_invitation_init() {
	elgg_register_plugin_hook_handler('gcRegistration_email_invitation', 'all', 'gcRegistration_email_invitation_hook');
	elgg_register_plugin_hook_handler('gcRegistration_invitation_register', 'all', 'gcRegistration_invitation_register_hook');
}

/*
 * gcRegistration_email_invitation_hook
 * This hook will add email invitation data to the `email_invitations` DB table to allow specific email addresses to register
 */
function gcRegistration_email_invitation_hook($hook, $type, $value, $params) {
	$inviter = $params['inviter'];
	$emails = $params['emails'];
	foreach ($emails as $email) {
		$email = strtolower(trim($email));
		$sql = "INSERT INTO email_invitations (email, inviter, time_sent) VALUES ('" . $email . "', '" . $inviter . "',  UNIX_TIMESTAMP(NOW()))";
		$result = mysql_query($sql);
	}
}

/*
 * gcRegistration_invitation_register_hook
 * This hook will add email invitation data to the `email_invitations` DB table after user has completed registration
 */
function gcRegistration_invitation_register_hook($hook, $type, $value, $params) {
	$invitee = $params['invitee'];
	$email = strtolower(trim($params['email']));

	$sql = "UPDATE email_invitations SET invitee = '" . $invitee . "', time_accepted = UNIX_TIMESTAMP(NOW()) WHERE email = '" . $email . "'";
	$result = mysql_query($sql);
}

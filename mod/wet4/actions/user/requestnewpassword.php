<?php
/**
 * Action to request a new password.
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */

$username = get_input('username');

// allow email addresses
if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
	$username = $users[0]->username;
}

$user = get_user_by_username($username);
if ($user) {

	// cyu - 04/01/2016: use the hook to manage notification (if plugin is activated) / do we need to change core?
	if (elgg_is_active_plugin('cp_notifications')) {
		
		$message = array( // this is a special case, we will have a function built in cp_notification to generate some keys
			'cp_msg_type' => 'cp_forgot_password',
			'cp_user_pass_req_guid' => $user->guid
		);

		$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
		$result = true; // what does elgg_trigger_plugin_hook return?
	} else {
		$result = send_new_password_request($user->guid);
	}

	//if (send_new_password_request($user->guid)) {
	if ($result) {
		system_message(elgg_echo('user:password:changereq:success'));
        forward('/login');
	} else {
		register_error(elgg_echo('user:password:changereq:fail'));
        forward('/forgotpassword');
	}

} else {
	register_error(elgg_echo('user:username:notfound', array($username)));
    forward('/forgotpassword');
}

//forward(current_page_url());
forward('/login');

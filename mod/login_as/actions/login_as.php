<?php
/**
 * Login as the specified user
 *
 * Sets a flag in the session to let us know who the originally logged in user is.
 */

$user_guid = get_input('user_guid', 0);
$original_user = elgg_get_logged_in_user_entity();
$original_user_guid = $original_user->guid;

if (!$user = get_entity($user_guid)) {
	register_error(elgg_echo('login_as:unknown_user'));
	forward(REFERER);
}

// store the original persistent login state to restore on logout_as.
$persistent = FALSE;
if (isset($_COOKIE['elggperm'])) {
	$code = $_COOKIE['elggperm'];
	$code = md5($code);
	if (($original_perm_user = get_user_by_code($code)) && $original_user->guid == $original_perm_user->guid) {
		$persistent = TRUE;
	}
}

$session = elgg_get_session();
$session->set('login_as_original_user_guid', $original_user_guid);
$session->set('login_as_original_persistent', $persistent);

try {
	login($user);
	system_message(elgg_echo('login_as:logged_in_as_user', array($user->username)));
} catch (Exception $exc) {
	$session->remove('login_as_original_user_guid');
	$session->remove('login_as_original_persistent');

	register_error(elgg_echo('login_as:could_not_login_as_user', array($user->username)));

	try {
		login($original_user);
	} catch (Exception $ex) {
		// we can't log back in as ourselves?  just leave us logged out then...
	}
}

forward(REFERER);

<?php
/**
 * Logout as the current user, back to the original user.
 */

$session = elgg_get_session();

$user_guid = $session->get('login_as_original_user_guid');
$user = get_entity($user_guid);

$persistent = $session->get('login_as_original_persistent');

if (!$user instanceof ElggUser || !$user->isadmin()) {
	register_error(elgg_echo('login_as:unknown_user'));
} else {
	if (login($user, $persistent)) {
		$session->remove('login_as_original_user_guid');
		$session->remove('login_as_original_persistent');

		system_message(elgg_echo('login_as:logged_in_as_user', array($user->username)));
	} else {
		register_error(elgg_echo('login_as:could_not_login_as_user', array($user->username)));
	}
}

forward(REFERER);

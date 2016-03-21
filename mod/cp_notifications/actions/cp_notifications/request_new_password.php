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
	if (cp_send_new_password($user->guid)) {
		system_message(elgg_echo('user:password:changereq:success'));
	} else {
		register_error(elgg_echo('user:password:changereq:fail'));
	}
} else {
	register_error(elgg_echo('user:username:notfound', array($username)));
}

forward();


// same exact function taken from core
function cp_send_new_password($user_guid) {
	$user_guid = (int)$user_guid;

	$user = _elgg_services()->entityTable->get($user_guid);
	if (!$user instanceof \ElggUser) {
		return false;
	}

	// generate code
	$code = generate_random_cleartext_password();
	$user->setPrivateSetting('passwd_conf_code', $code);
	$user->setPrivateSetting('passwd_conf_time', time());

	// generate link
	$link = _elgg_services()->config->getSiteUrl() . "changepassword?u=$user_guid&c=$code";

	// generate email
	$ip_address = _elgg_services()->request->getClientIp();
	$message = _elgg_services()->translator->translate(
		'email:changereq:body', array($user->name, $ip_address, $link), $user->language);
	$subject = _elgg_services()->translator->translate(
		'email:changereq:subject', array(), $user->language);

	$message = array(
		'cp_password_requester' => $user,
		'cp_requester_ip' => $ip_address,
		'cp_password_request_url' => $link,
		'cp_msg_type' => 'cp_forgot_password'
	);
	$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);

	return $return;
	//return notify_user($user->guid, elgg_get_site_entity()->guid, $subject, $message, array(), 'email');
}
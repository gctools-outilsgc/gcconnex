<?php
/**
 * This procedure handles the confirmation url when requesting an email change
 *
 * Expected input is:
 * u: for the user_guid
 * c: for the validation code
 */

elgg_gatekeeper();

$user_guid = (int) get_input('u');
$validation_code = get_input('c');

if (empty($user_guid) || empty($validation_code)) {
	register_error(elgg_echo('error:missing_data'));
	forward();
}

$user = get_user($user_guid);
if (empty($user)) {
	register_error(elgg_echo('error:missing_data'));
	forward();
}

$logged_in_user = elgg_get_logged_in_user_entity();

if (($logged_in_user->getGUID() !== $user->getGUID()) || !$user->canEdit()) {
	register_error(elgg_echo('email_change_confirmation:error:user'));
	forward();
}

$new_email = $user->getAnnotations(array(
	'annotation_name' => 'email_change_confirmation',
));
if (empty($new_email)) {
	register_error(elgg_echo('email_change_confirmation:error:request'));
	forward();
}

$new_email = $new_email[0]->value;
$valid_code = generate_email_code($user, $new_email);
if ($validation_code !== $valid_code) {
	register_error(elgg_echo('email_change_confirmation:error:code'));
	forward();
}
$site = elgg_get_site_entity();

// send confirmation to old email that change occured
$subject = elgg_echo('email_change_confirmation:success:subject', array($site->name), 'en') . " | " . elgg_echo('email_change_confirmation:success:subject', array($site->name), 'fr');
$message = elgg_echo('email_change_confirmation:success:message', array(
	$user->name,
	$site->name,
));

if( elgg_is_active_plugin('cp_notifications') ){
    $message = elgg_view('cp_notifications/site_template', array("cp_msg_title_en" => $subject, "cp_msg_title_fr" => elgg_echo('email_change_confirmation:request:subject', array($site->name), 'fr'), "cp_msg_description_en" => $message, "cp_msg_description_fr" => elgg_echo('email_change_confirmation:request:message', array($user->name, $site->name, $validation_url), 'fr')));
}

if( elgg_is_active_plugin('phpmailer') ){
    phpmailer_send($user->email, $user->name, $subject, $message);
} else {
    mail($user->email, $subject, $message, cp_get_headers());
}

$user->email = $new_email;
if ($user->save()) {
	$user->deleteAnnotations('email_change_confirmation');
	
	system_message(elgg_echo('email:save:success'));
	forward($user->getURL());
}

register_error(elgg_echo('email:save:fail'));
forward();

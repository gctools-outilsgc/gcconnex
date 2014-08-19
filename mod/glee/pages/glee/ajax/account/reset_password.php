<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . "/engine/start.php");

if (elgg_is_logged_in()) {
	return;
}

$user_guid = get_input('u');
$code = get_input('c');

$user = get_entity($user_guid);

// don't check code here to avoid automated attacks
if (!$user instanceof ElggUser) {
	register_error(elgg_echo('user:passwordreset:unknown_user'));
	forward();
}

$params = array(
	'guid' => $user_guid,
	'code' => $code,
);
$form = elgg_view_form('user/passwordreset', array('class' => 'elgg-form-account'), $params);

$title = elgg_echo('resetpassword');
$content = elgg_view_title(elgg_echo('resetpassword')) . $form;

echo $content;
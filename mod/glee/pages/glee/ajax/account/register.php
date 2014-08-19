<?php

require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . "/engine/start.php");

// check new registration allowed
if (elgg_get_config('allow_registration') == false) {
	return;
}
// only logged out people need to register
if (elgg_is_logged_in()) {
    return;
}

$friend_guid = (int) get_input('friend_guid', 0);
$invitecode  = get_input('invitecode');

$title = elgg_echo("register");

$content = elgg_view_title($title);

// create the registration url - including switching to https if configured
$register_url = elgg_get_site_url() . 'action/register';
if (elgg_get_config('https_login')) {
	$register_url = str_replace("http:", "https:", $register_url);
}
$form_params = array(
	'action' => $register_url,
	'class' => 'elgg-form-account',
);

$body_params = array(
	'friend_guid' => $friend_guid,
	'invitecode' => $invitecode
);
$content .= elgg_view_form('register', $form_params, $body_params);

$content .= elgg_view('help/register');

echo $content;

// <div class="modal-header">
// <a class="close" data-dismiss="modal">×</a>
// <h3>Modal header</h3>
// </div>
// <div class="modal-body">
// <p>One fine body…</p>
// </div>
// <div class="modal-footer">
// <a href="#" class="btn btn-primary">Save changes</a>
// <a href="#" class="btn">Close</a>
// </div>

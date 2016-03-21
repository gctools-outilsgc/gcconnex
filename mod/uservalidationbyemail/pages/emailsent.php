<?php

if (elgg_is_logged_in()) {
	forward('');
}

$session = elgg_get_session();
$email = $session->get('emailsent', '');
if (!$email) {
	forward('');
}
$title = '<div class="clearfix"></div><div class="row alert alert-success"><h1>'.elgg_echo('uservalidationbyemail:emailsent', array($email)).'</h1>';
$body = elgg_view_layout('one_column', array(
	'title' => $title,
	'content' => elgg_echo('uservalidationbyemail:registerok').'</div>',
));
echo elgg_view_page(strip_tags($title), $body);

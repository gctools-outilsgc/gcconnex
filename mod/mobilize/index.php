<?php
/**
 * Elgg mobilize index
 *
 * @package mobilize
 * 
 */

if (elgg_is_logged_in()) {
	forward('activity');
}

$title = elgg_echo('mobilize:pagetitle');

//grab the login form
$login = elgg_view("core/account/login_box");

// lay out the content
$params = array(
	'login' => $login
);
$body = elgg_view_layout('mobilize_index', $params);

echo elgg_view_page($title, $body);


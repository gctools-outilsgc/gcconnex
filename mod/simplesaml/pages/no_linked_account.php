<?php
/**
 * The user tried to login to the site by a SAML/CAS source but no linked account was found. Offer
 * the option to link or create an account
 */

$source = get_input('saml_source');

if (elgg_is_logged_in()) {
	register_error(elgg_echo('simplesaml:error:loggedin'));
	forward();
}

if (empty($source)) {
	register_error(elgg_echo('simplesaml:error:no_source'));
	forward();
}

$label = simplesaml_get_source_label($source);

if (!simplesaml_is_enabled_source($source)) {
	register_error(elgg_echo('simplesaml:error:source_not_enabled', [$label]));
	forward();
}

$session_source = simplesaml_get_from_session('saml_source');
if ($session_source !== $source) {
	register_error(elgg_echo('simplesaml:error:source_mismatch'));
	forward();
}

// cleanup login form
simplesaml_unextend_login_form();
$allow_registration = simplesaml_allow_registration($source);

// prepare page elements
$title_text = elgg_echo('simplesaml:no_linked_account:title', [$label]);

$content = elgg_view('simplesaml/no_linked_account', [
	'saml_source' => $source,
	'allow_registration' => $allow_registration,
]);

// build body
$body = elgg_view_layout('one_column', [
	'title' => $title_text,
	'content' => $content,
]);

// draw page
echo elgg_view_page($title_text, $body);


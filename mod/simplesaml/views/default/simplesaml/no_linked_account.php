<?php
/**
 * The user doesn't (yet) have a linked account in this site.
 * Depending on the plugin settings offer the option to link and register
 */

$source = elgg_extract('saml_source', $vars);
$allow_registration = (bool) elgg_extract('allow_registration', $vars, false);

$label = simplesaml_get_source_label($source);
$login_class = 'pam';

// add a description
echo elgg_format_element('div', ['class' => 'mbm'], elgg_echo('simplesaml:no_linked_account:description', [$label]));

// options available
$login_options = '';

// allow registration
if ($allow_registration) {
	$body_vars = [
		'saml_source' => $source,
	];
	
	// show register box
	$registration_form = elgg_view_form('simplesaml/register', null, $body_vars);
	$login_options .= elgg_view_module('popup', elgg_echo('register'), $registration_form, ['class' => 'pam mbl']);
	
	// show header for if you already have an account
	$login_class .= ' hidden mtm';
	$login_options .= elgg_view('output/url', [
		'href' => '#simplesaml-no-linked-account-login',
		'text' => elgg_echo('simplesaml:no_linked_account:login'),
		'rel' => 'toggle',
	]);
}

// no registration link
$global_registration = elgg_get_config('allow_registration');
elgg_set_config('allow_registration', false);

$login_options .= elgg_view_module('popup', elgg_echo('login'), elgg_view_form('login'), [
	'class' => $login_class,
	'id' => 'simplesaml-no-linked-account-login',
]);

// restore registration settings
elgg_set_config('allow_registration', $global_registration);

echo elgg_format_element('div', ['id' => 'simplesaml-no-linked-account-module-wrapper'], $login_options);

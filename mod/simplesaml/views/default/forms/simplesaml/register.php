<?php

$source = elgg_extract('saml_source', $vars);
$label = simplesaml_get_source_label($source);

$saml_attributes = simplesaml_get_from_session('saml_attributes');

echo elgg_format_element('div', ['class' => 'mbm'], elgg_echo('simplesaml:forms:register:description', [$label]));

// check for missing fields
// we need name and email
if (!elgg_extract('elgg:firstname', $saml_attributes) && !elgg_extract('elgg:lastname', $saml_attributes)) {
	// no name fields, so ask
	$label = elgg_format_element('label', ['for' => 'displayname'], elgg_echo('name'));
	$input = elgg_view('input/text', [
		'name' => 'displayname',
		'id' => 'displayname',
	]);
	
	echo elgg_format_element('div', [], $label . $input);
}

if (!elgg_extract('elgg:email', $saml_attributes)) {
	// no email field, so ask
	$label = elgg_format_element('label', ['for' => 'email'], elgg_echo('email'));
	$input = elgg_view('input/email', [
		'name' => 'email',
		'id' => 'email',
	]);
	
	echo elgg_format_element('div', [], $label . $input);
	
}

$footer = elgg_view('input/hidden', [
	'name' => 'saml_source',
	'value' => $source,
]);
$footer .= elgg_view('input/submit', [
	'value' => elgg_echo('register'),
]);

echo elgg_format_element('div', ['class' => 'elgg-foot'], $footer);

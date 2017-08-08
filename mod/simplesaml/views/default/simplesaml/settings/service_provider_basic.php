<?php
/**
 * Draw a table row to show on the settings page for a Service Provider
 */

$plugin = elgg_extract('plugin', $vars);
$source = elgg_extract('source', $vars);

if (!($plugin instanceof ElggPlugin) || !($source instanceof SimpleSAML_Auth_Source)) {
	return;
}

$first_source = (bool) elgg_extract('first_source', $vars, false);
$enabled = (bool) elgg_extract('enabled', $vars, false);

$source_auth_id = $source->getAuthId();
$source_auth_label = $source_auth_id;

$registration = false;
$auto_create_accounts = false;
$save_attributes = false;
$force_authentication = [];
$remember_me = false;

if (!$first_source) {
	// no default value after the first force checkbox
	$force_authentication['default'] = false;
}

if ($enabled) {
	$source_auth_label = elgg_view('output/url', [
		'text' => $source_auth_id . elgg_view_icon('settings-alt', 'mls'),
		'href' => "#{$source_auth_id}_wrapper",
		'rel' => 'toggle',
	]);
}

if ($plugin->getSetting("{$source_auth_id}_allow_registration")) {
	$registration = true;
}

if ($plugin->getSetting("{$source_auth_id}_auto_create_accounts")) {
	$auto_create_accounts = true;
}

if ($plugin->getSetting("{$source_auth_id}_save_attributes")) {
	$save_attributes = true;
}

if ($plugin->getSetting('force_authentication') == $source_auth_id) {
	$force_authentication['checked'] = true;
}

if ($plugin->getSetting("{$source_auth_id}_remember_me")) {
	$remember_me = true;
}

// add row for source
$content = '';
$content .= '<tr>';
$content .= elgg_format_element('td', ['class' => 'center'], elgg_view('input/checkbox', [
	'name' => "params[{$source_auth_id}_enabled]",
	'value' => '1',
	'checked' => $enabled,
]));
$content .= elgg_format_element('td', [], $source_auth_label);
$content .= elgg_format_element('td', [], elgg_extract('source_type_label', $vars));
$content .= elgg_format_element('td', ['class' => 'center'], elgg_view('input/checkbox', [
	'name' => "params[{$source_auth_id}_allow_registration]",
	'value' => '1',
	'checked' => $registration,
]));
$content .= elgg_format_element('td', ['class' => 'center'], elgg_view('input/checkbox', [
	'name' => "params[{$source_auth_id}_auto_create_accounts]",
	'value' => '1',
	'checked' => $auto_create_accounts,
]));
$content .= elgg_format_element('td', ['class' => 'center'], elgg_view('input/checkbox', [
	'name' => "params[{$source_auth_id}_save_attributes]",
	'value' => '1',
	'checked' => $save_attributes,
]));
$content .= elgg_format_element('td', ['class' => 'center'], elgg_view('input/checkbox', [
	'name' => 'params[force_authentication]',
	'value' => $source_auth_id,
	] + $force_authentication
));
$content .= elgg_format_element('td', ['class' => 'center'], elgg_view('input/checkbox', [
	'name' => "params[{$source_auth_id}_remember_me]",
	'value' => '1',
	'checked' => $remember_me,
]));
$content .= '</tr>';

echo $content;

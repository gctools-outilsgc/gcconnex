<?php
/**
 * More detailed settings for a specific Service Provider
 */

$plugin = elgg_extract('plugin', $vars);
$source_id = elgg_extract('source_id', $vars);
$source_id_type = elgg_extract('source_id_type', $vars);

if (!($plugin instanceof ElggPlugin) || empty($source_id)) {
	return;
}

$auto_link_options = elgg_extract('auto_link_options', $vars);
$access_type_options = elgg_extract('access_type_options', $vars);
$access_matching_options = elgg_extract('access_matching_options', $vars);

$label = simplesaml_get_source_label($source_id);
$title = elgg_echo('simplesaml:settings:sources:configuration:title', [$label]);

$body = '';

// source icon
$icon = elgg_echo('simplesaml:settings:sources:configuration:icon');
$icon .= elgg_view('input/url', [
	'name' => "params[{$source_id}_icon_url]",
	'value' => $plugin->getSetting("{$source_id}_icon_url"),
]);
$icon .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:sources:configuration:icon:description'));
$body .= elgg_format_element('div', [], $icon);

// autolink users based on profile field
$autolink = elgg_echo('simplesaml:settings:sources:configuration:auto_link') . '<br />';
$autolink .= elgg_view('input/dropdown', [
	'name' => "params[{$source_id}_auto_link]",
	'value' => $plugin->getSetting("{$source_id}_auto_link"),
	'options_values' => $auto_link_options,
]);
$autolink .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:sources:configuration:auto_link:description'));
$body .= elgg_format_element('div', [], $autolink);

if ($source_id_type == 'saml') {
	// only SAML sources have this information
	// configure optional external id field
	$external_id = elgg_echo('simplesaml:settings:sources:configuration:external_id');
	$external_id .= elgg_view('input/text', [
		'name' => "params[{$source_id}_external_id]",
		'value' => $plugin->getSetting("{$source_id}_external_id"),
	]);
	$external_id .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:sources:configuration:external_id:description'));
	$body .= elgg_format_element('div', [], $external_id);
}

// advanced access options
$body .= elgg_format_element('h4', ['class' => 'mtm'], elgg_echo('simplesaml:settings:sources:configuration:access'));
$body .= elgg_view('output/longtext', [
	'value' => elgg_echo('simplesaml:settings:sources:configuration:access:description'),
]);

// access matching
$access_matching = elgg_view('input/dropdown', [
	'name' => "params[{$source_id}_access_type]",
	'value' => $plugin->getSetting("{$source_id}_access_type"),
	'options_values' => $access_type_options,
]);

$access_matching .= elgg_view('input/dropdown', [
	'name' => "params[{$source_id}_access_matching]",
	'value' => $plugin->getSetting("{$source_id}_access_matching"),
	'options_values' => $access_matching_options,
	'class' => 'mlm',
]);
$body .= elgg_format_element('div', ['class' => 'mbm'], $access_matching);

// access field
$access_field = elgg_echo('simplesaml:settings:sources:configuration:access_field');
$access_field .= elgg_view('input/text', [
	'name' => "params[{$source_id}_access_field]",
	'value' => $plugin->getSetting("{$source_id}_access_field"),
]);
$access_field .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:sources:configuration:access_field:description'));
$body .= elgg_format_element('div', [], $access_field);

// access field value
$access_value = elgg_echo('simplesaml:settings:sources:configuration:access_value');
$access_value .= elgg_view('input/text', [
	'name' => "params[{$source_id}_access_value]",
	'value' => $plugin->getSetting("{$source_id}_access_value"),
]);
$access_value .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('simplesaml:settings:sources:configuration:access_value:description'));
$body .= elgg_format_element('div', [], $access_value);

echo elgg_view_module('inline', $title, $body, ['id' => "{$source_id}_wrapper", 'class' => 'hidden']);

<?php
/**
 * All plugin settings can be configured by this view
 *
 */

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

// prepare options
$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$personal_access_options = [
	'user_defined' => elgg_echo('questions:settings:access:options:user'),
	ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
	ACCESS_PUBLIC => elgg_echo('PUBLIC'),
];

$group_access_options = [
	'user_defined' => elgg_echo('questions:settings:access:options:user'),
	'group_acl' => elgg_echo('questions:settings:access:options:group'),
	ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
	ACCESS_PUBLIC => elgg_echo('PUBLIC'),
];

// general settings
$general_settings = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:general:close'),
	'#help' => elgg_echo('questions:settings:general:close:description'),
	'name' => 'params[close_on_marked_answer]',
	'value' => $plugin->close_on_marked_answer,
	'options_values' => $noyes_options,
]);

$general_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:general:solution_time'),
	'#help' => elgg_echo('questions:settings:general:solution_time:description'),
	'name' => 'params[site_solution_time]',
	'value' => $plugin->site_solution_time,
	'options' => range(0, 30),
]);

$general_settings .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('questions:settings:general:auto_close_time'),
	'#help' => elgg_echo('questions:settings:general:auto_close_time:description'),
	'name' => 'params[auto_close_time]',
	'value' => $plugin->auto_close_time,
]);

$general_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:general:solution_time_group'),
	'#help' => elgg_echo('questions:settings:general:solution_time_group:description'),
	'name' => 'params[solution_time_group]',
	'value' => $plugin->solution_time_group,
	'options_values' => array_reverse($noyes_options),
]);

$general_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:general:limit_to_groups'),
	'#help' => elgg_echo('questions:settings:general:limit_to_groups:description'),
	'name' => 'params[limit_to_groups]',
	'value' => $plugin->limit_to_groups,
	'options_values' => $noyes_options,
]);

echo elgg_view_module('inline', elgg_echo('questions:settings:general:title'), $general_settings);

// adding expert roles
$expert_settings = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:experts:enable'),
	'#help' => elgg_echo('questions:settings:experts:enable:description'),
	'name' => 'params[experts_enabled]',
	'value' => $plugin->experts_enabled,
	'options_values' => $noyes_options,
]);

$expert_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:experts:answer'),
	'name' => 'params[experts_answer]',
	'value' => $plugin->experts_answer,
	'options_values' => $noyes_options,
]);

$expert_settings .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('questions:settings:experts:mark'),
	'name' => 'params[experts_mark]',
	'value' => $plugin->experts_mark,
	'options_values' => $noyes_options,
]);

echo elgg_view_module('inline', elgg_echo('questions:settings:experts:title'), $expert_settings);

// access options
$access_settings = elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('questions:settings:access:personal'),
	'name' => 'params[access_personal]',
	'value' => $plugin->access_personal,
	'options_values' => $personal_access_options,
]);

$access_settings .= elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('questions:settings:access:group'),
	'name' => 'params[access_group]',
	'value' => $plugin->access_group,
	'options_values' => $group_access_options,
]);

echo elgg_view_module('inline', elgg_echo('questions:settings:access:title'), $access_settings);

<?php
/**
 * All plugin settings can be configured by this view
 *
 */

$plugin = elgg_extract('entity', $vars);

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
$general_settings = '<div>';
$general_settings .= elgg_echo('questions:settings:general:close');
$general_settings .= elgg_view('input/select', [
	'name' => 'params[close_on_marked_answer]',
	'value' => $plugin->close_on_marked_answer,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);
$general_settings .= '<div class="elgg-subtext">' . elgg_echo('questions:settings:general:close:description') . '</div>';
$general_settings .= '</div>';

$general_settings .= '<div>';
$general_settings .= elgg_echo('questions:settings:general:solution_time');
$general_settings .= elgg_view('input/select', [
	'name' => 'params[site_solution_time]',
	'value' => $plugin->site_solution_time,
	'options' => range(0, 30),
	'class' => 'mls',
]);
$general_settings .= '<div class="elgg-subtext">' . elgg_echo('questions:settings:general:solution_time:description') . '</div>';
$general_settings .= '</div>';

$general_settings .= '<div>';
$general_settings .= elgg_echo('questions:settings:general:solution_time_group');
$general_settings .= elgg_view('input/select', [
	'name' => 'params[solution_time_group]',
	'value' => $plugin->solution_time_group,
	'options_values' => array_reverse($noyes_options),
	'class' => 'mls',
]);
$general_settings .= '<div class="elgg-subtext">' . elgg_echo('questions:settings:general:solution_time_group:description') . '</div>';
$general_settings .= '</div>';

$general_settings .= '<div>';
$general_settings .= elgg_echo('questions:settings:general:limit_to_groups');
$general_settings .= elgg_view('input/select',[
	'name' => 'params[limit_to_groups]',
	'value' => $plugin->limit_to_groups,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);
$general_settings .= '<div class="elgg-subtext">' . elgg_echo('questions:settings:general:limit_to_groups:description') . '</div>';
$general_settings .= '</div>';

echo elgg_view_module('inline', elgg_echo('questions:settings:general:title'), $general_settings);

// adding expert roles
$expert_settings = '<div>';
$expert_settings .= elgg_echo('questions:settings:experts:enable');
$expert_settings .= elgg_view('input/select', [
	'name' => 'params[experts_enabled]',
	'value' => $plugin->experts_enabled,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);
$expert_settings .= '<div class="elgg-subtext">' . elgg_echo('questions:settings:experts:enable:description') . '</siv>';
$expert_settings .= '</div>';

$expert_settings .= '<div>';
$expert_settings .= elgg_echo('questions:settings:experts:answer');
$expert_settings .= elgg_view('input/select', [
	'name' => 'params[experts_answer]',
	'value' => $plugin->experts_answer,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);
$expert_settings .= '</div>';

$expert_settings .= '<div>';
$expert_settings .= elgg_echo('questions:settings:experts:mark');
$expert_settings .= elgg_view('input/select', [
	'name' => 'params[experts_mark]',
	'value' => $plugin->experts_mark,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);
$expert_settings .= '</div>';

echo elgg_view_module('inline', elgg_echo('questions:settings:experts:title'), $expert_settings);

// access options
$access_settings = '<div>';
$access_settings .= elgg_echo('questions:settings:access:personal');
$access_settings .= elgg_view('input/access', [
	'name' => 'params[access_personal]',
	'value' => $plugin->access_personal,
	'options_values' => $personal_access_options,
	'class' => 'mls',
]);
$access_settings .= '</div>';

$access_settings .= '<div>';
$access_settings .= elgg_echo('questions:settings:access:group');
$access_settings .= elgg_view('input/access', [
	'name' => 'params[access_group]',
	'value' => $plugin->access_group,
	'options_values' => $group_access_options,
	'class' => 'mls',
]);
$access_settings .= '</div>';

echo elgg_view_module('inline', elgg_echo('questions:settings:access:title'), $access_settings);

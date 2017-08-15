<?php

/**
 * Group Tools
 *
 * Cleanup the group profile sidebar
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup) || !$group->canEdit()) {
	return;
}

$featured_options = [
	'no' => elgg_echo('option:no'),
	1 => 1,
	2 => 2,
	3 => 3,
	4 => 4,
	5 => 5,
	6 => 6,
	7 => 7,
	8 => 8,
	9 => 9,
	10 => 10,
	15 => 15,
	20 => 20,
	25 => 25,
];

$featured_sorting = [
	'time_created' => elgg_echo('group_tools:cleanup:featured_sorting:time_created'),
	'alphabetical' => elgg_echo('sort:alpha'),
];

$prefix = \ColdTrick\GroupTools\Cleanup::SETTING_PREFIX;

$form_body = elgg_format_element('div', ['class' => 'elgg-quiet'], elgg_echo('group_tools:cleanup:description'));

// cleanup extras menu
$form_body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('group_tools:cleanup:extras_menu'),
	'#help' => elgg_echo('group_tools:cleanup:extras_menu:explain'),
	'name' => 'extras_menu',
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($group->getPrivateSetting("{$prefix}extras_menu") === 'yes'),
]);

// hide group actions
$form_body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('group_tools:cleanup:actions'),
	'#help' => elgg_echo('group_tools:cleanup:actions:explain'),
	'name' => 'actions',
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($group->getPrivateSetting("{$prefix}actions") === 'yes'),
]);

// hide owner_block menu items
$form_body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('group_tools:cleanup:menu'),
	'#help' => elgg_echo('group_tools:cleanup:menu:explain'),
	'name' => 'menu',
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($group->getPrivateSetting("{$prefix}menu") === 'yes'),
]);

// hide group search
$form_body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('group_tools:cleanup:search'),
	'#help' => elgg_echo('group_tools:cleanup:search:explain'),
	'name' => 'search',
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($group->getPrivateSetting("{$prefix}search") === 'yes'),
]);

// hide group members
$form_body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('group_tools:cleanup:members'),
	'#help' => elgg_echo('group_tools:cleanup:members:explain'),
	'name' => 'members',
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($group->getPrivateSetting("{$prefix}members") === 'yes'),
]);

// show featured groups
$form_body .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('group_tools:cleanup:featured'),
	'#help' => elgg_echo('group_tools:cleanup:featured:explain'),
	'name' => 'featured',
	'options_values' => $featured_options,
	'value' => $group->getPrivateSetting("{$prefix}featured"),
]);

$form_body .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('group_tools:cleanup:featured_sorting'),
	'name' => 'featured_sorting',
	'options_values' => $featured_sorting,
	'value' => $group->getPrivateSetting("{$prefix}featured_sorting"),
]);

// hide my status
$form_body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('group_tools:cleanup:my_status'),
	'#help' => elgg_echo('group_tools:cleanup:my_status:explain'),
	'name' => 'my_status',
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($group->getPrivateSetting("{$prefix}my_status") === 'yes'),
]);

// footer buttons
$footer = elgg_view('input/hidden', ['name' => 'group_guid', 'value' => $group->getGUID()]);
$footer .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

$form_body .= elgg_format_element('div', ['class' => 'elgg-foot'], $footer);

// make body
$title = elgg_echo('group_tools:cleanup:title');
$body = elgg_view('input/form', [
	'action' => 'action/group_tools/cleanup',
	'body' => $form_body,
]);

// show body
echo elgg_view_module('info', $title, $body);

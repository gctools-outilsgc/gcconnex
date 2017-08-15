<?php

/**
 * Group Tools
 *
 * Here we will show is a group has one or more of the following special states
 * - featured
 * - autojoin
 * - suggested
 *
 * Also these states can be toggled
 *
 * @author ColdTrick IT Solutions
 */

$user = elgg_get_logged_in_user_entity();
if (empty($user) || !$user->isAdmin()) {
	// only for site administrators
	return;
}

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

elgg_require_js('group_tools/group_edit');

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes')
];

$suggested_groups = [];
$suggested_setting = elgg_get_plugin_setting('suggested_groups', 'group_tools');
if (!empty($suggested_setting)) {
	$suggested_groups = string_to_tag_array($suggested_setting);
}

$suggested_value = 'no';
if (in_array($group->getGUID(), $suggested_groups)) {
	$suggested_value = 'yes';
}

$title = elgg_echo('group_tools:special_states:title');

$content = elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:special_states:description'),
]);

// build content
$content .= '<table class="elgg-table mtm">';

// featured group
$content .= '<tr>';
$content .= elgg_format_element('td', [], elgg_echo('group_tools:special_states:featured'));
$content .= elgg_format_element('td', [], elgg_view('input/select', [
	'options_values' => $noyes_options,
	'value' => $group->featured_group,
	'onchange' => "elgg.group_tools.toggle_featured({$group->getGUID()}, this);",
]));
$content .= '</tr>';

// suggested group
$content .= '<tr>';
$content .= elgg_format_element('td', [], elgg_echo('group_tools:special_states:suggested'));
$content .= elgg_format_element('td', [], elgg_view('input/select', [
	'options_values' => $noyes_options,
	'value' => $suggested_value,
	'onchange' => "elgg.group_tools.toggle_special_state('suggested', {$group->getGUID()});",
]));
$content .= '</tr>';

$content .= '</table>';

// draw content
echo elgg_view_module('info', $title, $content);

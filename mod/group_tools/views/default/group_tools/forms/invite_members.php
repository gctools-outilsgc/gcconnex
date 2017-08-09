<?php

/**
 * Group Tools
 *
 * who can invite group members
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_extract('entity', $vars);

if (!($group instanceof ElggGroup) || !$group->canEdit()) {
	return;
}

$setting = elgg_get_plugin_setting('invite_members', 'group_tools');
if (!in_array($setting, ['yes_off', 'yes_on'])) {
	// plugin settings don't allow this
	return;
}

$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$invite_members = $group->invite_members;
if (empty($invite_members)) {
	$invite_members = 'no';
	
	if ($setting === 'yes_on') {
		$invite_members = 'yes';
	}
}

$title = elgg_echo('group_tools:invite_members:title');

// build form
$content = elgg_echo('group_tools:invite_members:description');
$content .= elgg_view('input/select', [
	'name' => 'invite_members',
	'value' => $invite_members,
	'options_values' => $noyes_options,
	'class' => 'mls',
]);

$content .= elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:invite_members:disclaimer'),
	'class' => 'elgg-subtext',
]);

$content .= '<div class="mtm">';
$content .= elgg_view('input/hidden', ['name' => 'group_guid', 'value' => $group->getGUID()]);
$content .= elgg_view('input/submit', ['value' => elgg_echo('save')]);
$content .= '</div>';

// make form
$form = elgg_view('input/form', [
	'action' => 'action/group_tools/invite_members',
	'body' => $content,
]);

// draw content
echo elgg_view_module('info', $title, $form);

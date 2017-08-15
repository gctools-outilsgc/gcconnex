<?php

/**
 * Group Tools
 *
 * Configure a welcome message to send to a new member when he/she joins the group
 *
 * @author ColdTrick IT Solutions
 * 
 */

$group = elgg_extract('entity', $vars);

if (!($group instanceof ElggGroup) || !$group->canEdit()) {
	return;
}

$title = elgg_echo('group_tools:welcome_message:title');

// build form
$form_body = elgg_format_element('div', [], elgg_echo('group_tools:welcome_message:description'));
$form_body .= elgg_view('input/longtext', [
	'name' => 'welcome_message',
	'value' => $group->getPrivateSetting('group_tools:welcome_message'),
]);

$form_body .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:welcome_message:explain', [
		elgg_get_logged_in_user_entity()->name,
		$group->name,
		$group->getURL(),
	]),
]));

$form_body .= '<div class="elgg-foot">';
$form_body .= elgg_view('input/hidden', ['name' => 'group_guid', 'value' => $group->getGUID()]);
$form_body .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

// make form
$content = elgg_view('input/form', [
	'action' => 'action/group_tools/welcome_message',
	'body' => $form_body,
]);

// draw content
echo elgg_view_module('info', $title, $content);

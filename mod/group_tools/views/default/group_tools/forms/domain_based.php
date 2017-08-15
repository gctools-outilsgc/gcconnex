<?php

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup) || !$group->canEdit() || !group_tools_domain_based_groups_enabled()) {
	return;
}

$title = elgg_echo('group_tools:domain_based:title');

// build form
$form_body = elgg_format_element('div', ['class' => 'mbm'], elgg_echo('group_tools:domain_based:description'));

$domains = $group->getPrivateSetting('domain_based');
if (!empty($domains)) {
	$domains = explode('|', trim($domains, '|'));
}

$form_body .= elgg_format_element('div', [], elgg_view('input/tags', [
	'name' => 'domains',
	'value' => $domains,
]));

$form_body .= '<div class="elgg-foot mtm">';
$form_body .= elgg_view('input/hidden', ['name' => 'group_guid', 'value' => $group->getGUID()]);
$form_body .= elgg_view('input/submit', ['value' => elgg_echo('save')]);
$form_body .= '</div>';

// make form
$content = elgg_view('input/form', [
	'action' => 'action/group_tools/domain_based',
	'body' => $form_body,
]);

// show content
echo elgg_view_module('info', $title, $content);

<?php
/**
 * Show a membershiprequest to the group admin
 *
 * @uses $vars['entity'] the ElggUser doing the request
 */

$page_owner = elgg_get_page_owner_entity();
if (!($page_owner instanceof ElggGroup) || !$page_owner->canEdit()) {
	return;
}

$user = elgg_extract('entity', $vars);
if (!($user instanceof ElggUser)) {
	return;
}

$icon = elgg_view_entity_icon($user, 'small');
$menu = elgg_view_menu('group:membershiprequest', [
	'entity' => $user,
	'group' => $page_owner,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
]);

// check for motivation
$motivation = '';
$annotations = $page_owner->getAnnotations([
	'annotation_name' => 'join_motivation',
	'limit' => 1,
	'annotation_owner_guid' => $user->getGUID(),
]);
if (!empty($annotations)) {
	$join_motivation = $annotations[0];
	
	$motivation = elgg_format_element('b', [], elgg_echo('group_tools:join_motivation:listing'));
	$motivation .= elgg_view('output/longtext', [
		'value' => $join_motivation->value,
		'class' => 'mtn',
	]);
	
	$motivation = elgg_format_element('div', [
		'id' => "group-tools-group-membershiprequest-motivation-{$user->getGUID()}",
		'class' => 'hidden',
	], $motivation);
}

$summary = elgg_view('user/elements/summary', [
	'entity' => $user,
	'subtitle' => $user->briefdescription,
	'metadata' => $menu,
	'content' => $motivation,
]);

// allow a reason for the decline
$form_vars = [
	'id' => "group-kill-request-{$user->getGUID()}",
	'data-guid' => $user->getGUID(),
];
$body_vars = [
	'group' => $page_owner,
	'user' => $user,
];
$decline_form = elgg_view_form('groups/killrequest', $form_vars, $body_vars);
$summary .= elgg_format_element('div', ['class' => 'hidden'], $decline_form);

echo elgg_view_image_block($icon, $summary);

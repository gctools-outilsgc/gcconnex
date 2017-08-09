<?php

elgg_require_js('group_tools/killrequest');

$group = elgg_extract('group', $vars);
$user = elgg_extract('user', $vars);

if (!($group instanceof ElggGroup)) {
	return;
}

if (!($user instanceof ElggUser)) {
	return;
}

$content = elgg_view_field([
	'#type' => 'hidden',
	'name' => 'group_guid', 
	'value' => $group->guid,
]);
$content .= elgg_view_field([
	'#type' => 'hidden',
	'name' => 'user_guid', 
	'value' => $user->guid,
]);

$content .= elgg_echo('group_tools:groups:membershipreq:kill_request:prompt');
$content .= elgg_view_field([
	'#type' => 'plaintext',
	'name' => 'reason',
	'rows' => '3',
]);

echo elgg_view_module('info', elgg_echo('groups:joinrequest:remove:check'), $content);

$footer = elgg_view_field([
	'#type' => 'button',
	'value' => elgg_echo('cancel'),
	'class' => 'elgg-button-cancel float-alt',
	'onclick' => '$.colorbox.close();',
]);
$footer .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('decline')
]);

elgg_set_form_footer($footer);

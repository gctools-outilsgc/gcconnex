<?php

$group = elgg_extract('entity', $vars);
$invitations = elgg_extract('invitations', $vars);

if (empty($invitations) || !is_array($invitations)) {
	echo elgg_view('output/longtext', [
		'value' => elgg_echo('group_tools:groups:membershipreq:invitations:none'),
	]);
	return;
}

unset($vars['entity']);
unset($vars['invitations']);
$vars['items'] = $invitations;
$vars['item_view'] = 'group_tools/format/group/invitation';

echo elgg_view('page/components/list', $vars);

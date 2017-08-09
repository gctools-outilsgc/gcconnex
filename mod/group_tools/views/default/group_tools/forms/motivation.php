<?php

$group_guid = (int) get_input('guid');
elgg_entity_gatekeeper($group_guid, 'group');

$group = get_entity($group_guid);

$title = elgg_echo('group_tools:join_motivation:title', [$group->name]);

$content = elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:join_motivation:description', [$group->name]),
]);
$content .= elgg_view_form('group_tools/join_motivation', ['class' => 'mtm'], ['entity' => $group]);

echo elgg_view_module('info', $title, $content);

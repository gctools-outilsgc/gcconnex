<?php

$batch = new ElggBatch('elgg_get_entities', [
	'type' => 'group',
	'limit' => false,
	'wheres' => [
		'e.access_id = ' . ACCESS_PRIVATE,
	],
]);

$output = false;

/* @var $group \ElggGroup */
foreach ($batch as $group) {
	if (!$output) {
		echo elgg_view('output/longtext', [
			'value' => elgg_echo('group_tools:group:admin_approve:admin:description'),
		]);
	}
	$output = true;
	
	$icon = elgg_view_entity_icon($group, 'small');
	
	$params = [
		'entity' => $group,
		'subtitle' => elgg_view('page/elements/by_line', [
			'entity' => $group,
		]),
	];
	$body = elgg_view('group/elements/summary', $params);
	
	$buttons = [];
	$buttons[] = elgg_view('output/url', [
		'text' => elgg_echo('approve'),
		'href' => 'action/group_tools/admin/approve?guid=' . $group->getGUID(),
		'confirm' => true,
		'class' => 'elgg-button elgg-button-action',
	]);
	$buttons[] = elgg_view('output/url', [
		'text' => elgg_echo('decline'),
		'href' => 'action/group_tools/admin/decline?guid=' . $group->getGUID(),
		'confirm' => elgg_echo('group_tools:group:admin_approve:decline:confirm'),
		'class' => 'elgg-button elgg-button-action',
	]);
	
	echo elgg_view_image_block($icon, $body, [
		'image_alt' => implode('', $buttons),
	]);
}

if (!$output) {
	echo elgg_echo('groups:none');
}

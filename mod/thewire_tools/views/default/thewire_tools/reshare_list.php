<?php

$guid = (int) get_input('entity_guid');
if (empty($guid)) {
	return;
}

$batch = new ElggBatch('elgg_get_entities_from_relationship', [
	'type' => 'object',
	'subtype' => 'thewire',
	'relationship_guid' => $guid,
	'relationship' => 'reshare',
	'inverse_relationship' => true,
	'limit' => 99,
]);

$list_items = [];
foreach ($batch as $wire_post) {
	$owner = $wire_post->getOwnerEntity();
	$icon = elgg_view_entity_icon($owner, 'tiny', ['use_hover' => false]);
	
	$owner_link = elgg_view('output/url', [
		'text' => $owner->name,
		'href' => $owner->getURL(),
		'is_trusted' => true,
	]);
	
	$friendly_time = elgg_view_friendly_time($wire_post->time_created);
	$friendly_time = elgg_format_element('span', ['class' =>'elgg-subtext'], $friendly_time);
	
	$text = elgg_echo('thewire_tools:reshare:list', [$owner_link, $friendly_time]);
	
	$block = elgg_view_image_block($icon, $text);
	
	$list_items[] = elgg_format_element('li', ['class' => 'elgg-item'], $block);
}

if (empty($list_items)) {
	return;
}

echo elgg_format_element('ul', ['class' => 'elgg-list thewire-tools-reshare-popup'], implode('', $list_items));
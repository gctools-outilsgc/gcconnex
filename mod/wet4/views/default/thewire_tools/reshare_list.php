<?php

$guid = (int) get_input('entity_guid');
if (empty($guid)) {
	return;
}

$options = array(
	'type' => 'object',
	'subtype' => 'thewire',
	'relationship_guid' => $guid,
	'relationship' => 'reshare',
	'inverse_relationship' => true,
	'limit' => 99,
);
$batch = new ElggBatch('elgg_get_entities_from_relationship', $options);
$list_items = array();
foreach ($batch as $wire_post) {
	$owner = $wire_post->getOwnerEntity();
	$icon = elgg_view_entity_icon($owner, 'tiny', array('use_hover' => false));
	
	$owner_link = elgg_view('output/url', array(
		'text' => $owner->name,
		'href' => $owner->getURL(),
		'is_trusted' => true
	));
	
	$friendly_time = elgg_view_friendly_time($wire_post->time_created);
	$friendly_time = elgg_format_element('span', array('class' =>'elgg-subtext'), $friendly_time);
	
	$text = elgg_echo('thewire_tools:reshare:list', array($owner_link, $friendly_time));
	
	$block = elgg_view_image_block($icon, $text);
	
	$list_items[] = elgg_format_element('li', array('class' => 'elgg-item'), $block);
}

echo elgg_format_element('ul', array('class' => 'elgg-list thewire-tools-reshare-popup'), implode('', $list_items));
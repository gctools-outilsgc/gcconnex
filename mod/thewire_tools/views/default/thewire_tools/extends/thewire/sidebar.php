<?php

$page_owner = elgg_get_page_owner_entity();

$options = [
	'type' => 'object',
	'subtype' => 'thewire',
	'metadata_name' => 'featured',
	'limit' => 5,
];

if ($page_owner instanceof ElggUser) {
	$options['owner_guid'] = $page_owner->getGUID();
} elseif ($page_owner instanceof ElggGroup) {
	$options['container_guid'] = $page_owner->getGUID();
}

$posts = elgg_get_entities_from_metadata($options);
if (empty($posts)) {
	return;
}

$title = elgg_echo('thewire_tools:sidebar:featured');

$content = '';
foreach ($posts as $entity) {
	$icon = elgg_view_entity_icon($entity->getOwnerEntity(), 'tiny');
	
	$byline = elgg_view('page/elements/by_line', [
		'entity' => $entity,
		'owner_url' => "thewire/owner/{$entity->getOwnerEntity()->username}",
	]);
	
	$body = elgg_format_element('div', ['class' => 'elgg-subtext'], $byline);
	$body .= thewire_filter($entity->description);
	$body .= elgg_view('output/url', [
		'text' => elgg_echo('more'),
		'href' => "thewire/thread/{$entity->wire_thread}#elgg-object-{$entity->getGUID()}",
		'is_trusted' => true,
		'class' => 'mls',
	]);
	
	$content .= elgg_view_image_block($icon, $body);
}

echo elgg_view_module('aside', $title, $content);

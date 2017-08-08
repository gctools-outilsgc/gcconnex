<?php
/**
 * Show to what a wire post is linked
 */

$entity = elgg_extract('entity', $vars);

if (!elgg_instanceof($entity, 'object')) {
	return true;
}

$text = '';
if (!empty($entity->title)) {
	$text = $entity->title;
} elseif (!empty($entity->name)) {
	$text = $entity->name;
} elseif (!empty($entity->description)) {
	$text = elgg_get_excerpt($entity->description, 140);
} else {
	// no text to display
	return true;
}

$icon = '';
if ($entity->icontime) {
	$icon = elgg_view_entity_icon($entity, 'tiny');
}

$url = $entity->getURL();
if ($url === elgg_get_site_url()) {
	$url = false;
}

$content = elgg_echo('thewire_tools:reshare:source') . ': ';
if (!empty($url)) {
	$content .= elgg_view('output/url', [
		'href' => $url,
		'text' => $text,
		'is_trusted' => true,
	]);
} else {
	$content .= elgg_view('output/text', ['value' => $text]);
}
$content = elgg_format_element('div', ['class' => 'elgg-subtext'], $content);

echo elgg_view_image_block($icon, $content, ['class' => 'mbn']);

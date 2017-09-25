<?php

$entity = $vars['entity'];
$lang = get_current_language();

$icon = $entity->getVolatileData('search_icon');
if (!$icon) {
	// display the entity's owner by default if available.
	// @todo allow an option to switch to displaying the entity's icon instead.
	$type = $entity->getType();
	if ($type == 'user' || $type == 'group') {
		$icon = elgg_view_entity_icon($entity, 'medium');
	} elseif ($owner = $entity->getOwnerEntity()) {
		$icon = elgg_view_entity_icon($owner, 'medium');
	} else {
		// display a generic icon if no owner, though there will probably be
		// other problems if the owner can't be found.
		$icon = elgg_view_entity_icon($entity, 'medium');
	}
}

$title = gc_explode_translation($entity->getVolatileData('search_matched_title'), $lang);
$description = gc_explode_translation($entity->getVolatileData('search_matched_description'), $lang);
$extra_info = $entity->getVolatileData('search_matched_extra');
$url = $entity->getVolatileData('search_url');

$title = str_replace(array('{"en":"', ',"fr":""}', '\u00a0'), '', $title);
$title = str_replace(array('\n', '\t', '\r'), ' ', $title);
$description = str_replace(array('{"en":"', ',"fr":""}', '\u00a0'), '', $description);
$description = str_replace(array('\n', '\t', '\r'), ' ', $description);

if (!$url) {
	$url = $entity->getURL();
}

$title = "<a href=\"$url\">$title</a>";
$time = $entity->getVolatileData('search_time');
if (!$time) {
	$tc = $entity->time_created;
	$tu = $entity->time_updated;
	$time = elgg_view_friendly_time(($tu > $tc) ? $tu : $tc);
}

$body = "<p class=\"mbn\">$title</p>$description";
if ($extra_info) {
	$body .= "<p class=\"elgg-subtext\">$extra_info</p>";
}
$body .= "<p class=\"elgg-subtext\">$time</p>";

echo elgg_view_image_block($icon, $body);

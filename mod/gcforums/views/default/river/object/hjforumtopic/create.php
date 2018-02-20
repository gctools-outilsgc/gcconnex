<?php
/**
 * Blog river view.
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */
$site = elgg_get_site_entity();

// fixes the url in the activity
$object = $item->getObjectEntity();
if (($object->getSubtype() === 'hjforumtopic' || $object->getSubtype() === 'hjforum') && $object->getURL() === $site->getURL()) {
	$gcforums_url = ($object->getSubtype() === 'hjforumtopic') ? $site->getURL()."gcforums/topic/view/{$object->getGUID()}" : $site->getURL()."gcforums/view/{$entity_guid}";
	$object->setURL($gcforums_url);
}

$excerpt = $object->excerpt ? $object->excerpt : $object->description;
$excerpt = strip_tags($excerpt);
$excerpt = elgg_get_excerpt($excerpt);

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
));

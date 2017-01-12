<?php
/**
 * New bookmarks river entry
 *
 * @package Bookmarks
 */

$lang = get_current_language();
$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();


	$description = gc_explode_translation($object->description3,$lang);


$object = $item->getObjectEntity();
$excerpt = elgg_get_excerpt($description);

echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'message' => $excerpt,
	'attachments' => elgg_view('output/url', array('href' => $object->address)),
));

<?php
/**
 * File river view.
 */

$lang = get_current_language();
$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();


	$description = gc_explode_translation($object->description,$lang);


$excerpt = strip_tags($description);
$excerpt = elgg_get_excerpt($excerpt);

echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'message' => $excerpt,
));
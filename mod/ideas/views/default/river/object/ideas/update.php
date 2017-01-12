<?php
/**
 * Update idea river entry
 *
 * @package ideas
 */

$lang = get_current_language();
$object = $vars['item']->getObjectEntity();


	$description = gc_explode_translation($object->description,$lang);


$excerpt = elgg_get_excerpt($description, '140');

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt
));
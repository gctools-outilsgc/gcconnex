<?php
/**
 * New idea river entry
 *
 * @package ideas
 */

$object = $vars['item']->getObjectEntity();
$lang = get_current_language();


	$description = gc_explode_translation($object->description,$lang);


$excerpt = elgg_get_excerpt($description, '140');
echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt
));

<?php
/**
 * Update idea river entry
 *
 * @package ideas
 */

$lang = get_current_language();
$object = $vars['item']->getObjectEntity();

if($object->description3){
	$description = gc_explode_translation($object->description3,$lang);
}else{
	if($object->description1){
		$object->description = $object->description1;
	}
	$description = $object->description;
}

$excerpt = elgg_get_excerpt($description, '140');

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt
));
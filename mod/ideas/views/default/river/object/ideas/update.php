<?php
/**
 * Update idea river entry
 *
 * @package ideas
 */

$object = $vars['item']->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description, '140');

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt
));

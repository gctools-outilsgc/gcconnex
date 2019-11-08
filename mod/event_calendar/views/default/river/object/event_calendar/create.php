<?php

/**
 * Event calendar river view.
 */

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$vars['excerpt'] = elgg_get_excerpt($excerpt);

echo elgg_view('page/components/image_block', array(
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'elgg-river-item',
));
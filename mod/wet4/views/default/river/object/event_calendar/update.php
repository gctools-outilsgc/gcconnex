<?php
/*
 * GC_MODIFICATION
 * Description: Add panel class
 * Author: GCTools Team
*/


$object = $vars['item']->getObjectEntity();

echo elgg_view('page/components/river_image_block', array(
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'panel panel-river',
));

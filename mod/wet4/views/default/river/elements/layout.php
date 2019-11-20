<?php
/**
 * Layout of a river item
 *
 * @uses $vars['item'] ElggRiverItem
 *
 * GC_MODIFICATION
 * Description: Added wet and bootstrap classes and style.
 * Author: Nick github.com/piet0024
 */

$item = $vars['item'];

echo elgg_view('page/components/river_image_block', array(
	'image' => elgg_view('river/elements/image', $vars),
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'col-xs-12  panel panel-river',
));

<?php

/**
 * Event calendar river view.
 *
 * GC_MODIFICATION
 * Description: panel class
 * Author: GCTools Team
 */

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$vars['excerpt'] = elgg_get_excerpt($excerpt);

echo elgg_view('page/components/image_block', array(
	'image' => '<img src="' . elgg_get_site_url() . 'mod/event_calendar/images/event_icon.gif" />',
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'panel panel-river',
));
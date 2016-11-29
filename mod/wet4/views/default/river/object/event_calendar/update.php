<?php
/*
 * GC_MODIFICATION
 * Description: Add panel class
 * Author: GCTools Team
*/


$object = $vars['item']->getObjectEntity();

echo elgg_view('page/components/image_block', array(
	'image' => '<img src="' . elgg_get_site_url() . 'mod/event_calendar/images/event_icon.gif" />',
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'panel panel-river',
));

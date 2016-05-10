<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * River item for a mission object.
 */
$object = $vars['item']->getObjectEntity();

// URL to the display for the mission.
$link = elgg_view('output/url', array(
    'text' => elgg_get_excerpt($object->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')),
    'href' => $object->getURL(),
	'class' => 'mission-emphasis mission-link-color'
));

$summary = $link . ', ' . elgg_echo($object->job_type);
// Shortens the description to 200 characters.
$message = elgg_get_excerpt($object->descriptor, elgg_get_plugin_setting('river_message_limit', 'missions')) . "\n";

echo elgg_view('river/elements/layout', array(
    'item' => $vars['item'],
    'summary' => $summary,
    'message' => $message
));
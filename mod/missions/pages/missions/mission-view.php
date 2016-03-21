<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * The page for displaying the mission.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$mission_guid = mm_clean_url_segment(array_pop($blast_radius));
$mission = get_entity($mission_guid);

$title = elgg_echo('missions:mission_view');
$content = elgg_view_entity($mission);

echo elgg_view_page($title, $content);
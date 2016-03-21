<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page which allows a mission manager to edit the contents of their mission.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$mission_guid = array_pop($exploded_uri);
$mission = get_entity($mission_guid);

$title = elgg_echo('missions:edit_mission');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($mission->job_title);

$content = elgg_view_title($title);
$content .= elgg_view_form('missions/change-mission-form', array(
    'class' => 'form-horizontal'
), array(
    'entity' => $mission
));

$content .= elgg_view('page/elements/related-candidates', array(
		'entity' => $mission
));

echo elgg_view_page($title, $content);
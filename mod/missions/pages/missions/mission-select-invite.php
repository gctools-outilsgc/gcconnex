<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which allows a manager to select the mission a candidate will be invited to.
 * This is meant to be a follow up to inviting a candidate from the candidate search.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$user_guid = array_pop($exploded_uri);

$title = elgg_echo('missions:invite_user_to_mission');
$content = elgg_view_title($title);

$content .= elgg_view('page/elements/invitable-missions', array('candidate_guid' => $user_guid));

echo elgg_view_page($title, $content);
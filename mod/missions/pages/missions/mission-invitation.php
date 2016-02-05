<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which displays the mission the candidate has been invited to and allows them to accept or decline.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$mission = get_entity(array_pop($blast_radius));

if(check_entity_relationship($mission->guid, 'mission_tentative', elgg_get_logged_in_user_guid())) {
	$applicant = elgg_get_logged_in_user_guid();
}
else {
	register_error('missions:error:not_sent_invitation');
	forward(REFERER);
}

$title = elgg_echo('missions:mission_invitation');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($mission->job_title, $mission->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view_entity($mission, array(
		'entity' => $mission,
        'mission_full_view' => true,
    	'override_buttons' => true
));

// Button to accept the mission.
$content .= elgg_view('output/url', array(
    'href' => elgg_get_site_url() . 'action/missions/accept-invite?applicant=' . $applicant . '&mission=' . $mission->guid,
    'text' => elgg_echo('missions:accept'),
    'is_action' => true,
    'class' => 'elgg-button btn btn-default'
));
// Button to decline the mission.
$content .= elgg_view('output/url', array(
    'href' => elgg_get_site_url() . 'action/missions/decline-invite?applicant=' . $applicant . '&mission=' . $mission->guid,
    'text' => elgg_echo('missions:decline'),
    'is_action' => true,
    'class' => 'elgg-button btn btn-default'
));

echo elgg_view_page($title, $content);
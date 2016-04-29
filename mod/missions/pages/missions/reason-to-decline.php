<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
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
	forward($mission->getURL());
}

$title = elgg_echo('missions:reason_to_decline');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($mission->job_title, $mission->getURL());
elgg_push_breadcrumb(elgg_echo('missions:mission_invitation'), elgg_get_site_url() . 'missions/mission-invitation/' . $mission->guid);
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs');

$content .= elgg_view_form('missions/decline-invite', array(), array(
		'mission' => $mission,
		'applicant' => $applicant
));

echo elgg_view_page($title, $content);
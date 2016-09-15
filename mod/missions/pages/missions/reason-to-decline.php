<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which allows a user related to the mission to give a reason for leaving the mission.
 */
gatekeeper();

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$mission = get_entity(array_pop($blast_radius));

// The logged in user must be related to the mission to be on this page.
if(check_entity_relationship($mission->guid, 'mission_tentative', elgg_get_logged_in_user_guid())
		|| check_entity_relationship($mission->guid, 'mission_applied', elgg_get_logged_in_user_guid())
		|| check_entity_relationship($mission->guid, 'mission_offered', elgg_get_logged_in_user_guid())
		|| check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid())) {
	$applicant = elgg_get_logged_in_user_guid();
}
else {
	register_error(elgg_echo('missions:error:not_sent_invitation', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')))));
	forward($mission->getURL());
}

$title = elgg_echo('missions:reason_to_decline_or_withdraw');
if(check_entity_relationship($mission->guid, 'mission_tentative', $applicant) || check_entity_relationship($mission->guid, 'mission_offered', $applicant)) {
	$title = elgg_echo('missions:reason_to_decline');
}
else if(check_entity_relationship($mission->guid, 'mission_applied', $applicant) || check_entity_relationship($mission->guid, 'mission_accepted', $applicant)) {
	$title = elgg_echo('missions:reason_to_withdraw');
}

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')), $mission->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs');
$content .= '<div class="col-sm-12 clearix">';
$content .= elgg_view_form('missions/decline-invite', array(), array(
		'mission' => $mission,
		'applicant' => $applicant
));
$content .= '</div>';
echo elgg_view_page($title, $content);
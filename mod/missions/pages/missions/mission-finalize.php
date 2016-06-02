<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

/*
 * Page which allows the mission manager to accept the applicant into their Micro-Mission.
*/
gatekeeper();

if(elgg_get_logged_in_user_entity()->opt_in_missions != 'gcconnex_profile:opt:yes') {
	forward(elgg_get_site_url() . 'missions/main');
}

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$applicant = get_entity(array_pop($blast_radius));
$mission = get_entity(array_pop($blast_radius));

$err = '';

// Error checking to make sure that the applicant, manager, and relationship between mission and candidate are correct
if($applicant->type != 'user') {
	$err .= elgg_echo('missions:error:entity_not_a_user');
}
if(elgg_get_logged_in_user_guid() != $applicant->guid) {
	$err .= elgg_echo('missions:error:you_are_not_the_applicant', array($applicant->name));
}
if(!check_entity_relationship($mission->guid, 'mission_offered', $applicant->guid)) {
	$err .= elgg_echo('missions:error:applicant_not_offered_this_mission', array($mission->job_title));
}

if($err != '') {
	register_error($err);
	forward(elgg_get_site_url() . 'missions/main');
}
else {
	$title = elgg_echo('missions:mission_finalize_acceptance_for', array($applicant->name));

	elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
	elgg_push_breadcrumb($title);

	$content = elgg_view_title($title);

	$content .= elgg_view('page/elements/mission-tabs');

	$content .= elgg_view_entity($mission, array('mission_full_view' => false, 'override_buttons' => true));

	$content .= '<div class="col-sm-12">' . mm_finalize_button($mission, $applicant);

	// Button which removes the relationship between the applicant and the mission.
	$content .= elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
			'text' => elgg_echo('missions:decline'),
			'class' => 'elgg-button btn btn-danger',
			'style' => 'margin:8px;'
	)) . '</div>';

	echo elgg_view_page($title, $content);
}
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

if(!check_if_opted_in(elgg_get_logged_in_user_entity())) {
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
if(elgg_get_logged_in_user_guid() != $mission->owner_guid && elgg_get_logged_in_user_guid() != $mission->account) {
	$err .= elgg_echo('missions:error:you_do_not_own_this_mission', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))));
}
if(!check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
	$err .= elgg_echo('missions:error:applicant_not_applied_to_mission', array($applicant->name));
}

if($err != '') {
	register_error($err);
	forward(elgg_get_site_url() . 'missions/main');
}
else {
	$title = elgg_echo('missions:mission_offer_for', array($applicant->name));
	
	elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
	elgg_push_breadcrumb($title);
	
	$content = elgg_view_title($title);

	$content .= elgg_view('page/elements/mission-tabs');
	
	$content .= '<div>' . elgg_echo('missions:placeholder_h', array($mission->job_title)) . '</div>';

	$content .= elgg_view_entity($applicant);
	
	$content .= mm_offer_button($mission, $applicant);
	
	// Button which removes the relationship between the applicant and the mission.
	$content .= elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . $applicant->guid . '&mid=' . $mission->guid,
			'text' => elgg_echo('missions:remove'),
			'is_action' => true,
			'class' => 'elgg-button btn btn-danger',
			'style' => 'margin:8px;'
	));
	
	echo elgg_view_page($title, $content);
}
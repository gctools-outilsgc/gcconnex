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
$applicant = get_entity(array_pop($blast_radius));
$mission = get_entity(array_pop($blast_radius));

$err = '';

if($applicant->type != 'user') {
	$err .= elgg_echo('missions:error:entity_not_a_user');
}

if(elgg_get_logged_in_user_guid() != $mission->owner_guid) {
	$err .= elgg_echo('missions:error:you_do_not_own_this_mission');
}

if(!check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
	$err .= elgg_echo('missions:error:applicant_not_applied_to_mission');
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

	$content .= elgg_view_entity($applicant);
	
	$content .= elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/missions/mission-offer?aid=' . $applicant->guid . '&mid=' . $mission->guid,
			'text' => elgg_echo('missions:offer'),
			'is_action' => true,
			'class' => 'elgg-button btn btn-success',
			'style' => 'margin:8px;'
	));
	
	$content .= elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'action/missions/remove-applicant?aid=' . $applicant->guid . '&mid=' . $mission->guid,
			'text' => elgg_echo('missions:remove'),
			'is_action' => true,
			'class' => 'elgg-button btn btn-danger',
			'style' => 'margin:8px;'
	));
	
	echo elgg_view_page($title, $content);
}
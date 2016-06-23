<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to send an invitation to a candidate.
 * This is meant to be called from a link or button.
 */
$applicant_guid = get_input('aid');
$mission_guid = get_input('mid'); 

if(!$mission_guid) {
	register_error(elgg_echo('missions:error:missing_mission'));
	forward(elgg_get_site_url() . 'missions/main');
}

$applicant = get_user($applicant_guid);
$mission = get_entity($mission_guid);

// Does not allow invitations when the number of opportunities is equaled or exceeded.
$relationship_set = get_entity_relationships($mission->guid);
foreach($relationship_set as $key => $value) {
	if($value->relationship != 'mission_accepted') {
		unset($relationship_set[$key]);
	}
}
$relationship_count = count($relationship_set);
if($relationship_count >= $mission->number) {
	$err .= elgg_echo('missions:error:opportunity_limit_reached');
}

// Throws up an error if a relationship already exists.
if(check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
	$err .= elgg_echo('missions:error:user_already_applied', array($applicant->name, $mission->job_title));
}

if(check_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid)) {
	$err .= elgg_echo('missions:error:user_already_invited', array($applicant->name, $mission->job_title));
}

if(check_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid)) {
	$err .= elgg_echo('missions:error:user_already_participating', array($applicant->name, $mission->job_title));
}
	
// Only users who have opted in to micro missions can be invited.
if(!check_if_opted_in($applicant)) {
	$err .= elgg_echo('missions:error:not_participating_in_missions', array($applicant->name));
}

if($err == '') {
	$invitation_link = elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'missions/view/' . $mission->guid,
			'text' => elgg_echo('missions:mission_invitation')
	));
	
	$subject = $mission->name . elgg_echo('missions:invited_you', array(), $applicant->language) . $mission->title;
	$body = $invitation_link;
	
	mm_notify_user($applicant->guid, $mission->guid, $subject, $body);
	
	//add_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);
	
	system_message(elgg_echo('missions:invited_user_to_mission', array($applicant->name, $mission->job_title)));
	
	forward(elgg_get_site_url() . 'missions/main');
}
else {
	register_error($err);
	forward(REFERER);
}
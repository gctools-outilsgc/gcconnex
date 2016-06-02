<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Declines the invitation sent to a candidate.
 */
$applicant = get_user(get_input('hidden_applicant_guid'));
$mission = get_entity(get_input('hidden_mission_guid'));
//$manager = get_user($mission->owner_guid);

// Processes the reason given by the declining user whether it's from the dropdown menu or the free text entry.
$reason = get_input('reason');
if($reason == 'missions:other') {
	$reason = get_input('other_text');
}
else {
	$raw_reason = $reason;
	$reason = elgg_echo($reason);
}

if(trim($reason) == '') {
	register_error(elgg_echo('missions:please_give_reason_for_declination'));
	forward(REFERER);
}

// Deletes the tentative relationship between mission and applicant.
if(check_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid)) {
	$message_return = 'missions:declination_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);
}
if(check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
	$message_return = 'missions:withdrawal_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
}
if(check_entity_relationship($mission->guid, 'mission_offered', $applicant->guid)) {
	$message_return = 'missions:declination_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_offered', $applicant->guid);
}
if(check_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid)) {
	$message_return = 'missions:withdrawal_has_been_sent';
	remove_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);
}

$declination = new ElggObject();
$declination->subtype = 'mission-declination';
$declination->title = 'Micro-Mission Declination Report';
$declination->access_id = ACCESS_LOGGED_IN;
$declination->owner_guid = $applicant->guid;
$declination->mission_guid = $mission->guid;
$declination->applicant_reason = $raw_reason;

$result = $declination->save();

// Notifies the mission manager of the candidates refusal.
$mission_link = elgg_view('output/url', array(
    'href' => $mission->getURL(),
    'text' => elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))
));

$subject = elgg_echo('missions:applicant_leaves', array($applicant->name)/*, $manager->language*/);
$body = elgg_echo('missions:applicant_leaves_more', array($applicant->name)/*, $manager->language*/) . $mission_link . '.' . "\n";
$body .= elgg_echo('missions:reason_given', array($reason)/*, $manager->language*/);
mm_notify_user($mission->guid, $applicant->guid, $subject, nl2br($body));
                
//forward(elgg_get_site_url() . 'messages/inbox/' . $applicant->username);
system_message(elgg_echo($message_return, array($mission->job_title)));
forward(elgg_get_site_url() . 'missions/main');
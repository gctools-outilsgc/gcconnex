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
$manager = get_user($mission->owner_guid);

// Processes the reason given by the declining user whether it's from the dropdown menu or the free text entry.
$reason = get_input('reason');
if($reason == 'missions:other') {
	$reason = get_input('other_text');
	if(trim($reason) == '') {
		$reason = elgg_echo('missions:none_given');
	}
}
else {
	$reason = elgg_echo($reason);
}

// Deletes the tentative relationship between mission and applicant.
remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);

// Notifies the mission manager of the candidates refusal.
$mission_link = elgg_view('output/url', array(
    'href' => $mission->getURL(),
    'text' => $mission->title
));

$subject = elgg_echo('missions:declines_invitation', array($applicant->name), $manager->language);
$body = elgg_echo('missions:declines_invitation_more', array($applicant->name), $manager->language) . $mission_link . '.' . "\n";
$body .= elgg_echo('missions:reason_given', array($reason), $manager->language);
mm_notify_user($mission->guid, $applicant->guid, $subject, $body);
                
//forward(elgg_get_site_url() . 'messages/inbox/' . $applicant->username);
system_message(elgg_echo('missions:declination_has_been_sent', array($mission->job_title)));
forward(elgg_get_site_url() . 'missions/main');
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
$applicant = get_user(get_input('applicant'));
$mission = get_entity(get_input('mission'));
$manager = get_user($mission->owner_guid);

// Deletes the tentative relationship between mission and applicant.
remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);

// Notifies the mission manager of the candidates refusal.
$mission_link = elgg_view('output/url', array(
    'href' => $mission->getURL(),
    'text' => $mission->title
));

$subject = $applicant->name . elgg_echo('missions:declines_invitation', array(), $manager->language);
$body = $applicant->name . elgg_echo('missions:declines_invitation_more', array(), $manager->language) . $mission_link . '.';
notify_user($manager->guid, $applicant->guid, $subject, $body);
                
//forward(elgg_get_site_url() . 'messages/inbox/' . $applicant->username);
forward(elgg_get_site_url() . 'missions/main');
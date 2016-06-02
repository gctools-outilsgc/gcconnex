<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * This action removes the relationship between the mission and one of its applicants.
 */
$mid = get_input('mid');;
$mission = get_entity($mid);
$aid = get_input('aid');
$user = get_user($aid);

if($aid == '') {
    register_error(elgg_echo('missions:error:no_applicant_to_remove'));
}
else {
	// Works on tentative, accepted, or applied relationships.
	if(check_entity_relationship($mid, 'mission_applied', $aid)) {
		remove_entity_relationship($mid, 'mission_applied', $aid);
	}
	if(check_entity_relationship($mid, 'mission_tentative', $aid)) {
		remove_entity_relationship($mid, 'mission_tentative', $aid);
	}
	if(check_entity_relationship($mid, 'mission_offered', $aid)) {
    	remove_entity_relationship($mid, 'mission_offered', $aid);
	}
	if(check_entity_relationship($mid, 'mission_accepted', $aid)) {
    	remove_entity_relationship($mid, 'mission_accepted', $aid);
	}
	
	$mission->time_to_fill = '';
	$mission->save();
	
    $body = '';
    // Notifies the manager that the candidate withdrew from the mission.
    if(elgg_get_logged_in_user_guid() == $aid) {
    	$target = $mission->guid;
    	$sender = $aid;
    	$subject = elgg_echo('missions:withdrew_from_mission', array($user->name, $mission->title), $user->language);
    }
    // Notifies the candidate that they were removed from the mission.
    else {
    	$target = $aid;
    	$sender = $mission->guid;
    	$subject = elgg_echo('missions:removed_from_mission', array($mission->title), $user->language);
    }
    mm_notify_user($target, $sender, $subject, $body);
}

system_message(elgg_echo('missions:user_removed', array($user->name, $mission->job_title)));

forward(REFERER);
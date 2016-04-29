<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

$applicant = get_user(get_input('aid'));
$mission = get_entity(get_input('mid'));
$manager = get_user($mission->owner_guid);

$err = '';

if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	if(!check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
		$err .= elgg_echo('missions:error:applicant_not_applied_to_mission');
	}
	else {
		$relationship_count = elgg_get_entities_from_relationship(array(
				'relationship' => 'mission_accepted',
				'relationship_guid' => $mission->guid,
				'count' => true
		));
	    
		if($relationship_count >= $mission->number) {
			$err .= elgg_echo('missions:error:mission_full');
		}
		else {
			remove_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
		
			add_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);
			 
			$mission_link = elgg_view('output/url', array(
					'href' => $mission->getURL(),
					'text' => $mission->title
			));
			 
			$subject = $applicant->name . ' ' . elgg_echo('missions:participating_in', array($mission->job_title), $applicant->language);
			$body = $applicant->name . ' ' . elgg_echo('missions:participating_in_more', array(), $applicant->language) . $mission_link . '.';
			mm_notify_user($applicant->guid, $manager->guid, $subject, $body);
		}
	}
}

if ($err != '') {
	register_error($err);
}

system_message(elgg_echo('missions:offered_user_position', array($applicant->name, $mission->job_title)));

forward($mission->getURL());
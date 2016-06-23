<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Accepts the invitation sent to a candidate.
 */
$applicant = get_user(get_input('applicant'));
$mission = get_entity(get_input('mission'));
//$manager = get_user($mission->owner_guid);

$err = '';

// If the mission has been deleted in the interim then return an error.
if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	// If the relationship has disappeared before the user responds then they must no longer be invited.
	if(!check_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid)) {
	    $err .= elgg_echo('missions:error:no_longer_invited');
	}
	else {
		// Counts the number of users that are participating in the mission.
	    $relationship_count = elgg_get_entities_from_relationship(array(
	        'relationship' => 'mission_accepted',
			'relationship_guid' => $mission->guid,
			'count' => true
		));
	    
	    // Does not allow more accepted candidates then the number defined in the mission metadata.
		if($relationship_count >= $mission->number) {
			$err .= elgg_echo('missions:error:mission_full');
		}
		else {
			// Removes the tentative relationship.
		    remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);
		    
			// Creates an accepted relationship between mission and applicant.
			add_entity_relationship($mission->guid, 'mission_applied', $applicant->guid);
	    
			// Notifies the mission manager of the candidates acceptance.
			$mission_link = elgg_view('output/url', array(
				'href' => $mission->getURL(),
				'text' => $mission->title
			));
	    
			$subject =  elgg_echo('missions:accepts_invitation', array($applicant->name)/*, $manager->language*/);
			$body = elgg_echo('missions:accepts_invitation_more', array($applicant->name)/*, $manager->language*/) . $mission_link . '.';
			$body .= "<br>" . elgg_echo('missions:finalize_offer', array()/*, $manager->language*/) . "<br>";
			$body .= elgg_view('output/url', array(
			    	'href' => elgg_get_site_url() . 'missions/mission-offer/' . $mission->guid . '/' . $applicant->guid,
			    	'text' => elgg_echo('missions:offer')
			));;
			mm_notify_user($mission->guid, $applicant->guid, $subject, $body);
			
			// Opts in the candidate if they are not opted in already.
			if(!check_if_opted_in($applicant)) {
				$applicant->opt_in_missions = 'gcconnex_profile:opt:yes';
				$applicant->save();
			}
		}
	}
}

if ($err != '') {
    register_error($err);
}
else {
	system_message(elgg_echo('missions:acceptance_has_been_sent', array($mission->job_title)));
}

forward($mission->getURL());
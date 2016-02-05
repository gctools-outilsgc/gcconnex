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
$manager = get_user($mission->owner_guid);

$err = '';

// If the mission has been deleted in the interim then return an error.
if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	$relationships = elgg_get_entities_from_relationship(array(
	        'relationship' => 'mission_tentative',
	        'relationship_guid' => $mission->guid
	    ));
	
	// Finds the tentative relationship which the applicant is a subject of.
	$target = '';
	foreach($relationships as $relationship) {
	    if($relationship->guid_two == $applicant_guid) {
	        $target = $relationship;
	    }
	}
	
	// If the relationship has disappeared before the user responds then they must no longer be invited.
	if($target == '') {
	    $err .= elgg_echo('missions:error:no_longer_invited');
	}
	else {
		// Removes the tentative relationship.
	    remove_entity_relationship($mission->guid, 'mission_tentative', $applicant->guid);
	    
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
			// Creates an accepted relationship between mission and applicant.
			add_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);
	    
			// Notifies the mission manager of the candidates acceptance.
			$mission_link = elgg_view('output/url', array(
				'href' => $mission->getURL(),
				'text' => $mission->title
			));
	    
			$subject = $applicant->name . elgg_echo('missions:accepts_invitation', array(), $manager->language);
			$body = $applicant->name . elgg_echo('missions:accepts_invitation_more', array(), $manager->language) . $mission_link . '.';
			notify_user($manager->guid, $applicant->guid, $subject, $body);
		}
	}
}

if ($err != '') {
    register_error($err);
}
// Returns the user to their inbox.
//forward(elgg_get_site_url() . 'messages/inbox/' . $applicant->username);
forward($mission->getURL());
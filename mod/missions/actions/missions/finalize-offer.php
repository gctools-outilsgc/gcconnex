<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

/*
 * Accepts the offer sent to a candidate.
 */
$applicant = get_user(get_input('aid'));
$mission = get_entity(get_input('mid'));

if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	// An offer needs to have been sent to the user.
	if(!check_entity_relationship($mission->guid, 'mission_offered', $applicant->guid)) {
		$err .= elgg_echo('missions:error:applicant_not_offered_this_mission', array($mission->job_title));
	}
	else {
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
			// Changes the applicant into a participant.
			remove_entity_relationship($mission->guid, 'mission_offered', $applicant->guid);
			add_entity_relationship($mission->guid, 'mission_accepted', $applicant->guid);
			
			// Saves time to fill data if this user fills the last spot.
			if(($relationship_count + 1) == $mission->number) {
				$mission->time_to_fill = time() - $mission->time_created;
				$mission->save;
			}
			 
			$mission_link = elgg_view('output/url', array(
					'href' => $mission->getURL(),
					'text' => $mission->title
			));

			$subject = elgg_echo('missions:participating_in', array($applicant->name, elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))));
			$body = elgg_echo('missions:participating_in_more', array($applicant->name)) . $mission_link . '.';
			mm_notify_user($mission->guid, $applicant->guid, $subject, $body);
		}
	}
}

if ($err != '') {
	register_error($err);
	forward(REFERER);
}
else {
	system_message(elgg_echo('missions:now_participating_in_mission', array($mission->job_title)));
	forward($mission->getURL());
}
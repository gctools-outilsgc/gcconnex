<?php
/*
 * Author: National Research Council Canada
* Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
*
* License: Creative Commons Attribution 3.0 Unported License
* Copyright: Her Majesty the Queen in Right of Canada, 2015
*/

/*
 * Action which offers a place in the mission to user with the applied relationship.
 */
$applicant = get_user(get_input('aid'));
$mission = get_entity(get_input('mid'));

$err = '';

if($mission == '') {
	$err .= elgg_echo('missions:error:entity_does_not_exist');
}
else {
	if(!check_entity_relationship($mission->guid, 'mission_applied', $applicant->guid)) {
		$err .= elgg_echo('missions:error:applicant_not_applied_to_mission', array($applicant->name));
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
			add_entity_relationship($mission->guid, 'mission_offered', $applicant->guid);
			 
			$finalize_link = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/view/' . $mission->guid,
					'text' => elgg_echo('missions:accept')
			));
			 
			$subject = elgg_echo('missions:offers_you_a_spot', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))), $applicant->language);
			$body = elgg_echo('missions:offers_you_a_spot_more', array(elgg_get_excerpt($mission->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions'))), $applicant->language) . $finalize_link . '.';
			mm_notify_user($applicant->guid, $mission->guid, $subject, $body);
		}
	}
}

if ($err != '') {
	register_error($err);
	forward(REFERER);
}
else {
	system_message(elgg_echo('missions:offered_user_position', array($applicant->name, $mission->job_title)));
	forward($mission->getURL());
}
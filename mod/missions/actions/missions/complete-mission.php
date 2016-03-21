<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which advances the state of the given mission to completed.
 * Forwards the manager to a feedback page.
 */
 
$mission_guid = get_input('mission_guid');
$mission = get_entity($mission_guid);

$mission_relation_list = get_entity_relationships($mission->guid);

$count = 0;
foreach($mission_relation_list as $relation) {
	// Messages all mission participants that the mission is completed.
	if($relation->relationship == 'mission_accepted') {
		$feedback_link = elgg_view('output/url', array(
	 				'href' => elgg_get_site_url() . 'missions/mission-feedback/' . $mission_guid,
	 				'text' => elgg_echo('missions:mission_feedback')
	 		));
		
		$subject = $mission->job_title . elgg_echo('missions:feedback');
		$body = $mission->job_title . elgg_echo('missions:feedback_message') . "\n" . $feedback_link;
		notify_user($relation->guid_two, $mission->owner_guid, $subject, $body);
		
		$count++;
	}
}

if($count == 0) {
	register_error(elgg_echo('missions:error:cannot_complete_mission_no_participants'));
	forward(REFERER);
}

$mission->state = 'completed';
$mission->save;

forward(elgg_get_site_url() . 'missions/mission-feedback/' . $mission_guid);
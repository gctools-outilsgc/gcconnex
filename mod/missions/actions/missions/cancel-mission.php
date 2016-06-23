<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Sets mission state to cancelled.
 */
$mission_guid = get_input('mission_guid');
$mission = get_entity($mission_guid);
$from_admin = get_input('MISSION_ADMIN_ACTION_FLAG');

// Counts up all the participants and applicants who have received an offer.
$relationship_count = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_accepted',
		'relationship_guid' => $mission->guid,
		'count' => true
));
$relationship_count += elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_offered',
		'relationship_guid' => $mission->guid,
		'count' => true
));

// Does not allow the misssion to be cancelled if the count is not zero.
if($relationship_count > 0) {
	register_error(elgg_echo('missions:cannot_cancel_mission_with_participants'));
	forward(REFERER);
}
else {
	$mission->state = 'cancelled';
	$mission->time_to_cancel = time() - $mission->time_created;
	$mission->time_closed = time();
	$mission->save;
	
	system_message(elgg_echo('missions:has_been_cancelled', array($mission->job_title)));
	
	// If the admin tool is calling the action then the user is returned to the admin tool page.
	if($from_admin) {
		forward(REFERER);
	}
	
	forward(elgg_get_site_url() . 'missions/main');
}
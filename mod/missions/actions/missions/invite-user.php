<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action to send an invitation to a candidate.
 * This is meant to be called from a link or button.
 */
$applicant_guid = get_input('aid');
$mission_guid = get_input('mid'); 

if(!$mission_guid) {
	register_error(elgg_echo('missions:error:missing_mission'));
	forward(elgg_get_site_url() . 'missions/main');
}

$applicant = get_user($applicant_guid);
$mission = get_entity($mission_guid);

// Does not allow invitations when the number of opportunities is equaled or exceeded.
$relationship_count = count(get_entity_relationships($mission->guid));
if($relationship_count >= $mission->number) {
	register_error('missions:error:opportunity_limit_reached');
	forward(elgg_get_site_url() . 'missions/main');
}

// Only users who have opted in to micro missions can be invited.
if($applicant->opt_in_missions == 'gcconnex_profile:opt:yes') {
	mm_send_notification_invite($applicant, $mission);
	forward(elgg_get_site_url() . 'missions/main');
}
else {
	register_error(elgg_echo('missions:error:not_participating_in_missions', array($applicant->name)));
	forward(REFERER);
}
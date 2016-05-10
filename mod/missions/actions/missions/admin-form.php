<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Handles the administrator actions that may be used on a mission.
 */
$mission_guid = get_input('mission_guid');
$mission = get_entity($mission_guid);
$action = get_input('action_taken');

// The entered GUID must be a Micro-Mission GUID.
if(get_subtype_from_id($mission->subtype) != 'mission') {
	register_error(elgg_echo('mission:guid_entered_not_mission'));
	forward(REFERER);
}
else {
	set_input('mission_guid', $mission_guid);
	set_input('MISSION_ADMIN_ACTION_FLAG', true); // A flag which let's the called action know that an administrator is calling.
	
	// Required action security tokens.
	$ts = time();
	$token = generate_action_token($ts);
	set_input('__elgg_ts', $ts);
	set_input('__elgg_token', $token);
	
	// Processes which action to call according to form input.
	switch($action) {
		case elgg_echo('missions:complete'):
			action('missions/complete-mission');
			break;
		case elgg_echo('missions:cancel'):
			action('missions/cancel-mission');
			break;
		case elgg_echo('missions:reopen'):
			action('missions/reopen-mission');
			break;
		case elgg_echo('missions:delete'):
			action('missions/delete-mission');
			break;
	}
}
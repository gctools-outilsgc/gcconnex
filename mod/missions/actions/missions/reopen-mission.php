<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which retreats the state of the given mission to posted.
 */
$mission_guid = get_input('mission_guid');
$mission = get_entity($mission_guid);
$from_admin = get_input('MISSION_ADMIN_ACTION_FLAG');

$mission->state = 'posted';
$mission->save;

$ia = elgg_set_ignore_access(true);
$analytics_record = new ElggObject();
$analytics_record->subtype = 'mission-posted';
$analytics_record->title = 'Mission Posted Report';
$analytics_record->mission_guid = $mission->guid;
$analytics_record->access_id = ACCESS_LOGGED_IN;
$analytics_record->save();
$ia = elgg_set_ignore_access($ia);

system_message(elgg_echo('missions:has_been_reopened', array($mission->job_title)));

// If the admin tool is calling the action then the user is returned to the admin tool page.
if($from_admin) {
	forward(REFERER);
}

forward($mission->getURL());
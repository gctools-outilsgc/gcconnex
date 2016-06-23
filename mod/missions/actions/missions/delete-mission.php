<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action is for the delete action when deleting from the print-mission or print-mission-more view.
 */
$guid = (int) get_input('mission_guid');
$mission = get_entity($guid);
$mission_count = $_SESSION['mission_count'];
$mission_set = $_SESSION['mission_search_set'];
$from_admin = get_input('MISSION_ADMIN_ACTION_FLAG');

$key = '';
// If the element is in a currently saved search set then we remove it from the set.
if (($key = array_search($mission, $mission_set)) !== false) {
    unset($mission_set[$key]);
    $mission_count --;
}

$_SESSION['mission_count'] = $mission_count;
$_SESSION['mission_search_set'] = $mission_set;

system_message(elgg_echo('missions:has_been_deleted', array($mission->job_title)));

$mission->delete();

// If the admin tool is calling the action then the user is returned to the admin tool page.
if($from_admin) {
	forward(REFERER);
}

forward(elgg_get_site_url() . 'missions/main');
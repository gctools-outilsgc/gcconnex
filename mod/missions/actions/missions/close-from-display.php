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
 * There is no equivalent form for this action. It is called directly by a button.
 */
$guid = (int) get_input('mission_guid');
$mission = get_entity($guid);
$mission_count = $_SESSION['mission_count'];
$mission_set = $_SESSION['mission_search_set'];

$key = '';
// If the element is in a currently saved search set then we remove it from the set.
if (($key = array_search($mission, $mission_set)) !== false) {
    unset($mission_set[$key]);
    $mission_count --;
}

$_SESSION['mission_count'] = $mission_count;
$_SESSION['mission_search_set'] = $mission_set;

$mission->delete();
forward(elgg_get_site_url() . 'missions/main');
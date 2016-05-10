<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which saves the mission in session for duplication in the post an opportunity forms.
 */
$_SESSION['mission_duplication_id'] = get_input('mid');
$mission = get_entity($_SESSION['mission_duplication_id']);

system_message(elgg_echo('missions:duplicating_this_mission', array($mission->job_title)));

forward(elgg_get_site_url() . 'missions/mission-post');
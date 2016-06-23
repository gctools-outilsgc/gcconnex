<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which runs when the create opportunity button is pressed.
 */
// Clears out any previous sticky form information or related session variables.
$_SESSION['mission_uncheck_post_mission_disclaimer'] = true;
elgg_clear_sticky_form('firstfill');
elgg_clear_sticky_form('secondfill');
elgg_clear_sticky_form('thirdfill');
elgg_clear_sticky_form('ldropfill');
elgg_clear_sticky_form('tdropfill');
unset($_SESSION['tab_context']);
unset($_SESSION['mission_duplication_id']);
unset($_SESSION['mission_duplicating_override_first']);
unset($_SESSION['mission_duplicating_override_second']);
unset($_SESSION['mission_duplicating_override_third']);
unset($_SESSION['mission_creation_begin_timestamp']);

forward(elgg_get_site_url() . 'missions/mission-post');
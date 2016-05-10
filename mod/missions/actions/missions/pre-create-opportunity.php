<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$_SESSION['mission_uncheck_post_mission_disclaimer'] = true;
unset($_SESSION['tab_context']);

forward(elgg_get_site_url() . 'missions/mission-post');
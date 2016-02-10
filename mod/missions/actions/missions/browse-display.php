<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action is for the Browse latest menu option.
 * There is no equivalent form for this action. It is called directly by a link.
 * This action displays all the latest missions chronologically.
 */
//$_SESSION['mission_search_switch_override'] = 'mission'; 

$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['limit'] = elgg_get_plugin_setting('search_limit', 'missions');

$missions = elgg_get_entities($options);
$mission_count = count($missions);

$_SESSION['mission_count'] = $mission_count;
$_SESSION['mission_search_set'] = elgg_get_entities($options);
$_SESSION['mission_search_switch'] = 'mission';

forward(elgg_get_site_url() . 'missions/display-search-set');
<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$mission = get_entity(get_input('mid'));
$manager = get_user(get_input('aid'));

$hide_list_explode = explode(',', $manager->missions_hide_list);
$key = array_search($mission->guid, $hide_list_explode);
if(!($key === false)) {
	unset($hide_list_explode[$key]);
}

$manager->missions_hide_list = implode(',', $hide_list_explode);
$manager->save();

forward(REFERER);
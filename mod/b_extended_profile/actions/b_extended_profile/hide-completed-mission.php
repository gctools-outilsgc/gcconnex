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

if($manager->missions_hide_list == '') {
	$manager->missions_hide_list = $mission->guid;
}
else {
	$manager->missions_hide_list = $manager->missions_hide_list . ',' . $mission->guid;
}
$manager->save();

forward(REFERER);
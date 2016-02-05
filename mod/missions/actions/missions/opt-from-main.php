<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Changes the logged in users opt in status for micro missions.
 */
$current_user = elgg_get_logged_in_user_entity();

if($current_user->opt_in_missions == 'gcconnex_profile:opt:yes') {
	$current_user->opt_in_missions = 'gcconnex_profile:opt:no';
}
else {
	$current_user->opt_in_missions = 'gcconnex_profile:opt:yes';
}

$current_user->save();

forward(REFERER);
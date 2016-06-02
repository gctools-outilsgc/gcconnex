<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Saves a session value which decides whether or not completed and cancelled missions are displayed in My Opportunities.
 */
$check_closed = get_input('check_closed');
$user = elgg_get_logged_in_user_entity();
if($check_closed == 'on') {
	$user->show_closed_missions = true;
	system_message(elgg_echo('missions:displaying_closed_missions'));
}
else {
	$user->show_closed_missions = false;
	system_message(elgg_echo('missions:not_displaying_closed_missions'));
}
$user->save();

forward(REFERER);
<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Saves my missions refinement values in the session.
 */
 
$check_closed = get_input('check_closed');
if($check_closed == 'on') {
	$_SESSION['mission_refine_closed'] = 'SHOW_CLOSED';
	system_message(elgg_echo('missions:displaying_closed_missions'));
}
else {
	unset($_SESSION['mission_refine_closed']);
	system_message(elgg_echo('missions:not_displaying_closed_missions'));
}

forward(REFERER);
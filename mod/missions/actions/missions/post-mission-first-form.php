<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action evaluates the data from the form for errors and forwards the user to the next tab.
 */
elgg_make_sticky_form('firstfill');

$err = '';
$first_form = elgg_get_sticky_values('firstfill');

// Error checking function.
$err .= mm_first_post_error_check($first_form);

if(!$first_form['disclaimer']) {
	$err .= elgg_echo('missions:error:dislcaimer_needs_to_be_checked');
}

// If there is an error message it will be posted on the same page that will be reloaded
// If not then the next page will be loaded
if ($err == '') {
    forward(elgg_get_site_url() . 'missions/mission-post/step-two');
} else {
    register_error($err);
    forward(REFERER);
}
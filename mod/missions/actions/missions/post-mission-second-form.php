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
elgg_make_sticky_form('secondfill');
$_SESSION['mission_duplicating_override_second'] = true;

$err = '';
$first_form = elgg_get_sticky_values('firstfill');
$second_form = elgg_get_sticky_values('secondfill');

// Error checking function.
$err .= mm_first_post_error_check($first_form);
$err .= mm_second_post_error_check($second_form);

if ($err == '') {
    forward(elgg_get_site_url() . 'missions/mission-post/step-three');
} else {
    register_error($err);
    forward(REFERER);
}

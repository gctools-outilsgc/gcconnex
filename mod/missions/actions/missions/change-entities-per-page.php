<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Sets the number of mission or candidate entities seen on a single page.
 */
$typing = get_input('hidden_type');
$_SESSION[$typing . '_entities_per_page'] = get_input('number_per');

forward(REFERER);

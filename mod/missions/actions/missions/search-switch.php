<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Action which switches between mission and candidate searching by changing a session variable.
 */
$switch = get_input('switch');

$_SESSION['mission_search_switch'] = $switch;

forward(REFERER);
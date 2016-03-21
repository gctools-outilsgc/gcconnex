<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which retreats the state of the given mission to posted.
 */

$mission_guid = get_input('mission_guid');
$mission = get_entity($mission_guid);

$mission->state = 'posted';
$mission->save;

forward($mission->getURL());
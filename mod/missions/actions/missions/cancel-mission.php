<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Sets mission state to cancelled.
 */
$mission_guid = get_input('mission_guid');
$mission = get_entity($mission_guid);

$mission->state = 'cancelled';
$mission->save;

forward(elgg_get_site_url() . 'missions/main');
<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Action which endorses the user via the feedback object associated with that user and a specific mission.
 * Called by clicking a button on the mission view.
 */
$feedback = get_entity(get_input('fid'));

if(get_subtype_from_id($feedback->subtype) == 'mission-feedback') {
	$feedback->endorsement = 'on';
	$feedback->save();
	system_message(elgg_echo('mission:endorsed_recipient', array(get_user($feedback->recipient)->name, get_entity($feedback->mission)->job_title)));
}

forward(REFERER);
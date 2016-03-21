<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action takes the input from the feedback form and constructs an object with subtype mission-feedback.
 */
$mission = get_entity(get_input('hidden_mission_guid'));
$target = get_entity(get_input('hidden_target_guid'));
$feedback = get_entity(get_input('hidden_feedback_guid'));

$feedback_body = get_input('feedback_body');
$feedback_rating = get_input('feedback_rating');

// If feedback does not already exist then create a new feedback;
if(!$feedback) {
	$feedback = new ElggObject();
	$feedback->subtype = 'mission-feedback';
	$feedback->title = $mission->job_title . ' Feedback';
	$feedback->description = 'Feedback for a mission.';
	$feedback->access_id = ACCESS_LOGGED_IN;
	$feedback->owner_guid = elgg_get_logged_in_user_guid();
	
	$feedback->recipient = $target->guid;
	$feedback->mission = $mission->guid;
}

// If the feedback message input is not null then send a notification to the feedback target.
if($feedback_body) {
	notify_user($target->guid, elgg_get_logged_in_user_guid(), $mission->job_title . ' ' . elgg_echo('missions:feedback'), $feedback_body);
	$feedback->message = 'sent';
}

$feedback->endorsement = $feedback_rating;

$feedback->save();

elgg_clear_sticky_form('applicationfill');
forward(REFERER);
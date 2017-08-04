<?php
/**
 * Elgg Poll plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

// Get input data
$response = get_input('response');
if (!is_array($response)) {
	$response = array($response);
}
$guid = get_input('guid');

//get the poll entity
$poll = get_entity($guid);

if (!$poll instanceof Poll) {
	register_error(elgg_echo('poll:notfound'));
	forward(REFERER);
}

// Make sure the response isn't blank
if (empty($response)) {
	register_error(elgg_echo("poll:novote"));
	forward(REFERER);
}

// Make sure user hasn't voted more than the maximum amount of options
if (count($response) > $poll->max_votes) {
	register_error(elgg_echo("poll:max_votes:info", array($poll->max_votes)));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

// Check if user has already voted
if ($poll->hasVoted($user)) {
	register_error(elgg_echo('poll:alreadyvoted'));
	forward(REFERER);
}

// add vote as an annotation
foreach($response as $vote){
	$poll->annotate('vote', $vote, $poll->access_id);
}

// Add to river
$poll_vote_in_river = elgg_get_plugin_setting('vote_in_river', 'poll');
if ($poll_vote_in_river != 'no') {
	elgg_create_river_item(array(
		'view' => 'river/object/poll/vote',
		'action_type' => 'vote',
		'subject_guid' => $user->guid,
		'object_guid' => $poll->guid,
	));
}

// Notify creator of poll
$notification_on_vote = elgg_get_plugin_setting('notification_on_vote', 'poll');
if ($notification_on_vote == 'yes') {
	if ($user->getGUID() != $poll->getOwnerGUID()) {
		$poll_owner = $poll->getOwnerEntity();
		$owner_language = ($poll_owner->language) ? $poll_owner->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');
		$subject = elgg_echo('poll:notification_on_vote:subject', array(), $owner_language);
		$message = elgg_echo('poll:notification_on_vote:body', array($poll_owner->name, $poll->title, $poll->getURL()), $owner_language);
		notify_user($poll->getOwnerGUID(), elgg_get_config('site_guid'), $subject, $message, array(
			'object' => $poll,
			'action' => 'vote',
			'summary' => $subject
		));
	}
}

if (get_input('callback')) {
	echo elgg_view('poll/poll_widget_content', array('entity' => $poll));
}

// Success message
system_message(elgg_echo("poll:responded"));

// Forward to the poll page
forward($poll->getUrl());

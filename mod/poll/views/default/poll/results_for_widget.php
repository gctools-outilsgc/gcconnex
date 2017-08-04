<?php
/**
 * Poll result view
 */

$poll = elgg_extract('entity', $vars);

// Get array of possible responses
$choices = poll_get_choice_array($poll);

$total = $poll->getResponseCount();

$allow_open_poll = elgg_get_plugin_setting('allow_open_poll', 'poll');
if ($allow_open_poll == 'yes') {
	$open_poll = ($poll->open_poll == 1);
} else {
	$open_poll = false;
}

$vote_id = 0;

foreach ($choices as $choice) {
	$response_count = $poll->getResponseCountForChoice((string)$choice);

	$response_label = elgg_echo ('poll:result:label', array($choice, $response_count));

	$voted_users = '';

	// Show members if this poll is an open poll or if an admin is logged in
	// (in the latter case open polls must be enabled in plugin settings)
	if ($open_poll || (($allow_open_poll == 'yes') && elgg_is_admin_logged_in())) {
		$vote_id++;

		// TODO Would it be possible to use elgg_list_annotations() with
		// custom view that displays only annotation owner icons?
		$response_annotations = elgg_get_annotations(array(
			'guid' => $poll->guid,
			'annotation_name' => 'vote',
			'annotation_value' => $choice,
		));

		$user_guids = array();
		foreach ($response_annotations as $ur) {
			$user_guids[] = $ur->owner_guid;
		}

		if ($user_guids) {
			// Gallery of voters
			$voted_users = elgg_list_entities(array(
				'guids' => $user_guids,
				'pagination' => false,
				'list_type' => 'users',
				'size' => 'tiny',
			));
		}

		// Display as link that toggles the user icon gallery
		$response_label = elgg_view('output/url', array(
			'text' => $response_label,
			'href' => "#poll-users-vote-{$vote_id}",
			'rel' => 'toggle',
		));

		// Hide voter list of closed poll by default (admins can toggle it)
		$hidden = $open_poll ? '' : 'hidden';
	}

	$response_title = elgg_echo("poll:show_voters");

	if ($response_count == 0) {
		$percentage = 0;
	} else {
		$percentage = round($response_count / $total * 100);
	}

	echo <<<HTML
	<div class="poll-result">
		<label title="$response_title">$response_label</label>
		<div class="poll-progress">
			<div class="poll-progress-filled" style="width: {$percentage}%"></div>
		</div>
		<div $hidden id=poll-users-vote-{$vote_id}>$voted_users</div>
	</div>
HTML;
}

?>

<p><?php echo elgg_echo('poll:totalvotes', array($poll->getVoterCount())); ?></p>

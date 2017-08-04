<?php

// Get poll
$guid = get_input('guid');
$poll = get_entity($guid);

if ($poll instanceof Poll) {
	$allow_poll_reset = elgg_get_plugin_setting('allow_poll_reset', 'poll');
	if (elgg_is_admin_logged_in() || ($allow_poll_reset == 'yes' && $poll->canEdit())) {
		$poll->deleteVotes();
		system_message(elgg_echo('poll:poll_reset_success'));
	} else {
		register_error(elgg_echo('poll:poll_reset_denied'));
	}
} else {
	register_error(elgg_echo('poll:notfound'));
}

forward(REFERER);

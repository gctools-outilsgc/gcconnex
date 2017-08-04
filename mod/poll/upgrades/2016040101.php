<?php

/**
 * Update access_id of poll choices to match the access_id of the poll
 */

set_time_limit(0);

// Ignore access to make sure all items get updated
$ia = elgg_set_ignore_access(true);

// Make sure that entries for disabled entities also get upgraded
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$batch = new ElggBatch('elgg_get_entities', array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => false
));
foreach ($batch as $poll) {
	$choices = $poll->getChoices();

	foreach ($choices as $choice) {
		$choice->access_id = $poll->access_id;
		$choice->save();
	}
}

elgg_set_ignore_access($ia);
access_show_hidden_entities($access_status);

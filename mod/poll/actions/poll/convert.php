<?php

elgg_load_library('elgg:poll');

// Make sure that entries for disabled entities also get upgraded
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$poll_batch = new ElggBatch('elgg_get_entities', array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => false
));

foreach ($poll_batch as $poll) {
	if (!$poll->getChoices() && is_array($poll->responses)) {
		$i = 0;
		$choices = $poll->responses;
		foreach($choices as $choice) {
			$poll_choice = new ElggObject();
			$poll_choice->owner_guid = $poll->owner_guid;
			$poll_choice->container_guid = $poll->container_guid;
			$poll_choice->subtype = "poll_choice";
			$poll_choice->text = $choice;
			$poll_choice->display_order = $i*10;
			$poll_choice->access_id = $poll->access_id;
			$poll_choice->save();
			add_entity_relationship($poll_choice->guid, 'poll_choice', $poll->guid);
			$i += 1;
		}
		$poll->deleteMetadata('responses');
		$poll->save();
	}

}

access_show_hidden_entities($access_status);

forward(REFERER);

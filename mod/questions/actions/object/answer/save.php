<?php

elgg_make_sticky_form('answer');

$guid = (int) get_input('guid');

$answer = new ElggAnswer($guid);

$adding = !$answer->guid;
$editing = !$adding;

if ($editing && !$answer->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$container_guid = (int) get_input('container_guid');
$description = get_input('description');

if (empty($container_guid) || empty($description)) {
	register_error(elgg_echo('questions:action:answer:save:error:body', [$container_guid, $description]));
	forward(REFERER);
}

if ($adding && !can_write_to_container(0, $container_guid, 'object', 'answer')) {
	register_error(elgg_echo('questions:action:answer:save:error:container'));
	forward(REFERER);
}

elgg_entity_gatekeeper($container_guid, 'object', ElggQuestion::SUBTYPE);
$question = get_entity($container_guid);

if ($question->getStatus() != 'open') {
	elgg_clear_sticky_form('answer');
	
	register_error(elgg_echo('questions:action:answer:save:error:question_closed'));
	forward(REFERER);
}

$answer->description = $description;
$answer->access_id = $question->access_id;
$answer->container_guid = $container_guid;

try {
	$answer->save();
	
	if ($adding) {
		// check for auto mark as correct
		$answer->checkAutoMarkCorrect($adding);
		
		// create river event
		elgg_create_river_item([
			'view' => 'river/object/answer/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $answer->getGUID(),
			'access_id' => $answer->access_id,
		]);
	}
} catch (Exception $e) {
	register_error(elgg_echo('questions:action:answer:save:error:save'));
	register_error($e->getMessage());
}

elgg_clear_sticky_form('answer');

forward(get_input('forward', $answer->getURL()));

<?php
/**
 * This action marks an answer as the correct answer for a question.
 *
 */

$guid = (int) get_input('guid');

if (empty($guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

elgg_entity_gatekeeper($guid, 'object', 'answer');
$entity = get_entity($guid);

// are you allowed to mark answers as correct
if (!questions_can_mark_answer($entity)) {
	register_error(elgg_echo('questions:action:answer:toggle_mark:error:not_allowed'));
	forward(REFERER);
}

$question = $entity->getContainerEntity();
$answer = $question->getMarkedAnswer();

if (empty($answer)) {
	// no answer yet, so mark this one
	$entity->markAsCorrect();
	
	system_message(elgg_echo('questions:action:answer:toggle_mark:success:mark'));
} elseif ($answer->getGUID() == $entity->getGUID()) {
	// the marked answer is this answer, so unmark
	$entity->undoMarkAsCorrect();
	
	system_message(elgg_echo('questions:action:answer:toggle_mark:success:unmark'));
} else {
	register_error(elgg_echo('questions:action:answer:toggle_mark:error:duplicate'));
}

forward(REFERER);

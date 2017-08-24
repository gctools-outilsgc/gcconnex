<?php

elgg_make_sticky_form('question');

$guid = (int) get_input('guid');
if (empty($guid)) {
	$question = new ElggQuestion();
} else {
	elgg_entity_gatekeeper($guid, 'object', 'question');
	$question = get_entity($guid);
}

$adding = !$question->getGUID();
$editing = !$adding;
$moving = false;

if ($editing && !$question->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$container_guid = (int) get_input('container_guid');
if (empty($container_guid)) {
	$container_guid = (int) $question->getOwnerGUID();
}

if ($editing && ($container_guid != $question->getContainerGUID())) {
	$moving = true;
}

$container = get_entity($container_guid);
if ($adding && !questions_can_ask_question($container)) {
	register_error(elgg_echo('questions:action:question:save:error:container'));
	forward(REFERER);
}

if (questions_limited_to_groups() && ($container_guid == $question->getOwnerGUID())) {
	register_error(elgg_echo('questions:action:question:save:error:limited_to_groups'));
	forward(REFERER);
}

$title = get_input('title');
$title2 = get_input('title2');
$title = gc_implode_translation($title, $title2);

$description = get_input('description');
$description2 = get_input('description2');
$description = gc_implode_translation($description, $description2);

$tags = string_to_tag_array(get_input('tags', ''));
$access_id = (int) get_input('access_id');
$comments_enabled = get_input('comments_enabled');

if (empty($container_guid) || empty($title) && empty($title2)) {
	register_error(elgg_echo('questions:action:question:save:error:body', [$container_guid, $title]));
	forward(REFERER);
}

// make sure we have a valid access_id
$access_id = questions_validate_access_id($access_id, $container_guid);

$question->title = $title;
$question->title2 = $title2;

$question->description = $description;
$question->description2 = $description2;

$question->access_id = $access_id;
$question->container_guid = $container_guid;

$question->tags = $tags;
$question->comments_enabled = $comments_enabled;

try {
	$question->save();

	if ($adding) {
		// add river event
		elgg_create_river_item([
			'view' => 'river/object/question/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $question->getGUID(),
			'access_id' => $question->access_id,
		]);

		// check for a solution time limit
		$solution_time = questions_get_solution_time($question->getContainerEntity());
		if ($solution_time) {
			// add x number of days when the question should be solved
			$question->solution_time = (time() + ($solution_time * 24 * 60 * 60));
		}
	} elseif ($moving) {
		elgg_trigger_event('move', 'object', $question);
	}
} catch (Exception $e) {
	register_error(elgg_echo('questions:action:question:save:error:save'));
	register_error($e->getMessage());
	forward(REFERER);
}

elgg_clear_sticky_form('question');

//forward to the question you just created
forward($question->getURL());

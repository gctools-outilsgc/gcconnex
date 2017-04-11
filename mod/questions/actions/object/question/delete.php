<?php

$guid = (int) get_input('guid');

elgg_entity_gatekeeper($guid, 'object', ElggQuestion::SUBTYPE);
$question = get_entity($guid);

if (!$question->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$owner = $question->getContainerEntity();

$question->delete();

forward(get_input('forward', "questions/owner/{$owner->getGUID()}"));

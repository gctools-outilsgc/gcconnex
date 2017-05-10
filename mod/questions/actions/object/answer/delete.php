<?php

$guid = (int) get_input('guid');

elgg_entity_gatekeeper($guid, 'object', ElggAnswer::SUBTYPE);
$answer = get_entity($guid);

if (!$answer->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$question = $answer->getContainerEntity();

$answer->delete();

forward(get_input('forward', $question->getURL()));

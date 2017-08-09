<?php

$guid = (int) get_input('guid');

elgg_entity_gatekeeper($guid, 'object', ElggQuestion::SUBTYPE);
$question = get_entity($guid);

if (!$question->canEdit()) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$container = $question->getContainerEntity();

$title = $question->getDisplayName();

if ($question->delete()) {
	system_message(elgg_echo('entity:delete:success', [$title]));
} else {
	register_error(elgg_echo('entity:delete:fail', [$title]));
	forward(REFERER);
}

$forward = get_input('forward');
if (!empty($forward)) {
	forward($forward);
} elseif ($container instanceof ElggUser) {
	forward("questions/owner/{$container->username}");
} elseif ($container instanceof ElggGroup) {
	forward("questions/group/{$container->getGUID()}/all");
}

forward();

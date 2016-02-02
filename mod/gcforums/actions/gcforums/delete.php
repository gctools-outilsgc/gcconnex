<?php

	$hjforum_guid = get_input('guid');
	$hjforum_entity = get_entity($hjforum_guid);

	if ($hjforum_entity->canEdit()) {
		if ($hjforum_entity->delete()) {
			system_message(elgg_echo("Entity entitled '{$hjforum_entity->title}' has been deleted"));
			forward(REFERER);
		} else {
			system_message(elgg_echo("Entity entitled '{$hjforum_entity->title}' could not be deleted"));
		}
	}

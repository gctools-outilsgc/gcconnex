<?php

	$hjforum_guid = get_input('guid');
	$hjforum_entity = get_entity($hjforum_guid);

	$value = elgg_trigger_plugin_hook('gcforums/delete', 'object', array(), 'poop');


	if ($hjforum_entity->canEdit()) {
		if ($hjforum_entity->delete()) {
			system_message(system_message(elgg_echo('gcforums:delete:success', array($hjforum_entity->title)));
			forward(REFERER);
		} else {
			system_message(elgg_echo("Entity entitled '{$hjforum_entity->title}' could not be deleted"));
		}
	}

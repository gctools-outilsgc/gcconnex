<?php
/**
 * Delete an idea
 *
 * @package ideas
 */

$guid = get_input('guid');
$idea = get_entity($guid);

if (elgg_instanceof($idea, 'object', 'idea') && $idea->canEdit()) {
	$container = $idea->getContainerEntity();
	if ($idea->delete()) {
		system_message(elgg_echo("ideas:idea:delete:success"));
		if (elgg_instanceof($container, 'group')) {
			forward("ideas/group/$container->guid/all");
		} else {
			forward("ideas/owner/$container->username");
		}
	}
}

register_error(elgg_echo("ideas:idea:delete:failed"));
forward(REFERER);

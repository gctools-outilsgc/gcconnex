<?php
/**
 * Elgg reading_list delete action
 *
 * @package reading_list
 */

$guid = get_input('guid');
$link = get_entity($guid);

$succeed = false;

if (elgg_instanceof($link, 'object', 'readinglistitem') && $link->canEdit()) {
	$container = $link->getContainerEntity();
	if ($link->delete()) {
		$succeed = true;
		system_message(elgg_echo("reading_list:delete:success"));
		
	}
}

if (!$succeed)
{
	register_error(elgg_echo("reading_list:delete:failed"));
}

forward(REFERER);

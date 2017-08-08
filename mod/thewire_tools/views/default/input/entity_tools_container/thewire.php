<?php

$entity = elgg_extract('entity', $vars);
if (!$entity) {
	return;
}

if ($entity->guid !== $entity->wire_thread) {
	echo '<div class="elgg-subtext">' . elgg_echo('thewire_tools:entity_tools:unable') . '</div>';
	return;
}

$vars['add_users'] = false;

echo elgg_view('input/entity_tools_container', $vars);

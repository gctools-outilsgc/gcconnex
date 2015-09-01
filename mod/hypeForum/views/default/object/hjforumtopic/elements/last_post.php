<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
	return false;
}

$last_post = $entity->getLatestPost(true);

if (!$last_post) {
	return false;
}

echo elgg_view_entity($last_post, array(
	'full_view' => false
));

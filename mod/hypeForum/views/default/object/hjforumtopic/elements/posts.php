<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
	return false;
}

echo $entity->countPosts(true) + 1;
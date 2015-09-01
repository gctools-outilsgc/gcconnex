<?php

$priorities = get_input('elgg-object');

for ($i = 0; $i < count($priorities); $i++) {
	$category = get_entity($priorities[$i]);
	if (elgg_instanceof($category) && $category->canEdit()) {
		$category->priority = $i * 10 + 1;
		if ($category->save()) {
			$reordered[$category->priority] = $category->guid;
		}
	}
}

if (elgg_is_xhr()) {
	print json_encode($reordered);
}
forward(REFERER);
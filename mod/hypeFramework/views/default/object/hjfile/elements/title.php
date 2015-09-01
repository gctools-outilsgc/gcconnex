<?php

$entity = elgg_extract('entity', $vars);

if (!elgg_instanceof($entity)) {
	return true;
}

$title = elgg_view('framework/bootstrap/object/elements/title', $vars);
echo $title;
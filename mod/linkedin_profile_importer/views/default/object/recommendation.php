<?php

$entity = elgg_extract('entity', $vars);

$description = '<blockquote>';
$description .= elgg_view('output/longtext', array(
	'value' => $entity->description,
));
$description .= '<cite>' . $entity->recommender . '</cite>';
$description .= '</blockquote>';

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => false,
	'subtitle' => false,
	'content' => $description
));

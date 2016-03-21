<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) return true;

$author_link = elgg_view('output/url', array(
	'text' => $entity->getOwnerEntity()->name,
	'href' => $entity->getOwnerEntity()->getURL(),
	'class' => 'elgg-entity-byline',
	'is_trusted' => true
));

echo '<div class="elgg-entity-byline">';
echo elgg_echo('byline', array($author_link)) . '<br />';
//echo elgg_view_friendly_time($entity->time_created);
echo '</div>';
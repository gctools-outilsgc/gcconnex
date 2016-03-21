<?php

$entity = elgg_extract('entity', $vars, false);

if (!elgg_instanceof($entity)) return true;

$location = $entity->getLocation();

if ($location && !empty($location)) {
echo '<div class="elgg-entity-location">';
echo $location;
echo '</div>';
}
<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) return true;

echo '<div class="elgg-entity-time-created">';
echo elgg_echo('hj:framework:entity:created', array(elgg_view_friendly_time($entity->time_created)));
echo '</div>';
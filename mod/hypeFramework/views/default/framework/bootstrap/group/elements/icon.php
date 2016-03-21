<?php

$entity = elgg_extract('entity', $vars, false);
$size = elgg_extract('size', $vars, 'medium');

if (!$entity) return true;

echo '<div class="elgg-entity-icon-wrapper">';
echo elgg_view_entity_icon($entity, $size);
echo '</div>';

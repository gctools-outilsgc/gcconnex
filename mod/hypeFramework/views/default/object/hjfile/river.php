<?php

$entity = elgg_extract('entity', $vars);
$size = elgg_extract('size', $vars);

echo elgg_view_entity_icon($entity, $size);

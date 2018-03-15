<?php
$entity = $vars["entity"];

$icon = elgg_view("icon/default", ["entity" => $entity, "size" => "small"]);
$title = $entity->user["name"];

$params = array(
    "entity" => $vars["entity"],
    "title" => $entity->user["name"],
    "subtitle" => elgg_view("entity/components/subtitle", ["entity" => $vars["entity"]]),
    "metadata" => elgg_view("entity/components/process_access", ["entity" => $vars["entity"]])
);

$params = $params + $vars;
$body = elgg_view("object/elements/summary", $params);

echo elgg_view_image_block($icon, $body, $vars);

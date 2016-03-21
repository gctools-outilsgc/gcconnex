<?php

$entity = elgg_extract("entity", $vars);
$size = elgg_extract("size", $vars);

if (isset($vars["override"]) && $vars["override"] == true) {
	$override = true;
} else {
	$override = false;
}

$allowed_sizes = array("tiny", "small", "medium");
if (!in_array($size, $allowed_sizes)) {
	$size = "small";
}

$icon = elgg_view("output/img", array(
	"src" => $entity->getIconUrl($size),
	"alt" => $entity->title,
	"title" => $entity->title
));

if (!$override) {
	echo "<a href='" . $entity->getURL() . "' class='icon'>";
	echo $icon;
	echo "</a>";
} else {
	echo $icon;
}

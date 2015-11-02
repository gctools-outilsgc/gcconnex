<?php
/**
 * Blog river view.
 */

$object = $vars["item"]->getObjectEntity();

$excerpt = $object->excerpt ? $object->excerpt : $object->description;
$excerpt = elgg_get_excerpt($excerpt);

if ($object->icontime) {
	$message = "<div class='blog-tools-river-item clearfix'>";
	$message .= elgg_view_entity_icon($object, "small");
	$message .= $excerpt;
	$message .= "</div>";
} else {
	$message = $excerpt;
}

echo elgg_view("river/elements/layout", array(
	"item" => $vars["item"],
	"message" => $message
));

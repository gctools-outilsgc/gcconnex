<?php
/**
 * Blog river view.
 */

$lang = get_current_language();
$object = $vars['item']->getObjectEntity();

if ($object->excerpt){
	
	$excerpt = gc_explode_translation($object->excerpt,$lang);

}else{
	
	$excerpt = gc_explode_translation($object->description,$lang);
}

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

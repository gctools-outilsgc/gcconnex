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

$message = $excerpt;
if (!empty($object->icontime)) {
	$icon = elgg_view_entity_icon($object, 'small');
	
	$message = elgg_format_element('div', ['class' => 'blog-tools-river-item clearfix'], $icon . $excerpt);
}

$vars['message'] = $message;
echo elgg_view('river/elements/layout', $vars);

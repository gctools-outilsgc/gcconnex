<?php
/**
* File river view.
*/
$lang = get_current_language();
$file = $vars['entity'];
$object = $vars['item']->getObjectEntity();
$excerpt = gc_explode_translation($object->description,$lang);
$excerpt = strip_tags($excerpt);
$excerpt = elgg_get_excerpt($excerpt);
echo elgg_view('river/elements/layout', array(
  'item' => $vars['item'],
  'message' => $excerpt,
  'attachments' => elgg_view('river/object/file/attachment', array('item' => $vars['item'],)),
));
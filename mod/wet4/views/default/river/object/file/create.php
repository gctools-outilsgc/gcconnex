<?php
/**
* File river view.
*/
$lang = get_current_language();
$file = $vars['entity'];
$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = elgg_get_excerpt($excerpt);
echo elgg_view('river/elements/layout', array(
  'item' => $vars['item'],
  'message' => gc_explode_translation($excerpt,$lang),
  'attachments' => elgg_view('river/object/file/attachment', array('item' => $vars['item'],)),
));
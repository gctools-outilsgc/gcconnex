<?php
/**
 * Post comment on image river view
 */
$object = $vars['item']->getObjectEntity();
$comment = $vars['item']->getAnnotation();

$river_comments_thumbnails = elgg_get_plugin_setting('river_comments_thumbnails', 'tidypics');
if ($river_comments_thumbnails == "small") {
        $image = $vars['item']->getObjectEntity();
        $attachments = elgg_view_entity_icon($image, 'small');
}
else if ($river_comments_thumbnails == "tiny") {
        $image = $vars['item']->getObjectEntity();
        $attachments = elgg_view_entity_icon($image, 'tiny');
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'message' => elgg_get_excerpt($comment->value),
));

<?php
/**
 * Group forum topic create river view.
 *
 * GC_MODIFICATION
 * Description: if someone posts a video link in a discussion it will embed on the wire
 * Author: GCTools Team
 */
$lang = get_current_language();
$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();

//for embeded videos
$test = embed_discussion_river($object->description);

//check to see if video is embeded
if($test){
    $excerpt = str_replace($test, '', $object->description);
    $excerpt = strip_tags($excerpt);
    $excerpt = elgg_get_excerpt($excerpt);
} else {

        $description = gc_explode_translation($object->description, $lang);

    $excerpt = strip_tags($description);
    $excerpt = elgg_get_excerpt($excerpt);
}


$responses = '';
if (elgg_is_logged_in() && $object->canWriteToContainer()) {
	$responses = elgg_view('river/elements/discussion_replies', array('topic' => $object));
}

//place video url in attachments
echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'message' => $excerpt,
	'responses' => $responses,
    'attachments' => elgg_view('output/url', array('href' => $test[0])),
));

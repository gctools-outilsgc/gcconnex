<?php
/**
 * Image word tag river view
 */

$tagger = $vars['item']->getSubjectEntity();
$tagged_image = $vars['item']->getObjectEntity();
$annotation = $vars['item']->getAnnotation();
if (!$annotation) {
	return;
}
$image = get_entity($annotation->entity_guid);
// viewer may not have permission to view image
if (!$image) {
	return;
}
$attachments = elgg_view_entity_icon($image, 'tiny');

$tagger_link = elgg_view('output/url', array(
	'href' => $tagger->getURL(),
	'text' => $tagger->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$image_link = elgg_view('output/url', array(
        'href' => $image->getURL(),
        'text' => $image->getTitle(),
        'is_trusted' => true,
)); 

$value = $annotation->value;
$tag = unserialize($value);
$tag_array = string_to_tag_array($tag->value);
$message = elgg_view('output/tags', array('value' => $tag_array));
if (count($tag_array) > 1) {
        $summary = elgg_echo('image:river:wordtagged', array($tagger_link, $image_link));
} else {
        $summary = elgg_echo('image:river:wordtagged_single', array($tagger_link, $image_link));
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'message' => $message,
	'summary' => $summary
));

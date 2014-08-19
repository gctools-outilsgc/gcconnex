<?php
/**
 * Image tag river view
 */

$tagger = $vars['item']->getSubjectEntity();
$tagged_user = $vars['item']->getObjectEntity();
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
$tagged_link = elgg_view('output/url', array(
	'href' => $tagged_user->getURL(),
	'text' => $tagged_user->name,
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$image_link = elgg_view('output/url', array(
	'href' => $image->getURL(),
	'text' => $image->getTitle(),
	'is_trusted' => true,
)); 

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'summary' => elgg_echo('image:river:tagged', array($tagger_link, $tagged_link, $image_link)),
));


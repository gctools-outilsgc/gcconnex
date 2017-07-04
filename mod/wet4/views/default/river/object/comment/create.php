<?php
/**
 * Post comment river view
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */
$lang = get_current_language();
$comment = $item->getObjectEntity();
$subject = $item->getSubjectEntity();
$target = $item->getTargetEntity();

$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$title_comment = $target->getDisplayName();

$target_link = elgg_view('output/url', array(
	'href' => $comment->getURL(),
	'text' => gc_explode_translation($title_comment,$lang),
	'class' => 'elgg-river-target',
	'is_trusted' => true,
));

$type = $target->getType();
$subtype = $target->getSubtype() ? $target->getSubtype() : 'default';
$key = "river:comment:$type:$subtype";
$summary = elgg_echo($key, array($subject_link, $target_link));
if ($summary == $key) {
	$key = "river:comment:$type:default";
	$summary = elgg_echo($key, array($subject_link, $target_link));
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => elgg_get_excerpt($comment->description),
	'summary' => $summary,
));

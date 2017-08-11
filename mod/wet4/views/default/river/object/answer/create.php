<?php
/**
 * River entry for new answers
 */

$item = elgg_extract('item', $vars);
$lang = get_current_language();

$answer = $item->getObjectEntity();
if (!($answer instanceof ElggAnswer)) {
	return;
}

$subject = $item->getSubjectEntity();
$question = $answer->getContainerEntity();

$subject_link = elgg_view('output/url', [
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
]);

$object_link = elgg_view('output/url', [
	'href' => $question->getURL(),
	'text' => elgg_get_excerpt(gc_explode_translation($question->title,$lang), 100),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
]);

$message = elgg_get_excerpt($answer->description);

echo elgg_view('river/elements/layout', [
	'item' => $item,
	'message' => $message,
	'summary' => elgg_echo('river:create:object:answer', [$subject_link, $object_link]),
]);


<?php
$item = elgg_extract('item', $vars);

$object = $item->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);
$excerpt = thewire_tools_filter($excerpt);
if (substr($excerpt, -3) === '...') {
	// add read more link
	$excerpt .= '&nbsp;' . elgg_view('output/url', [
		'text' => strtolower(elgg_echo('more')),
		'href' => $object->getURL(),
		'is_trusted' => true,
	]);
}

$subject = $item->getSubjectEntity();
$subject_link = elgg_view('output/url', [
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
]);

$object_link = elgg_view('output/url', [
	'href' => "thewire/owner/{$subject->username}",
	'text' => elgg_echo('thewire:wire'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
]);

$summary = elgg_echo('river:create:object:thewire', [$subject_link, $object_link]);

$attachments = '';
$ia = elgg_set_ignore_access(true);
$reshare = $object->getEntitiesFromRelationship(['relationship' => 'reshare', 'limit' => 1]);
elgg_set_ignore_access($ia);

if (!empty($reshare)) {
	$attachments = elgg_view('thewire_tools/reshare_source', ['entity' => $reshare[0]]);
}

echo elgg_view('river/elements/layout', [
	'item' => $item,
	'message' => elgg_view('output/longtext', ['value' => $excerpt]),
	'summary' => $summary,
	'attachments' => $attachments,
]);

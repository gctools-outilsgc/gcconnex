<?php

elgg_push_context('activity');

$item = elgg_extract('item', $vars);

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

$subject_link = elgg_view('framework/bootstrap/user/elements/name', array('entity' => $subject));
$object_link = elgg_view('framework/bootstrap/object/elements/title', array('entity' => $object));

$breadcrumbs = elgg_view('framework/bootstrap/object/elements/breadcrumbs', array('entity' => $object));
if (!empty($breadcrumbs)) {
	$breadcrumbs_link = elgg_echo('river:in:forum', array($breadcrumbs));
}

$key = "river:create:object:hjforum";
$summary = elgg_echo($key, array($subject_link, $object_link)) . $breadcrumbs_link;

echo elgg_view('river/item', array(
	'item' => $item,
	'message' => elgg_get_excerpt(strip_tags($object->description)),
	'summary' => $summary,
));

elgg_pop_context();
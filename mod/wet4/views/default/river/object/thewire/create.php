<?php
/**
 * File river view.
 */

$object = $vars["item"]->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = thewire_tools_filter($excerpt);

$subject = $vars["item"]->getSubjectEntity();
$subject_link = elgg_view("output/url", array(
	"href" => $subject->getURL(),
	"text" => $subject->name,
	"class" => "elgg-river-subject",
	"is_trusted" => true,
));

$object_link = elgg_view("output/url", array(
	"href" => "thewire/owner/$subject->username",
	"text" => elgg_echo("thewire:wire"),
	"class" => "elgg-river-object",
	"is_trusted" => true,
));

$summary = elgg_echo("river:create:object:thewire", array($subject_link, $object_link));

$attachments = "";
$reshare = $object->getEntitiesFromRelationship(array("relationship" => "reshare", "limit" => 1));
if (!empty($reshare)) {
	$attachments = elgg_view("thewire_tools/reshare_source", array("entity" => $reshare[0]));
}

echo elgg_view("river/elements/layout", array(
	"item" => $vars["item"],
	"message" => $excerpt,
	"summary" => $summary,
	"attachments" => $attachments,
));
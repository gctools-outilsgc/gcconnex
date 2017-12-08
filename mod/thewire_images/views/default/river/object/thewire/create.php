<?php
/**
 * File river view.
 */

elgg_load_library('thewire_image');

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

$attachment = thewire_image_get_attachments($object->getGUID());
if ($attachment) {
	$excerpt .= "<div class='mrgn-tp-sm mrgn-lft-sm mrgn-bttm-sm'>";
	$excerpt .= "<a class='elgg-lightbox' href='" . elgg_get_site_url() . 'thewire_image/download/' . $attachment->getGUID() . '/' . $attachment->original_filename . "'>";
	$excerpt .= elgg_view('output/img', array(
		'src' => 'thewire_image/download/' . $attachment->getGUID() . '/' . $attachment->original_filename,
		'alt' => $attachment->original_filename,
		'class' => 'img-thumbnail',
		'style' => "height: 120px; width: auto;"
	));
	$excerpt .= "</a>";
	$excerpt .= "</div>";
}

echo elgg_view("river/elements/layout", array(
	"item" => $vars["item"],
	"message" => $excerpt,
	"summary" => $summary,
	"attachments" => $attachments
));

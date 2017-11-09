<?php
/**
 * Show to what a wire post is linked
 */

elgg_load_library('thewire_image');

$entity = elgg_extract("entity", $vars);

if (empty($entity) || !(elgg_instanceof($entity, "object") || elgg_instanceof($entity, "group"))) {
	return true;
}

$icon = "";
if ($entity->icontime) {
	$icon = elgg_view_entity_icon($entity, "tiny");
}

$url = $entity->getURL();
if ($url === elgg_get_site_url()) {
	$url = false;
}

$text = "";
if (!empty($entity->title)) {
	$text = $entity->title;
} elseif (!empty($entity->name)) {
	$text = $entity->name;
} elseif (!empty($entity->description)) {
	$text = elgg_get_excerpt($entity->description, 140);
} else {
	// no text to display
	return true;
}

$content = "<div class='elgg-subtext'>";
$content .= elgg_echo("thewire_tools:reshare:source") . ": ";
if (!empty($url)) {
	$content .= elgg_view("output/url", array(
		"href" => $url,
		"text" => $text,
		"is_trusted" => true
	));
} else {
	$content .= elgg_view("output/text", array(
		"value" => $text
	));
}

$attachment = thewire_image_get_attachments($entity->getGUID());
if ($attachment) {
	$content .= "<div class='elgg-content mrgn-tp-sm mrgn-lft-sm mrgn-bttm-sm'>";
	$content .= "<a class='elgg-lightbox' href='" . elgg_get_site_url() . 'thewire_image/download/' . $attachment->getGUID() . '/' . $attachment->original_filename . "'>";
	$content .= elgg_view('output/img', array(
		'src' => 'thewire_image/download/' . $attachment->getGUID() . '/' . $attachment->original_filename,
		'alt' => $attachment->original_filename,
		'class' => 'img-thumbnail',
		'style' => "height: 120px; width: auto;"
	));
	$content .= "</a>";
	$content .= "</div>";
}

$content .= "</div>";

echo elgg_view_image_block($icon, $content, array("class" => "mbn"));

<?php
/**
 * Show to what a wire post is linked
 */

$entity = elgg_extract("entity", $vars);

if (empty($entity) || !(elgg_instanceof($entity, "object") || elgg_instanceof($entity, "group"))) {
	return true;
}

$icon = "";
if ($entity->icontime) {
	$icon = elgg_view_entity_icon($entity, "small");
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
$content .= "</div>";

echo elgg_view_image_block($icon, $content, array("class" => "mbn", 'reshare' => true));

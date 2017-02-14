<?php
/**
 * Show to what a wire post is linked
 */
 /*
 * GC_MODIFICATION
 * Description: Added support for content translation titles
 * Author: GCTools Team
 */
$entity = elgg_extract("entity", $vars);
$lang = get_current_language();

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
if(!empty($entity->title3)){
	$text = gc_explode_translation($entity->title3,$lang);
} elseif (!empty($entity->title)) {
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
if(!elgg_instanceof($entity, 'group')){
    $content .= elgg_echo("thewire_tools:reshare:source") . ": ";
}
if (!empty($url)) {
	$content .= elgg_view("output/url", array(
		"href" => $url,
		"text" => htmlspecialchars_decode($text, ENT_QUOTES),
		"is_trusted" => true
	));
} else {
	$content .= elgg_view("output/text", array(
		"value" => $text
	));
}
$content .= "</div>";

echo elgg_view_image_block($icon, $content, array("class" => "mbn", 'reshare' => true));

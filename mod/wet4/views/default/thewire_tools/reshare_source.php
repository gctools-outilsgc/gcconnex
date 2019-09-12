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
$by_link = '';
if ($entity->icontime) {
	$icon = elgg_view_entity_icon($entity, "small");
	if(elgg_instanceof($entity, 'group')) {
		$mem = ($entity->isPublicMembership()) ? elgg_echo('groups:open') : elgg_echo('groups:closed');
		$by_link = '<div>'.elgg_echo('group') . ' - '. $mem . '</div>';
	}
} else if(in_array($entity->getSubtype(), array('comment', 'discussion_reply', 'thewire', 'answer', 'blog', 'bookmarks', 'mission', 'groupforumtopic', 'poll'))){
	$owner = $entity->getOwnerEntity();
	$icon = elgg_view_entity_icon($owner, 'small');
	$owner_link = elgg_view('output/url', array(
		'href' => "profile/$owner->username",
		'text' => $owner->name,
	));
	$by_link = '<div>'.elgg_echo('wet:reshare:'.$entity->getSubtype()) . ' - ' . elgg_echo('byline', array($owner_link)) .'</div>';
}else {
	$icon = elgg_view_entity_icon($entity, "small");
	if(elgg_instanceof($entity, 'group')) {
		$mem = ($entity->isPublicMembership()) ? elgg_echo('groups:open') : elgg_echo('groups:closed');
		$by_link = '<div>'.elgg_echo('group') . ' - '. $mem . '</div>';
	} else {
		$by_link = '<div>'.elgg_echo('wet:reshare:' .$entity->getSubtype()).'</div>';
	}
}

$url = $entity->getURL();
if ($url === elgg_get_site_url()) {
	$url = false;
}

$text = "";
if(!empty($entity->title)){
	$text = gc_explode_translation($entity->title,$lang);
}elseif (!empty($entity->name)) {
	$text = $entity->name;
} elseif (!empty($entity->description)) {
	$text = elgg_get_excerpt($entity->description, 140);
} else {
	// no text to display
	return true;
}

$content = "<div class='elgg-subtext mrgn-lft-md'>";
/*
if(!elgg_instanceof($entity, 'group')){
    $content .= elgg_echo("thewire_tools:reshare:source") . ": ";
}
*/
if (!empty($url)) {
	$content .= elgg_view("output/url", array(
		"href" => $url,
		"text" => '<b>' .htmlspecialchars_decode($text, ENT_QUOTES) .'</b>',
		"is_trusted" => true
	));
} else {
	$content .= elgg_view("output/text", array(
		"value" => $text,
	));
}
$content .= $by_link;
$content .= "</div>";

echo elgg_format_element('div', ['class' => 'd-flex'], $icon . $content);
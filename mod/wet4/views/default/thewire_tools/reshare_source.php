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
	// $icon = elgg_view_entity_icon($entity, "small", array('use_link' => false,));
	$icon = elgg_view('output/img', array(
		'src' => $entity->getIconURL('small'),
		'alt' => '',
		'class' => 'img-responsive',
	));
	if(elgg_instanceof($entity, 'group')) {
		$mem = ($entity->isPublicMembership()) ? elgg_echo('groups:open') : elgg_echo('groups:closed');
		$by_link = '<div>'.elgg_echo('group') . ' - '. $mem . '</div>';
	}
} else if(in_array($entity->getSubtype(), array('comment', 'discussion_reply', 'thewire', 'answer', 'blog', 'bookmarks', 'mission', 'groupforumtopic', 'poll'))){
	$owner = $entity->getOwnerEntity();
	$icon = elgg_view_entity_icon($owner, 'small', array('use_link' => false, 'use_hover' => false,));
	if ($entity->getSubtype() === 'thewire'){
		// Style this like the wire
		$by_link = '<div class="mrgn-bttm-sm" style="color:#137991;">'.$owner->name.' - <span class="timeStamp">'.elgg_view_friendly_time($entity->time_created).'</span></div>';
	} else {
		$by_link = '<div>'.elgg_echo('wet:reshare:'.$entity->getSubtype()) . ' - ' . elgg_echo('byline', array($owner->name)) .'</div>';
	}
}else {
	$icon = elgg_view('output/img', array(
		'src' => $entity->getIconURL('small'),
		'alt' => '',
		'class' => 'img-responsive',
	));
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
if($entity->getSubtype() === 'thewire') {
	// Style this like a wire post
	$content .= $by_link;
	$content .= '<div>'.$text.'</div>';
} else {
	$content .= '<div class="wire-reshare-title">'.$text.'</div>';
	$content .= $by_link;
}
$content .= "</div>";

echo elgg_format_element('div', ['class' => 'd-flex'], $icon . $content);
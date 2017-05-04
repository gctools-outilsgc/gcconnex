<?php
/**
 * Elgg comment view
 *
 * @uses $vars['entity']    ElggComment
 * @uses $vars['full_view'] Display full view or brief view
 *
 * GC_MODIFICATION
 * Description: Layout changes / added wet and bootstrap classes
 * Author: GCTools Team
 */

$full_view = elgg_extract('full_view', $vars, true);
$lang = get_current_language();
$comment = $vars['entity'];

$entity = get_entity($comment->container_guid);
$commenter = get_user($comment->owner_guid);
if (!$entity || !$commenter) {
	return true;
}

$friendlytime = elgg_view_friendly_time($comment->time_created);

//check if the icon is in a widget and make it small!
if(elgg_get_context() !== 'widgets'){
$commenter_icon = elgg_view_entity_icon($commenter, 'medium');
}else{
  $commenter_icon = elgg_view_entity_icon($commenter, 'small');  
}


$commenter_link = "<a href=\"{$commenter->getURL()}\">$commenter->name</a>";

$entity_title = $entity->title ? gc_explode_translation($entity->title,$lang) : elgg_echo('untitled');
$entity_link = "<a href=\"{$entity->getURL()}\">$entity_title</a>";

if ($full_view) {
    
    
	$anchor = "<a name=\"comment-{$comment->getGUID()}\"></a>";

	$menu = elgg_view_menu('entity', array(
		'entity' => $comment,
		'handler' => 'comment',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz float-alt',
        'item_class' => 'mrgn-lft-sm',
	));
	
	if (elgg_in_context('activity')) {

		$comment_text = '<div class="elgg-output elgg-inner" data-role="comment-text">';
		$comment_text .= elgg_view('output/text', array(
			'value' => elgg_get_excerpt($comment->description),
		));
		$comment_text .= '</div>';
	} else {
		$comment_text = elgg_view('output/longtext', array(
			'value' => $comment->description,
			'class' => 'elgg-inner mrgn-tp-md comment-container',
			'data-role' => 'comment-text',
		));
	}
	$body = <<<HTML
$anchor
<div class="mbn">
	$menu
	$commenter_link
	<span class="timeStamp">
		$friendlytime
	</span>
	$comment_text
</div>
HTML;

	echo elgg_view_image_block($commenter_icon, $body);

} else {
	// brief view

	$excerpt = elgg_get_excerpt($comment->description, 80);
	$posted = elgg_echo('generic_comment:on', array($commenter_link, $entity_link));

	$body = <<<HTML
<span class="elgg-subtext">
	$posted ($friendlytime): $excerpt
</span>
HTML;

	echo elgg_view_image_block($commenter_icon, $body);
}

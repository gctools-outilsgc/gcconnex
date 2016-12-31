<?php
/**
 * View for page object
 *
 * @package ElggPages
 *
 * @uses $vars['entity']    The page object
 * @uses $vars['full_view'] Whether to display the full view
 * @uses $vars['revision']  This parameter not supported by elgg_view_entity()
 *
 * GC_MODIFICATION
 * Description: Styling to object and entity menu
 * Author: GCTools Team
 */


$full = elgg_extract('full_view', $vars, FALSE);
$page = elgg_extract('entity', $vars, FALSE);
$revision = elgg_extract('revision', $vars, FALSE);
$lang = get_current_language();

if (!$page) {
	return TRUE;
}

// pages used to use Public for write access
if ($page->write_access_id == ACCESS_PUBLIC) {
	// this works because this metadata is public
	$page->write_access_id = ACCESS_LOGGED_IN;
}


if ($revision) {
	$annotation = $revision;
} else {
	$annotation = $page->getAnnotations(array(
		'annotation_name' => 'page',
		'limit' => 1,
		'reverse_order_by' => true,
	));
	if ($annotation) {
		$annotation = $annotation[0];
	} else {
		elgg_log("Failed to access annotation for page with GUID {$page->guid}", 'WARNING');
		return;
	}
}

$page_icon = elgg_view('pages/icon', array('annotation' => $annotation, 'size' => 'small'));

$editor = get_entity($annotation->owner_guid);
$editor_link = elgg_view('output/url', array(
	'href' => "pages/owner/$editor->username",
	'text' => $editor->name,
	'is_trusted' => true,
));

$date = elgg_view_friendly_time($annotation->time_created);
$editor_text = elgg_echo('pages:strapline', array($date, $editor_link));
$categories = elgg_view('output/categories', $vars);

$comments_count = $page->countComments();
//only display if there are commments
if ($comments_count != 0 && !$revision) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $page->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$subtitle = "$editor_text $comments_link $categories";

// do not show the metadata and controls in widget view
if (!elgg_in_context('widgets')) {
	// If we're looking at a revision, display annotation menu
	if ($revision) {
		$metadata = elgg_view_menu('annotation', array(
			'annotation' => $annotation,
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz float-alt',
		));
	} else {
		// Regular entity menu
		$metadata = elgg_view_menu('entity', array(
			'entity' => $vars['entity'],
			'handler' => 'pages',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz list-inline',
            'item_class' => 'mrgn-rght-sm',
		));
	}
}

if ($full) {

	//Identify available content
	if(($page->description2) && ($page->description)){
		echo'<div id="change_language" class="change_language">';
		if (get_current_language() == 'fr'){

			?>			
			<span id="indicator_language_en" onclick="change_en('.elgg-output');"><span id="en_content" class="testClass hidden" ><?php echo clean_up_content($page->description);?></span><span id="fr_content" class="testClass hidden" ><?php echo clean_up_content($page->description2);?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			<?php

		}else{
					
			?>			
			<span id="indicator_language_fr" onclick="change_fr('.elgg-output');"><span id="en_content" class="testClass hidden" ><?php echo clean_up_content($page->description);?></span><span id="fr_content" class="testClass hidden" ><?php echo clean_up_content($page->description2);?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
			<?php	
		}
		echo'</div>';
	}

	if ($page->description3){
		$annotation->value = gc_explode_translation(clean_up_content($page->description3), $lang);
	}
	$body = elgg_view('output/longtext', array('value' => $annotation->value));

	$params = array(
		'entity' => $page,
        'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $page,
		'title' => false,
		'icon' => $page_icon,
		'summary' => $summary,
		'body' => $body,
	));

} else {

	// identify available content
/*	if(($page->description2) && ($page->description)){
			
		echo'<span class="col-md-1 col-md-offset-11"><i class="fa fa-language fa-lg mrgn-rght-sm"></i>' . '<span class="wb-inv">Content available in both language</span></span>';	
	}*/

	// brief view
if($page->description3){
	$excerpt = elgg_get_excerpt(gc_explode_translation($page->description3, $lang));
}else{
	$excerpt = elgg_get_excerpt($page->description);
}
	

    if(elgg_in_context('group_profile')){
        $metadata = elgg_view_menu('entity', array(
			'entity' => $vars['entity'],
			'handler' => 'pages',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz list-inline',
            'item_class' => 'mrgn-rght-sm',
		));
    }

	$params = array(
		'entity' => $page,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($page_icon, $list_body);
}

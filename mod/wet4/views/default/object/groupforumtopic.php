<?php
/**
 * Forum topic entity view
 *
 * @package ElggGroups
 *
 * GC_MODIFICATION
 * Description: changes to layout and styling /add wet classes
 * Author: GCTools Team
*/

$full = elgg_extract('full_view', $vars, FALSE);
$topic = elgg_extract('entity', $vars, FALSE);
$lang = get_current_language();

if (!$topic) {
	return;
}

$poster = $topic->getOwnerEntity();
if (!$poster) {
	elgg_log("User {$topic->owner_guid} could not be loaded, and is needed to display entity {$topic->guid}", 'WARNING');
	if ($full) {
		forward('', '404');
	}
	return;
}
	$excerpt = elgg_get_excerpt(gc_explode_translation($topic->description, $lang));
	$description = gc_explode_translation($topic->description, $lang);




$poster_icon = elgg_view_entity_icon($poster, 'medium');
$poster_link = elgg_view('output/url', array(
	'href' => $poster->getURL(),
	'text' => $poster->name,
	'is_trusted' => true,
));

$poster_text = elgg_echo('groups:started', array($poster_link));
//$poster_text = elgg_echo('groups:started', array($poster->name));

$tags = elgg_view('output/tags', array('tags' => $topic->tags));
$date = elgg_view_friendly_time($topic->time_created);

$replies_link = '';
$reply_text = '';

$num_replies = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'discussion_reply',
	'container_guid' => $topic->getGUID(),
	'count' => true,
	'distinct' => false,
));

if ($num_replies != 0) {
	$last_reply = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'discussion_reply',
		'container_guid' => $topic->getGUID(),
		'limit' => 1,
		'distinct' => false,
	));
	if (isset($last_reply[0])) {
		$last_reply = $last_reply[0];
	}

	$poster = $last_reply->getOwnerEntity();
    
    
    //added to get link of person who replied
    $poster_reply_link = elgg_view('output/url', array(
        'href' => $poster->getURL(),
        'text' => $poster->name,
        'is_trusted' => true,
    ));
    
	$reply_time = elgg_view_friendly_time($last_reply->time_created);
	$reply_text = elgg_echo('groups:updated', array($poster_reply_link, $reply_time));


	$replies_link = elgg_view('output/url', array(
		'href' => $topic->getURL() . '#group-replies',
		'text' => "$num_replies " . elgg_echo('group:replies'),
		'is_trusted' => true,
	));
}

// We are showing the meta data and the ability to share and like from the widget view 
if (elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'discussion',
		'sort_by' => 'priority',
		'class' => 'list-inline',
        'item_class' => 'mrgn-rght-sm',
	));
} else {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'discussion',
		'sort_by' => 'priority',
		'class' => 'list-inline',
        'item_class' => 'mrgn-rght-sm',
	));
}

if ($full) {
    // $replies_link - went here
	$subtitle = "$poster_text $date ";

// identify available content
$description_json = json_decode($topic->description);
$title_json = json_decode($topic->title);

if( $description_json->en && $description_json->fr ){

	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>			
		<span id="indicator_language_en" onclick="change_en('.content_desc', '.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>

	<?php
	}else{
				
		?>			
		<span id="indicator_language_fr" onclick="change_fr('.content_desc','.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>

		<?php	
	}
	echo'</div>';
}

	$params = array(
		'entity' => $topic,
        'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	$info = elgg_view_image_block($poster_icon, $list_body);

	$body = elgg_view('output/longtext', array(
		'value' => $description,
		'class' => 'clearfix mrgn-lft-sm mrgn-rght-sm mrgn-tp-md content_desc',
	));
    
    $repliesFoot = '<div class="col-xs-12 text-right">' . $replies_link . '</div>';

	echo <<<HTML
<div class="panel-heading clearfix">$info</div>
$body
$repliesFoot
HTML;

    echo elgg_view('wet4_theme/track_page_entity', array('entity' => $topic));

} else {
	// brief view
	$subtitle = "<p class=\"mrgn-tp-sm mrgn-bttm-0\">$poster_text $date</p> <p class=\"mrgn-bttm-sm\">$reply_text</p> $replies_link";

	// identify available content
/*	if(($topic->description2) && ($topic->description)){
			
		echo'<span class="col-md-1 col-md-offset-11"><i class="fa fa-language fa-lg mrgn-rght-sm"></i>' . '<span class="wb-inv">Content available in both language</span></span>';
	}*/

	$params = array(
		'entity' => $topic,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($poster_icon, $list_body);
}
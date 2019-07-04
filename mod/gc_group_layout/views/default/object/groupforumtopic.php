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




$poster_icon = elgg_view_entity_icon($poster, 'tiny');
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

	$format_full_image = elgg_format_element('div', [], $poster_icon . $subtitle);
	$body = elgg_view('output/longtext', array(
		'value' => $description,
		'class' => 'clearfix content_desc',
	));
    
  $repliesFoot = '<div class="col-xs-12 text-right">' . $replies_link . '</div>';

	echo <<<HTML
	<div class="panel">
	<div class="panel-body">
<div class="mrgn-bttm-md">$body</div>
<div>$tags</div>
<div class="mrgn-tp-sm">$format_full_image</div>
<div class="mrgn-tp-md">$metadata</div>
</div>
</div>
HTML;

    echo elgg_view('wet4_theme/track_page_entity', array('entity' => $topic));

} else {
	// brief view - made my own instead of relying on the image block
	$subtitle = "<div class=\"mrgn-lft-sm\"><div>$poster_text $date</div></div>";
  $title_link = elgg_extract('title', $vars, '');
  if ($title_link === '') {//add translation
    if ( isset($topic->title) || isset($topic->name) ) {
      if( $topic->title ){
        $text = gc_explode_translation( $topic->title, $lang );
      }elseif($topic->name){
        $text = $topic->name;
      }elseif($topic->name2){
        $text = $topic->name2;
      }
  
    } else {
      $text = gc_explode_translation($topic->title3, $lang);
    }
    if ($topic instanceof ElggEntity) {
      $params = array(
        'text' => elgg_get_excerpt($text, 100),
        'href' => $topic->getURL(),
        'is_trusted' => true,
      );
    }
    $title_link = elgg_view('output/url', $params);
  }
  $format_subtitle = elgg_format_element('div', ['class' => 'd-flex mrgn-tp-md'], $poster_icon . $subtitle);
  $format_title = elgg_format_element('h3', ['class' => 'mrgn-tp-0 mrgn-bttm-md'], $title_link);
  $format_metadata = elgg_format_element('div', ['class' => 'mrgn-tp-md'], $metadata);
	$image_block_body = elgg_format_element('div', ['class' => 'panel-body'], $format_title . $excerpt . $format_subtitle . $replies_link . $format_metadata);
	$format_image_block = elgg_format_element('div', ['class' => 'panel'], $image_block_body);
  echo $format_image_block;
}
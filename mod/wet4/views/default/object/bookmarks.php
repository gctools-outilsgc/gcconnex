<?php
/**
 * Elgg bookmark view
 *
 * @package ElggBookmarks
 *
 * GC_MODIFICATION
 * Description: Changing style / adding font awesome icons / adding wet classes
 * Author: GCTools Team
 */

$full = elgg_extract('full_view', $vars, FALSE);
$bookmark = elgg_extract('entity', $vars, FALSE);
$lang = get_current_language();
if (!$bookmark) {
	return;
}

$owner = $bookmark->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$categories = elgg_view('output/categories', $vars);

$link = elgg_view('output/url', array('href' => $bookmark->address));

$json = json_decode($bookmark->description);
$title_json = json_decode($bookmark->title);
$description = elgg_view('output/longtext', array('value' => gc_explode_translation( $bookmark->description, $lang ), 'class' => 'pbl'));

$owner_link = elgg_view('output/url', array(
	'href' => "bookmarks/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($bookmark->time_created);

$comments_count = $bookmark->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $bookmark->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'bookmarks',
	'sort_by' => 'priority',
	'class' => 'list-inline mrgn-tp-md',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

	$params = array(
		'entity' => $bookmark,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	// identify available content
	if(($json->en) && ($json->fr)){
		echo'<div id="change_language" class="change_language">';
		
		if (get_current_language() == 'fr'){
			
			?>
		<span id="indicator_language_en" onclick="change_en('.pbl', '.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $json->fr;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			<?php

		}else{
			
			?>
		<span id="indicator_language_fr" onclick="change_fr('.pbl','.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $json->fr;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>

			<?php	
		}
		echo'</div>';
	}

	$bookmark_icon = '<span class="fa fa-link mrgn-rght-md"></span>';
	$body = <<<HTML
<div class="bookmark elgg-content mts">
	$bookmark_icon<span class="elgg-heading-basic mbs">$link</span>
	<div class="mrgn-tp-md">$description</div>
</div>
HTML;
	echo elgg_format_element('div', ['class' => 'panel'], '<div class="panel-body">'. $body. $summary .'</div>');

} elseif (elgg_in_context('gallery')) {
	echo <<<HTML
<div class="bookmarks-gallery-item">
	<h3>gc_explode_translation( $bookmark->title, $lang )</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;
} else {
	// brief view
	$url = $bookmark->address;
	$display_text = $url;
	
	$excerpt = elgg_get_excerpt( gc_explode_translation($bookmark->description, $lang) );
	
	if ($excerpt) {
		$excerpt = " - $excerpt";
	}

	// identify available content

	if (strlen($url) > 25) {
		$bits = parse_url($url);
		if (isset($bits['host'])) {
			$display_text = $bits['host'];
		} else {
			$display_text = elgg_get_excerpt($url, 100);
		}
	}

	$title_link = elgg_view('output/url', array(
		"text" => gc_explode_translation($bookmark->title, $lang),
		"href" => $bookmark->getURL(),
	));

	$link = elgg_view('output/url', array(
		'href' => $bookmark->address,
		'text' => $display_text,
	));

	$content = '<span class="fa fa-link mrgn-rght-md"></span>' . "$link{$excerpt}";

    if(elgg_in_context('group_profile')){
        $metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'bookmarks',
	'sort_by' => 'priority',
	'class' => 'list-inline mrgn-tp-md',
));
    }

	$params = array(
		'entity' => $bookmark,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	$format_title = elgg_format_element('h3', ['class' => 'mrgn-tp-0 mrgn-bttm-md'], $title_link);
	$format_subtitle = elgg_format_element('div', ['class'=>'d-flex mrgn-tp-md'], $owner_icon . '<div class="mrgn-lft-sm">'. $subtitle .'</div>');
	$format_panel_body = elgg_format_element('div', ['class'=>'panel-body'], $format_title . $link . $format_subtitle . $metadata);
	echo elgg_format_element('div', ['class'=>'panel'], $format_panel_body);
}

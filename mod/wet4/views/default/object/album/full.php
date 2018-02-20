<?php
/**
 * Full view of an album
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 *
 * GC_MODIFICATION
 * Description: wet classes and layout changes
 * Author: GCTools Team
 */
$lang = get_current_language();
$album = elgg_extract('entity', $vars);
$owner = $album->getOwnerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'medium');

$metadata = elgg_view_menu('entity', array(
	'entity' => $album,
	'handler' => 'photos',
	'sort_by' => 'priority',
	'class' => 'list-inline',
));

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($album->time_created);
$categories = elgg_view('output/categories', $vars);

$subtitle = "$author_text $date $categories";

$params = array(
	'entity' => $album,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => elgg_view('output/tags', array('tags' => $album->tags)),
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

$description = gc_explode_translation( $album->description, $lang );

$body = '';
if ( $album->description ) {
	$body = elgg_view('output/longtext', array(
		'value' => $description,
		'class' => 'mbm mrgn-bttm-lg',
	));
}

$body .= $album->viewImages();

if (elgg_get_plugin_setting('album_comments', 'tidypics')) {
	//$body .= elgg_view_comments($album);
}

$description_json = json_decode($album->description);
$title_json = json_decode($album->title);

if( $description_json->en && $description_json->fr ){
	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>		
		<span id="indicator_language_en" onclick="change_en('.elgg-output', '.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
	
		<?php
	}else{
		?>		
		<span id="indicator_language_fr" onclick="change_fr('.elgg-output','.title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
			
		<?php	
	}
	echo'</div>';
}


echo elgg_view('object/elements/full', array(
	'entity' => $album,
	'icon' => $owner_icon,
	'summary' => $summary,
	'body' => $body,
));

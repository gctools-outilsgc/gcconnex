<?php
/**
 * View for blog objects
 *
 * @package Blog
 *
 * GC_MODIFICATION
 * Description: add wet and bootstrap classes
 * Author: GCTools Team
 */

$lang = get_current_language();
$full = elgg_extract('full_view', $vars, FALSE);
$blog = elgg_extract('entity', $vars, FALSE);

if (!$blog) {
	return TRUE;
}

$owner = $blog->getOwnerEntity();
$container = $blog->getContainerEntity();
$categories = elgg_view('output/categories', $vars);


	$excerpt = gc_explode_translation($blog->excerpt,$lang);


if (empty($excerpt)) {

	$excerpt = elgg_get_excerpt(gc_explode_translation($blog->description, $lang));

}

//test to see if it is widget view
if(elgg_get_context() !== 'widgets'){
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
}else{
   
   $owner_icon = elgg_view_entity_icon($owner, 'small'); 
    
}

$owner_link = elgg_view('output/url', array(
	'href' => "profile/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

// add container text
if (elgg_instanceof($container, "group") && ($container->getGUID() !== elgg_get_page_owner_guid())) {
	$params = array(
		'href' => $container->getURL(),
		'text' => gc_explode_translation($container->title, $lang),
		'is_trusted' => true
	);
	$group_link = elgg_view('output/url', $params);
	$author_text .= " " . elgg_echo('river:ingroup', array($group_link));
}

$tags = elgg_view('output/tags', array('tags' => $blog->tags));
$date = elgg_view_friendly_time($blog->time_created);

$info_class = "";
$blog_icon = "";
$title = "";

// show icon
if (!empty($blog->icontime)) {
	$params = $vars;
	$params["plugin_settings"] = true;

	$blog_icon = elgg_view_entity_icon($blog, "dummy", $params);
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $blog,
	'handler' => 'blog',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz list-inline',
));

$subtitle = "$author_text $date $categories";

// Show blog
if ($full) {
	// full view
	// identify available content
$description_json = json_decode($blog->description);
$title_json = json_decode($blog->title);


if( $description_json->en && $description_json->fr ){
	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>			
		
		<span id="indicator_language_en" onclick="change_en('.blog-post', '.title');"><span id="fr_title" class="testClass hidden" ><?php echo ($title_json->fr ? $title_json->fr : $title_json->en) ;?></span><span id="en_title" class="testClass hidden" ><?php echo ($title_json->en ? $title_json->en : $title_json->fr) ;?></span><span id="en_content" class="testClass hidden" ><?php echo ($description_json->en ? $description_json->en : $description_json->fr)?></span><span id="fr_content" class="testClass hidden" ><?php echo ($description_json->fr ? $description_json->fr : $description_json->en);?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			
		<?php
	}else{
		?>		
			
		<span id="indicator_language_fr" onclick="change_fr('.blog-post','.title');"><span id="fr_title" class="testClass hidden" ><?php echo ($title_json->fr ? $title_json->fr : $title_json->en);?></span><span id="en_title" class="testClass hidden" ><?php echo ($title_json->en ? $title_json->en : $title_json->fr);?></span><span id="en_content" class="testClass hidden" ><?php echo ($description_json->en ? $description_json->en : $description_json->fr)?></span><span id="fr_content" class="testClass hidden" ><?php echo ($description_json->fr ? $description_json->fr : $description_json->en);?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
		<?php	
	}
	echo'</div>';
}

	$blog_descr = gc_explode_translation($blog->description, $lang);

 	$body = elgg_view('output/longtext', array(
		'value' => $blog_descr,
		'class' => 'blog-post',
	));

	$format_full_subtitle = elgg_format_element('div', ['class' => 'd-flex mrgn-tp-md mrgn-bttm-md'], $owner_icon . '<div class="mrgn-lft-sm">' .$subtitle. '</div>');
	$format_full_blog = elgg_format_element('div', ['class' => 'panel-body'], $body . $tags . $format_full_subtitle . $metadata);
	echo elgg_format_element('div', ['class' => 'panel'], $format_full_blog);
  echo '<div id="group-replies" class="elgg-comments clearfix">';
    
} else {

	// how to show strapline
	if (elgg_in_context("listing")) {
		$excerpt = "";
		$blog_icon = "";
	} elseif (elgg_in_context("simple")) {
		$owner_icon = "";
		$tags = false;
		$subtitle = "";
		$title = false;

		// prepend title to the excerpt
		$title_link = "<h3>" . elgg_view("output/url", array("text" => gc_explode_translation($blog->title, $lang), "href" => $blog->getURL())) . "</h3>";
		$excerpt = $title_link . $excerpt;

		// add read more link
		if (substr($excerpt, -3) == "...") {
			$read_more = elgg_view("output/url", array("text" => elgg_echo("blog_tools:readmore"), "href" => $blog->getURL()));
			$excerpt .= " " . $read_more;
		}
	} elseif (elgg_get_plugin_setting("listing_strapline", "blog_tools") == "time") {
		$subtitle = "";
		$tags = false;

		$excerpt = date("F j, Y", $blog->time_created) . " - " . $excerpt;
	}
	$title_link = "<h3 class='mrgn-tp-0 mrgn-bttm-md'>" . elgg_view("output/url", array("text" => gc_explode_translation($blog->title, $lang), "href" => $blog->getURL())) . "</h3>";

	// prepend icon
	$excerpt = $blog_icon . $excerpt;

	// echo elgg_view_image_block($owner_icon, $list_body);
	$format_subtitle = elgg_format_element('div', ['class' => 'd-flex mrgn-tp-md'], $owner_icon . '<div class="mrgn-lft-sm">' . $subtitle . '</div>');
	$format_panel_body = elgg_format_element('div', ['class' => 'panel-body'], $title_link . $excerpt . $format_subtitle . '<div class="mrgn-tp-md">' .$metadata.'</div>');
	echo elgg_format_element('div', ['class' => 'panel'], $format_panel_body);
	
}
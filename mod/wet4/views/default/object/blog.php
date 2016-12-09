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

if($blog->excerpt3){
	$excerpt = gc_explode_translation($blog->excerpt3,$lang);
}else{
	$excerpt = $blog->excerpt;
}

if (empty($excerpt)) {
	if($blog->description3){
		$excerpt = elgg_get_excerpt(gc_explode_translation($blog->description3, $lang));
	}else{
		$excerpt = elgg_get_excerpt($blog->description);
	}
}

//test to see if it is widget view
if(elgg_get_context() !== 'widgets'){
$owner_icon = elgg_view_entity_icon($owner, 'medium');
}else{
   
   $owner_icon = elgg_view_entity_icon($owner, 'small'); 
    
}

$owner_link = elgg_view('output/url', array(
	'href' => "blog/owner/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

// add container text
if (elgg_instanceof($container, "group") && ($container->getGUID() !== elgg_get_page_owner_guid())) {
	$params = array(
		'href' => $container->getURL(),
		'text' => gc_explode_translation($container->title3, $lang),
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

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
    //$metadata = '';
}

// Show blog
if ($full) {
	// full view
	// identify available content
	if(($blog->description2) && ($blog->description)){
		echo'<div id="change_language" class="change_language">';
		if (get_current_language() == 'fr'){
			
			?>			
			<span id="indicator_language_en" onclick="change_en('.blog-post');"><span id="en_content" class="testClass hidden" ><?php echo $blog->description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $blog->description2;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			<?php

		}else{
					
			?>			
			<span id="indicator_language_fr" onclick="change_fr('.blog-post');"><span id="en_content" class="testClass hidden" ><?php echo $blog->description;?></span><span id="fr_content" class="testClass hidden" ><?php echo $blog->description2;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
			<?php	
		}
		echo'</div>';
	}

	if($blog->description3){
		$blog_descr = gc_explode_translation($blog->description3, $lang);
	}else{
		$blog_descr = $blog->description;
	}
 	$body = elgg_view('output/longtext', array(
		'value' => $blog_descr,
		'class' => 'blog-post',
	));

	$header = elgg_view_title($blog->title);

	$params = array(
		'entity' => $blog,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view("object/elements/full", array(
        'entity' => $blog,
		"summary" => $summary,
		"icon" => $owner_icon,
		"body" => $blog_icon . $body,
	));

    echo '<div id="group-replies" class="elgg-comments mrgn-rght-md mrgn-lft-md clearfix">';
    
} else {

	// identify available content
/*	if(($blog->description2) && ($blog->description)){
			
		echo'<span class="col-md-1 col-md-offset-11"><i class="fa fa-language fa-lg mrgn-rght-sm"></i>' . '<span class="wb-inv">Content available in both language</span></span>';	
	}*/
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
		$title_link = "<h3>" . elgg_view("output/url", array("text" => $blog->title, "href" => $blog->getURL())) . "</h3>";
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

	// prepend icon
	$excerpt = $blog_icon . $excerpt;

	// brief view
	$params = array(
		'entity' => $blog,
		'title' => $title,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);

	$params = $params + $vars;

	$list_body = elgg_view('object/elements/summary', $params);
    

	echo elgg_view_image_block($owner_icon, $list_body);

	

}
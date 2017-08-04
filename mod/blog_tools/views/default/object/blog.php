<?php
/**
 * View for blog objects
 *
 * @package Blog
 */

$full = (bool) elgg_extract('full_view', $vars, FALSE);
$blog = elgg_extract('entity', $vars, FALSE);

if (!$blog) {
	return TRUE;
}

$owner = $blog->getOwnerEntity();
$container = $blog->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $blog->excerpt;
if (empty($excerpt)) {
	$excerpt = elgg_get_excerpt($blog->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');

$vars['owner_url'] = "blog/owner/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars);

// The "on" status changes for comments, so best to check for !Off
$comments_link = '';
if ($blog->comments_on != 'Off') {
	$comments_count = $blog->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo('comments') . " ($comments_count)";
		$comments_link = elgg_view('output/url', [
			'href' => "{$blog->getURL()}#comments",
			'text' => $text,
			'is_trusted' => true,
		]);
	}
}

$subtitle = "$by_line $comments_link $categories";

$tags = elgg_view('output/tags', [
	'tags' => $blog->tags,
]);

$info_class = '';
$blog_icon = '';
$title = '';

// show icon
if (!empty($blog->icontime)) {
	$params = $vars;
	$params['plugin_settings'] = true;
	
	$blog_icon = elgg_view_entity_icon($blog, 'dummy', $params);
}

$metadata = '';
if (!elgg_in_context('widgets')) {
	// show the metadata and controls in outside widget view
	$metadata = elgg_view_menu('entity', [
		'entity' => $blog,
		'handler' => 'blog',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

// Show blog
if ($full) {
	// full view
	$body = elgg_view('output/longtext', array(
		'value' => $blog->description,
		'class' => 'blog-post',
	));
	
	$params = array(
		'entity' => $blog,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	echo elgg_view('object/elements/full', array(
		'entity' => $blog,
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $blog_icon . $body,
	));
} else {
	// how to show strapline
	if (elgg_in_context('listing')) {
		$excerpt = '';
		$blog_icon = '';
	} elseif (elgg_in_context('simple')) {
		$owner_icon = '';
		$tags = false;
		$subtitle = '';
		$title = false;
		
		// prepend title to the excerpt
		$title_link = elgg_format_element('h3', [], elgg_view('output/url', [
			'text' => $blog->title,
			'href' => $blog->getURL(),
			'is_trusted' => true,
		]));
		$excerpt = $title_link . $excerpt;
		
		// add read more link
		if (substr($excerpt, -3) === '...') {
			$read_more = elgg_view('output/url', [
				'text' => elgg_echo('blog_tools:readmore'),
				'href' => $blog->getURL(),
				'is_trusted' => true,
			]);
			$excerpt .= ' ' . $read_more;
		}
	} elseif (elgg_get_plugin_setting('listing_strapline', 'blog_tools') === 'time') {
		$subtitle = '';
		$tags = false;
		
		$excerpt = date('F j, Y', $blog->time_created) . ' - ' . $excerpt;
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

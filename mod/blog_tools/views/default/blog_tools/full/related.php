<?php
/**
 * shows a list of blogs related to this blog
 *
 * @uses $vars['entity'] the blog to base the related blogs on
 * @uses $vars['full_view'] only in full view
 * @uses get_input('guid') in the sidebar view we don't have $vars['entity']
 */

$entity = elgg_extract('entity', $vars);
$full_view = (bool) elgg_extract('full_view', $vars, false);

$sidebar = false;

if (!empty($entity) && !$full_view) {
	return;
}

if (empty($entity)) {
	$guid = (int) get_input('guid');
	
	$entity = get_entity($guid);
	if (!($entity instanceof ElggBlog)) {
		return;
	}
	$sidebar = true;
}

if (empty($entity->tags)) {
	return;
}

$setting = elgg_get_plugin_setting('show_full_related', 'blog_tools');

if (!$sidebar && ($setting !== 'full_view')) {
	return;
} elseif ($sidebar && ($setting !== 'sidebar')) {
	return;
}

$blogs = blog_tools_get_related_blogs($entity);
if (empty($blogs)) {
	return;
}

$title = elgg_echo('blog_tools:view:related');

$icon_size = 'medium';
$excerpt_length = 120;

if ($sidebar) {
	$icon_size = 'small';
	$excerpt_length = 50;
}

$content = '';
	
foreach ($blogs as $blog) {
	
	$blog_title = $blog->title;
	$blog_excerpt = $blog->excerpt;
	if (empty($blog_excerpt)) {
		$blog_excerpt = $blog->description;
	}
	
	$blog_excerpt = elgg_get_excerpt($blog_excerpt, $excerpt_length);
	
	$blog_body = elgg_format_element('h4', [], elgg_view('output/url', [
		'text' => $blog->title,
		'href' => $blog->getURL(),
		'trusted' => true,
	]));
	$blog_body .= $blog_excerpt;
	
	if ($blog->icontime) {
		$blog_image_url = $blog->getIconURL($icon_size);
	} else {
		$blog_image_url = $blog->getOwnerEntity()->getIconURL($icon_size);
	}
	
	$blog_image = elgg_view('output/url', [
		'href' => $blog->getURL(),
		'text' => elgg_view('output/img', [
			'src' => $blog_image_url,
			'alt' => $blog->title,
		]),
	]);
	
	$image_block = elgg_view_image_block($blog_image, $blog_body);
	$content .= elgg_format_element('div', ['title' => $blog->title], $image_block);
}

if ($sidebar) {
	echo elgg_view_module('aside', $title, $content);
} else {
	echo elgg_view_module('info', $title, $content, ['class' => 'mtm', 'id' => 'blog-tools-full-related']);
}

<?php

$entity = elgg_extract('entity', $vars);

// do we have a blog
if (!($entity instanceof ElggBlog)) {
	return;
}

// does the blog have an image
if (!$entity->icontime) {
	return;
}

$href = elgg_extract('href', $vars, $entity->getURL());
$plugin_settings = elgg_extract('plugin_settings', $vars, false);
$full_view = (bool) elgg_extract('full_view', $vars, false);

$class = ['blog_tools_blog_image'];
if (isset($vars['class'])) {
	$class[] = $vars['class'];
}

$image_params = [
	'alt' => $entity->title,
	'class' => elgg_extract('img_class', $vars, ''),
];

// which view
if (empty($plugin_settings)) {
	// default image behaviour
	$image_params['src'] = $entity->getIconURL(elgg_extract('size', $vars, 'medium'));
} elseif ($full_view) {
	// full view of a blog
	static $blog_tools_full_image_size;
	static $blog_tools_full_image_align;
	
	if (!isset($blog_tools_full_image_align)) {
		$blog_tools_full_image_align = 'right';
	
		$setting = elgg_get_plugin_setting('full_align', 'blog_tools');
		if (!empty($setting)) {
			$blog_tools_full_image_align = $setting;
		}
	}
	
	if ($blog_tools_full_image_align === 'none') {
		// no image
		echo ' ';
		return;
	}
	
	if (!isset($blog_tools_full_image_size)) {
		$blog_tools_full_image_size = 'large';
		
		$setting = elgg_get_plugin_setting('full_size', 'blog_tools');
		if (!empty($setting)) {
			$blog_tools_full_image_size = $setting;
		}
	}
	
	$href = false;
	$image_params['src'] = $entity->getIconURL($blog_tools_full_image_size);
	
	$class[] = "blog-tools-blog-image-{$blog_tools_full_image_size}";
	
	if ($blog_tools_full_image_size !== 'master') {
		if ($blog_tools_full_image_align === 'right') {
			$class[] = 'float-alt';
		} else {
			$class[] = 'float';
		}
	}
} else {
	// listing view of a blog
	// full view of a blog
	static $blog_tools_lising_image_size;
	static $blog_tools_listing_image_align;
	
	if (!isset($blog_tools_listing_image_align)) {
		$blog_tools_listing_image_align = 'right';
	
		$setting = elgg_get_plugin_setting('listing_align', 'blog_tools');
		if (!empty($setting)) {
			$blog_tools_listing_image_align = $setting;
		}
	}
	
	if ($blog_tools_listing_image_align === 'none') {
		// no image
		echo ' ';
		return;
	}
	
	if (!isset($blog_tools_lising_image_size)) {
		$blog_tools_lising_image_size = 'small';
		
		$setting = elgg_get_plugin_setting('listing_size', 'blog_tools');
		if (!empty($setting)) {
			$blog_tools_lising_image_size = $setting;
		}
	}
	
	$image_params['src'] = $entity->getIconURL($blog_tools_lising_image_size);
	
	$class[] = "blog-tools-blog-image-{$blog_tools_lising_image_size}";
	
	if ($blog_tools_listing_image_align === 'right') {
		$class[] = 'float-alt';
	} else {
		$class[] = 'float';
	}
}

$image = elgg_view('output/img', $image_params);

$content = $image;
if (!empty($href)) {
	$params = [
		'href' => $href,
		'text' => $image,
		'is_trusted' => true,
		'class' => elgg_extract('link_class', $vars, ''),
	];
	
	$content = elgg_view('output/url', $params);
}

echo elgg_format_element('div', ['class' => $class], $content);

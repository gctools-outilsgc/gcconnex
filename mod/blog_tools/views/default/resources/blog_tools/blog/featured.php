<?php
/**
 * list featured blogs
 */

// title button
elgg_register_title_button();

// breadcrumb
$title = elgg_echo('status:featured');

elgg_push_breadcrumb(elgg_echo('blog:blogs'), 'blog/all');
elgg_push_breadcrumb($title);

// build page elements
$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'full_view' => false,
	'metadata_name_value_pairs' => [
		[
			'name' => 'status',
			'value' => 'published',
		],
		[
			'name' => 'featured',
			'value' => '0',
			'operand' => '>',
		],
	],
	'no_results' => elgg_echo('blog:none'),
];

$content = elgg_list_entities_from_metadata($options);

$sidebar = elgg_view('blog/sidebar', [
	'page' => 'featured',
]);

// build page
$body = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar,
	'filter_context' => 'featured',
]);

// draw page
echo elgg_view_page($title, $body);

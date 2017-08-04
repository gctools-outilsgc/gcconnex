<?php
/**
 * shows a navigation to prvious and next blog in the same container
 *
 * @uses $vars['entity'] the blog to base the navigation on
 * @uses $vars['full_view'] only do stuff in full view
 */

if (!elgg_extract('full_view', $vars, false)) {
	return;
}

if (elgg_get_plugin_setting('show_full_navigation', 'blog_tools') !== 'yes') {
	return;
}

$entity = elgg_extract('entity', $vars);

$previous_link = '';
$next_link = '';

// get previous blog
$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'container_guid' => $entity->getContainerGUID(),
	'created_time_upper' => $entity->time_created,
	'wheres' => [
		"(e.guid <> {$entity->getGUID()})",
	],
	'limit' => 1,
];

$previous = elgg_get_entities($options);
if (!empty($previous)) {
	$previous_link = elgg_view('output/url', [
		'text' => '&laquo; ' . elgg_echo('previous'),
		'title' => $previous[0]->title,
		'href' => $previous[0]->getURL(),
		'is_trusted' => true,
		'class' => 'float',
	]);
}

// get next blog
$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'container_guid' => $entity->getContainerGUID(),
	'created_time_lower' => $entity->time_created,
	'order_by' => 'e.time_created ASC',
	'wheres' => [
		"(e.guid <> {$entity->getGUID()})",
	],
	'limit' => 1,
];

$next = elgg_get_entities($options);
if (!empty($next)) {
	$next_link = elgg_view('output/url', [
		'text' => elgg_echo('next') . ' &raquo;',
		'title' => $next[0]->title,
		'href' => $next[0]->getURL(),
		'is_trusted' => true,
		'class' => 'float-alt',
	]);
}

if (!empty($previous_link) || !empty($next_link)) {
	echo elgg_format_element('div', ['class' => 'elgg-pagination clearfix'], $next_link . $previous_link);
}

<?php

$endpoint = get_input('endpoint', 'pageshell');

if ($endpoint == 'pageshell') {
	return false;
}

$sidebar_content = elgg_extract('sidebar', $vars, '');
$params = $vars;
$params['content'] = $sidebar_content;
$sidebar = elgg_view('page/layouts/content/sidebar', $params);

// allow page handlers to override the default header
if (isset($vars['header'])) {
	$vars['header_override'] = $vars['header'];
}
$header = elgg_view('page/layouts/content/header', $vars);

// allow page handlers to override the default filter
if (isset($vars['filter'])) {
	$vars['filter_override'] = $vars['filter'];
}
$filter = elgg_view('page/layouts/content/filter', $vars);

// the all important content
$content = elgg_extract('content', $vars, '');

// optional footer for main content area
$footer_content = elgg_extract('footer', $vars, '');
$params = $vars;
$params['content'] = $footer_content;
$footer = elgg_view('page/layouts/content/footer', $params);

$body = $header . $filter . $content . $footer;

$params = array(
	'header' => $header,
	'filter' => $filter,
	'content' => $content,
	'footer' => $footer,
	'sidebar' => $sidebar,
);

if (isset($vars['class'])) {
	$params['class'] = $vars['class'];
}
echo elgg_view_layout('one_sidebar', $params);

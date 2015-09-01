<?php

$title = elgg_echo('hj:forum:dashboard:bookmarks');

elgg_push_breadcrumb($title);

$filter = elgg_view('framework/forum/dashboard/filter', array(
	'filter_context' => 'bookmarks'
));

$content = elgg_view('framework/forum/dashboard/bookmarks');

$sidebar = elgg_view('framework/forum/dashboard/sidebar', array(
	'dashboard' => 'bookmarks'
));

$layout = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => $filter,
	'content' => $content,
	'sidebar' => $sidebar,
	'class' => 'hj-forum-dashboard'
));

echo elgg_view_page($title, $layout);
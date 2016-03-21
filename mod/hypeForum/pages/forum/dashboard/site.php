<?php

hj_forum_register_dashboard_title_buttons('site');

$title = elgg_echo('hj:forum:dashboard:site');

elgg_push_breadcrumb($title);

$filter = elgg_view('framework/forum/dashboard/filter', array(
	'filter_context' => 'site'
));

$content = elgg_view('framework/forum/dashboard/site');

$sidebar = elgg_view('framework/forum/dashboard/sidebar', array(
	'dashboard' => 'site'
));

$layout = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => $filter,
	'content' => $content,
	'sidebar' => $sidebar,
	'class' => 'hj-forum-dashboard'
));

echo elgg_view_page($title, $layout);
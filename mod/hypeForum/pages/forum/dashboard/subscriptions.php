<?php

$title = elgg_echo('hj:forum:dashboard:subscriptions');

elgg_push_breadcrumb($title);

$filter = elgg_view('framework/forum/dashboard/filter', array(
	'filter_context' => 'subscriptions'
));

$content = elgg_view('framework/forum/dashboard/subscriptions');

$sidebar = elgg_view('framework/forum/dashboard/sidebar', array(
	'dashboard' => 'subscriptions'
));

$layout = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => $filter,
	'content' => $content,
	'sidebar' => $sidebar,
	'class' => 'hj-forum-dashboard'
));

echo elgg_view_page($title, $layout);
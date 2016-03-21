<?php

gatekeeper();

elgg_set_context('groups');

hj_forum_register_dashboard_title_buttons('groups');

$title = elgg_echo('hj:forum:dashboard:groups');

elgg_push_breadcrumb($title);

$filter = elgg_view('framework/forum/dashboard/filter', array(
	'filter_context' => 'groups'
));

$content = elgg_view('framework/forum/dashboard/groups');

$sidebar = elgg_view('framework/forum/dashboard/sidebar', array(
	'dashboard' => 'groups'
));

$layout = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => $filter,
	'content' => $content,
	'sidebar' => $sidebar,
	'class' => 'hj-forum-dashboard'
));

echo elgg_view_page($title, $layout);
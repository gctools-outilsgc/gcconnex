<?php

hj_forum_register_dashboard_title_buttons('group');

$group = elgg_get_page_owner_entity();
$title = elgg_echo('hj:forum:dashboard:group', array($group->name));

elgg_push_breadcrumb($title);

$content = elgg_view('framework/forum/dashboard/group');
if (!$content) $content = elgg_view_module('popup','Notice', '<strong>'.elgg_echo('c_hj:forum:nocategories').'</strong>');//$content = '<div> asdf </div>';

$sidebar = elgg_view('framework/forum/dashboard/sidebar', array(
	'dashboard' => 'group'
));

$layout = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => false,
	'content' => $content,
	'sidebar' => $sidebar,
	'class' => 'hj-forum-dashboard'
));

echo elgg_view_page($title, $layout);
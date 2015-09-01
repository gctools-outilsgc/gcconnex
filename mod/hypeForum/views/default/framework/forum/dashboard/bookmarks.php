<?php

$list_id = "forumbookmarks";

$dbprefix = elgg_get_config('dbprefix');
$getter_options = array(
	'types' => 'object',
	'subtypes' => array('hjforumtopic'),
	'relationship' => 'bookmarked',
	'relationship_guid' => elgg_get_logged_in_user_guid(),
);

$list_options = array(
	'list_type' => 'table',
	'list_class' => 'hj-forumlist',
	'list_view_options' => array(
		'table' => array(
			'head' => array(
				'forum' => array(
					'text' => elgg_echo('hj:forum:tablecol:forum'),
					'sortable' => true,
					'sort_key' => 'oe.title',
				),
				'posts' => array(
					'text' => elgg_echo('hj:forum:tablecol:posts'),
					'sortable' => true,
					'sort_key' => 'forum.posts'
				),
				'last_post' => array(
					'text' => elgg_echo('hj:forum:tablecol:last_post'),
					'sortable' => true,
					'sort_key' => 'e.last_action'
				),
				'menu' => array(
					'text' => '',
					'sortable' => false
				),
			)
		)
	),
	'pagination' => true
);


$viewer_options = array(
	'full_view' => true
);

elgg_push_context('groups');
$content .= hj_framework_view_list($list_id, $getter_options, $list_options, $viewer_options, 'elgg_get_entities_from_relationship');
elgg_pop_context();

$module = elgg_view_module('forum-category', $title, $content);

echo $module;
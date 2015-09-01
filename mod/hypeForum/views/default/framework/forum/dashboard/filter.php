<?php

$filter_context = elgg_extract('filter_context', $vars, 'site');

$tabs = array(
	'site' => array(
		'text' => elgg_echo('hj:forum:dashboard:tabs:site'),
		'href' => 'forum/dashboard/site',
		'selected' => ($filter_context == 'site'),
		'priority' => 100,
	),
	'groups' => (HYPEFORUM_GROUP_FORUMS && elgg_is_logged_in()) ? array(
		'text' => elgg_echo('hj:forum:dashboard:tabs:groups'),
		'href' => 'forum/dashboard/groups',
		'selected' => ($filter_context == 'groups'),
		'priority' => 200,
	) : null,
	'bookmarks' => (HYPEFORUM_BOOKMARKS && elgg_is_logged_in()) ? array(
		'text' => elgg_echo('hj:forum:dashboard:tabs:bookmarks'),
		'href' => 'forum/dashboard/bookmarks',
		'selected' => ($filter_context == 'bookmarks'),
		'priority' => 300,
	) : null,
	'subscriptions' => (HYPEFORUM_SUBSCRIPTIONS && elgg_is_logged_in()) ? array(
		'text' => elgg_echo('hj:forum:dashboard:tabs:subscriptions'),
		'href' => 'forum/dashboard/subscriptions',
		'selected' => ($filter_context == 'subscriptions'),
		'priority' => 400,
	) : null,
);

foreach ($tabs as $name => $tab) {
	if ($tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

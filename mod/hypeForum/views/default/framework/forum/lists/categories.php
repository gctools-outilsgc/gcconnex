<?php

$list_id = elgg_extract('list_id', $vars, "forumlist");
$container_guids = elgg_extract('container_guids', $vars, ELGG_ENTITIES_ANY_VALUE);
$subtypes = elgg_extract('subtypes', $vars, ELGG_ENTITIES_ANY_VALUE);

$title = false;

$getter_options = array(
	'types' => 'object',
	'subtypes' => $subtypes,
	'container_guids' => $container_guids,
);

$list_options = array(
	'list_type' => 'list',
	'list_class' => 'forum-category-list',
	'pagination' => true
);

$viewer_options = array(
	'full_view' => true
);

if (!get_input("__ord_$list_id", false)) {
	set_input("__ord_$list_id", 'md.priority');
	set_input("__dir_$list_id", 'ASC');
}

$content .= hj_framework_view_list($list_id, $getter_options, $list_options, $viewer_options, 'elgg_get_entities');

echo elgg_view_module('forum-category', $title, $content);
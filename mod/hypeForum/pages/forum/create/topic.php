<?php

$container_guid = get_input('container_guid');

$ancestry = hj_framework_get_ancestry($container_guid);

foreach ($ancestry as $ancestor) {
	if (elgg_instanceof($ancestor, 'site')) {
		// do nothing
	} else if (elgg_instanceof($ancestor, 'group')) {
		elgg_set_page_owner_guid($ancestor->guid);
		elgg_push_breadcrumb($ancestor->name, $ancestor->getURL());
	} else if (elgg_instanceof($ancestor, 'object')) {
		elgg_push_breadcrumb($ancestor->title, $ancestor->getURL());
	}
}

$title = elgg_echo('hj:forum:create:topic');

elgg_push_breadcrumb($title);

$content = elgg_view('forms/edit/object/hjforumtopic', array(
	'container_guid' => $container_guid
		));

$layout = elgg_view_layout('one_sidebar', array(
	'title' => $title,
	'content' => $content,
		));

echo elgg_view_page($title, $layout);

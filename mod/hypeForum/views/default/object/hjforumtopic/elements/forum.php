<?php

$entity = elgg_extract('entity', $vars);

if (HYPEFORUM_FORUM_TOPIC_ICON && isset($entity->icon)) {
	$config = elgg_get_config('icon_sizes');
	$icon = elgg_view('output/img', array(
		'src' => elgg_get_site_url() . 'mod/hypeForum/graphics/forumtopic/' . $entity->icon . '.png',
		'height' => $config['tiny']['h'],
		'width' => $config['tiny']['w']
			));
}

if (elgg_in_context('groups') && !elgg_instanceof(elgg_get_page_owner_entity(), 'group')) {
	$breadcrumbs = elgg_view('framework/bootstrap/object/elements/breadcrumbs', $vars);
}

$title = elgg_view('framework/bootstrap/object/elements/title', $vars);

if (HYPEFORUM_STICKY && $entity->isSticky()) {
	$icon = elgg_view('output/img', array(
		'src' => elgg_get_site_url() . 'mod/hypeForum/graphics/forumtopic/sticky.png',
		'height' => $config['tiny']['h'],
		'width' => $config['tiny']['w'],
		'title' => elgg_echo('hj:forum:sticky')
			));
}

$description = elgg_view('framework/bootstrap/object/elements/briefdescription', $vars);

echo $breadcrumbs;
echo elgg_view_image_block($icon, $title . $description, array(
	'class' => 'hj-forum-details hj-forum-topic-details'
));
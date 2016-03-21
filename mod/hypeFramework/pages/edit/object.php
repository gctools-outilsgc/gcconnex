<?php

$guid = get_input('guid');
$entity = get_entity($guid);

if (!elgg_instanceof($entity)) {
	return false;
}

$ancestry = hj_framework_get_ancestry($entity->guid);

foreach ($ancestry as $ancestor) {
	if (elgg_instanceof($ancestor, 'site')) {
		// do nothing
	} else if (elgg_instanceof($ancestor, 'group')) {
		elgg_push_breadcrumb($ancestor->name, $ancestor->getURL());
	} else if (elgg_instanceof($ancestor, 'object')) {
		elgg_push_breadcrumb($ancestor->title, $ancestor->getURL());
	}
}

$type = $entity->getType();
$subtype = $entity->getSubtype();

$title = elgg_echo('hj:framework:edit:object', array(elgg_echo("item:$type:$subtype")));

elgg_push_breadcrumb($title);

$content = hj_framework_view_form("edit:$type:$subtype", array(
	'entity' => $entity,
		));

$layout = elgg_view_layout('one_sidebar', array(
	'title' => $title,
	'content' => $content,
		));

echo elgg_view_page($title, $layout);


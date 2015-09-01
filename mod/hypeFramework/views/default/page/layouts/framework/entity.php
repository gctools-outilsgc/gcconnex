<?php

$entity = elgg_extract('entity', $vars, false);

if (!elgg_instanceof($entity)) {
	return true;
}

$ancestry = hj_framework_get_ancestry($entity->guid);
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

$title = strip_tags($entity->title);
elgg_push_breadcrumb($title, $entity->getURL());

if (isset($vars['context_nav']) && is_array($vars['context_nav'])) {
	foreach ($vars['context_nav'] as $bc => $link) {
		elgg_push_breadcrumb($bc, $link);
	}
}

$title = elgg_view_title($title, array('class' => 'elgg-heading-main'));
$type = $entity->getType();
$subtype = $entity->getSubtype();

$buttons = elgg_view_menu('title', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
	'entity' => $entity
		));

$header = <<<HTML
<div class="elgg-head clearfix">
	$title$buttons
</div>
HTML;

$entity->views++;

$params = array(
	'title' => $title . $menu,
	'content' => (!empty($vars['content'])) ? $vars['content'] : elgg_view_entity($entity, array(
				'full_view' => true
			)),
	'filter' => false,
	'header_override' => $header,
	'class' => "elgg-layout-entity-$type-$subtype"
);

$params = array_merge($vars, $params);

echo elgg_view_layout('content', $params);
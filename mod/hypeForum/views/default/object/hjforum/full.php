<?php

$entity = $vars['entity'];

if (!elgg_instanceof($entity, 'object', 'hjforum'))
	return true;

if (HYPEFORUM_FORUM_COVER) {
	echo elgg_view('framework/bootstrap/object/elements/cover', $vars);
}

echo elgg_view('framework/bootstrap/object/elements/description', $vars);

if (HYPEFORUM_CATEGORIES && $entity->enable_subcategories) {
	$options = array(
		'types' => 'object',
		'subtypes' => 'hjforumcategory',
		'limit' => 0,
		'container_guid' => $entity->guid
	);

	$options = hj_framework_get_order_by_clause('md.priority', 'ASC', $options);

	$categories = elgg_get_entities($options);

	if ($categories) {
		echo elgg_view_entity_list($categories, array(
			'list_class' => 'forum-category-list'
		));
	} else if ($entity->canWriteToContainer(0, 'object', 'hjforumcategory')) {
		
		//echo '<div class="hj-framework-warning">' . elgg_echo('hj:forum:nocategories') . '</div>';
		// cyu - 01/23/2015: this notice needs to be emphasized
		echo elgg_view_module('popup', 'Notice', '<strong>'.elgg_echo('hj:forum:nocategories').'</strong>');

		echo elgg_view('forms/edit/object/hjforumcategory', array(
			'container_guid' => $entity->guid
		));
	}
} else {
	$params = array(
		'list_id' => "ft$entity->guid",
		'container_guids' => array($entity->guid),
		'subtypes' => array('hjforum', 'hjforumtopic')
	);
	echo elgg_view('framework/forum/lists/forums', $params);
}
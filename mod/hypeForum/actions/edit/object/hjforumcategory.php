<?php

$result = hj_framework_edit_object_action();

if ($result) {
	$entity = elgg_extract('entity', $result);
	$container = $entity->getContainerEntity();

	// Grab all uncategorized forum posts and add them to this category, as it's obviously the first one in this container
	$dbprefix = elgg_get_config('dbprefix');
	$getter_options = array(
		'types' => 'object',
		'subtypes' => array('hjforum', 'hjforumtopic'),
		'container_guid' => $container->guid,
		'wheres' => array("NOT EXISTS (
 			SELECT 1 FROM {$dbprefix}entity_relationships
 				WHERE guid_one = e.guid
 				AND relationship = 'filed_in'
 		)"),
		'limit' => 0,
		'count' => true
	);

	$count = elgg_get_entities($getter_options);
	if ($count) {

		$getter_options['count'] = false;
		$uncategorized = elgg_get_entities($getter_options);
		foreach ($uncategorized as $e) {
			$e->setCategory($entity->guid);
		}
	}

	if (elgg_is_xhr()) {

		elgg_set_viewtype('default');
		$view = "<li id=\"elgg-object-{$entity->guid}\" class=\"elgg-item\">";
		$view .= elgg_view_entity($entity);
		$view .= '</li>';

		print json_encode(array('guid' => $entity->guid, 'view' => $view));
	}
	forward($result['forward']);
} else {
	forward(REFERER);
}

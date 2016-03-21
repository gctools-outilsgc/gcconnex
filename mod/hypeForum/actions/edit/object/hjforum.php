<?php

$result = hj_framework_edit_object_action();

if ($result) {

	$entity = elgg_extract('entity', $result);

	if (elgg_is_xhr()) {
		print json_encode(array('guid' => $entity->guid));
	}
	
	// Check to see if the forum subcategories are enabled
	// If no categories are enabled forward to a category creation form
	if (HYPEFORUM_CATEGORIES && $entity->enable_subcategories && !$entity->hasCategories('hjforumcategory')) {
		forward("forum/create/category/{$entity->guid}");
	} else {
		forward($result['forward']);
	}
} else {
	forward(REFERER);
}

<?php

$result = hj_framework_edit_object_action();

if ($result) {
	$entity = elgg_extract('entity', $result);
	if (elgg_is_xhr()) {
		print json_encode(array('guid' => $entity->guid));
	}

	forward("framework/file/view/$entity->guid", 'action');
} else {
	forward(REFERER, 'action');
}

<?php

/**
 * Edit an entity using logic of a previously defined form
 */
$result = hj_framework_edit_object_action();

if ($result) {
	if (elgg_is_xhr()) {
		print json_encode(array('guid' => $result['entity']->guid));
	}
	forward($result['forward'], 'action');
} else {
	forward(REFERER, 'action');
}

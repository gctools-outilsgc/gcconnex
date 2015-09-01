<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity)
	return true;

$ancestry = hj_framework_get_ancestry($entity->guid);
if (empty($ancestry)) {
	return true;
}

foreach ($ancestry as $ancestor) {
	if (!elgg_instanceof($ancestor, 'site') && !elgg_instanceof($ancestor, 'user')) {
		if (elgg_instanceof($ancestor, 'group')) {
			$breadcrumbs[] = elgg_view('framework/bootstrap/group/elements/name', array('entity' => $ancestor));
		} else {
			$breadcrumbs[] = elgg_view('framework/bootstrap/object/elements/title', array('entity' => $ancestor));
		}
	}
}

if (!empty($breadcrumbs)) {
	$breadcrumbs = implode(' &#9656; ', $breadcrumbs);
	echo '<span class="elgg-entity-breadcrumbs">';
	echo $breadcrumbs;
	echo '</span>';
}
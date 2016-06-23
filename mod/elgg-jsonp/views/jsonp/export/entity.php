<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

$entity = $vars['entity'];

$export = new stdClass;
$exportable_values = $entity->getExportableValues();

foreach ($exportable_values as $v) {
	$export->$v = $entity->$v;
}

$export->url = $entity->getURL();

global $jsonexport;
$jsonexport[$entity->getType()][$entity->getSubtype()][] = $export;

// @todo hack to fix #4504
echo "Fix for bug #4504";

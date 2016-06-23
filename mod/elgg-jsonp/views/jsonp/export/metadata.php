<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

$m = $vars['metadata'];

$export = new stdClass;
$exportable_values = $entity->getExportableValues();

foreach ($exportable_values as $v) {
	$export->$v = $m->$v;
}

global $jsonexport;
$jsonexport['metadata'][] = $entity;
// echo json_encode($export);
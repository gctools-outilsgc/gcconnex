<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

$r = $vars['relationship'];

$export = new stdClass;

$exportable_values = $entity->getExportableValues();

foreach ($exportable_values as $v) {
	$export->$v = $r->$v;
}

global $jsonexport;
$jsonexport['relationships'][] = $export;
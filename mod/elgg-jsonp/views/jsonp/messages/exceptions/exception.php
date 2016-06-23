<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

$export = $vars['object'];

global $jsonexport;
$jsonexport['exceptions'][] = $export;
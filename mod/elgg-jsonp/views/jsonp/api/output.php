<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

$result = $vars['result'];
$export = $result->export();

global $jsonexport;

// with api calls, we don't want extra baggage found in other json views
// so we skip the associative array
$jsonexport = $export;
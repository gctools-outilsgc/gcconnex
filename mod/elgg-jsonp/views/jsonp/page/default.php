<?php
/**
 * Elgg JSONP output pageshell
 *
 */

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header('Cache-Control: no-cache, must-revalidate');
header("Pragma: no-cache");
header('Content-type: application/x-javascript; charset=UTF-8');

// Handle various expected sets of callback variable
if (!($callback = get_input('callback'))) {
    if (!($callback = get_input('jsonp'))) {
	$callback = 'response';
    }
}

global $jsonexport;
echo $callback . "(".json_encode($jsonexport).")";
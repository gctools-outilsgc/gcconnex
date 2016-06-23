<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

global $jsonexport;

if (!isset($jsonexport['activity'])) {
	$jsonexport['activity'] = array();
}

$item = $vars['item'];
if (elgg_view_exists($item->view, 'default')) {
	$item->string = elgg_view('river/elements/summary', array('item' => $item), FALSE, FALSE, 'default');
}

$jsonexport['activity'][] = $vars['item'];

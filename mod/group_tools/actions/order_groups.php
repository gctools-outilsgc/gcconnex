<?php

/**
* Group Tools
*
* jQuery actions to order groups
* 
* @author ColdTrick IT Solutions
*/	

$guids = get_input('guids');
$order = 1;

if (empty($guids) || !is_array($guids)) {
	forward(REFERER);
}

foreach ($guids as $guid) {
	$group = get_entity($guid);
	if (!($group instanceof ElggGroup)) {
		continue;
	}
	
	$group->order = $order;
	$order++;
}

<?php
/**
 * jQuery actions to order groups
 */

$guids = get_input("guids");
$order = 1;

if (!empty($guids) && is_array($guids)) {
	foreach ($guids as $guid) {
		$group = get_entity($guid);
		if (!empty($group) && elgg_instanceof($group, "group")) {
			$group->order = $order;
			$order++;
		}
	}
}

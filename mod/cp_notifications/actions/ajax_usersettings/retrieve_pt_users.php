<?php

/*
 * retrieve / remove provincial or territorial users from list
 */

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$entry = (string)get_input('usr_entry');


$pt_departments = elgg_get_plugin_setting('cp_pt_information','cp_notifications');
$pt_departments = explode(',',$pt_departments);
$pt_departments[] = $entry; 

foreach ($pt_departments as $dept_info)
	$display .= "<div>{$dept_info}</div>";

$pt_departments = implode(',',$pt_departments);

elgg_set_plugin_setting('cp_pt_information', $pt_departments, 'cp_notifications');

echo json_encode([
	'departments' => $display,
]);
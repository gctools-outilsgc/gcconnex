<?php
/**
 * Members navigation
 */

// cyu - modified 02-13-2015: overwrites the existing view to include the navigation option tab in members page
$tabs = array(
	'popular' => array(
		'title' => elgg_echo('members:label:popular'),
		'url' => "members/popular",
		'selected' => $vars['selected'] == 'popular',
	),
	'department' => array(
		'title' => elgg_echo('c_bin:department'),
		'url' => "members/department",
		'selected' => $vars['selected'] == 'department',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));

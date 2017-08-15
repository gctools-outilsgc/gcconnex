<?php

/**
 * Group Tools
 *
 * Show tabs on the group edit form
 *
 * @author ColdTrick IT Solutions
 * 
 */
$group = elgg_extract('entity', $vars);

if (!$group && elgg_get_plugin_setting('simple_create_form', 'group_tools') == 'yes') {
	return;
}

// load js
elgg_require_js('group_tools/group_edit_tabbed');

// make tabs
$tabs = [
	'profile' => [
		'text' => elgg_echo('group_tools:group:edit:profile'),
		'href' => '#group-tools-group-edit-profile',
		'priority' => 100,
		'selected' => true,
	],
	'access' => [
		'text' => elgg_echo('group_tools:group:edit:access'),
		'href' => '#group-tools-group-edit-access',
		'priority' => 150,
	],
	'tools' => [
		'text' => elgg_echo('group_tools:group:edit:tools'),
		'href' => '#group-tools-group-edit-tools',
		'priority' => 200,
	],
];

if ($group instanceof ElggGroup) {
	$tabs['other'] = [
		'text' => elgg_echo('group_tools:group:edit:other'),
		'href' => '#other',
		'priority' => 300,
	];
}

// register menu items
foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;
	
	elgg_register_menu_item('filter', $tab);
}

echo elgg_format_element('div', ['id' => 'group-tools-group-edit-tabbed'], elgg_view_menu('filter', [
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]));

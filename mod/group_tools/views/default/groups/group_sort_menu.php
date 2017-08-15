<?php
/**
 * All groups listing page navigation
 *
 * - ColdTrick: removed some of the default tabs
 * - ColdTrick: added more information to the menu so hooks can pickup
 */

$tabs = [
	'featured' => [
		'text' => elgg_echo('status:featured'),
		'href' => 'groups/all?filter=featured',
		'priority' => 850,
	],
];

if (elgg_is_active_plugin('discussions')) {
	$tabs['discussion'] = [
		'text' => elgg_echo('discussion:latest'),
		'href' => 'groups/all?filter=discussion',
		'priority' => 400,
	];
}

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;

	if ($vars['selected'] == $name) {
		$tab['selected'] = true;
	}

	elgg_register_menu_item('filter', $tab);
}

elgg_push_context('group_sort_menu');

echo elgg_view_menu('filter', [
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz group-tools-group-sort-menu',
	'handler' => 'groups',
	'selected' => elgg_extract('selected', $vars),
]);

elgg_pop_context();

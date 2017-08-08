<?php
/**
 * Search in TheWire
 */

$query = get_input('query', get_input('q'));

elgg_push_breadcrumb(elgg_echo('thewire'), 'thewire/all');
elgg_push_breadcrumb(elgg_echo('thewire_tools:search:title:no_query'));

if (!empty($query)) {
	$options = [
		'types' => 'object',
		'subtypes' => 'thewire',
		'pagination' => true,
		'joins' => ['JOIN ' . elgg_get_config('dbprefix') . 'objects_entity oe ON e.guid = oe.guid'],
		'no_results' => elgg_echo('notfound'),
	];
	
	$where_options = explode(' ', $query);
	if (!empty($where_options)) {
		$wheres = [];
		foreach ($where_options as $wo) {
			$wheres[] = "oe.description LIKE '%" . sanitise_string($wo) . "%'";
		}
		
		if (!empty($wheres)) {
			$options['wheres'] = '(' . implode(' AND ', $wheres) . ')';
		}
	}
	
	$result = elgg_list_entities($options);
		
	// set title
	$title_text = elgg_echo('thewire_tools:search:title', [$query]);
} else {
	$title_text = elgg_echo('thewire_tools:search:title:no_query');
	$result = elgg_echo('thewire_tools:search:no_query');
}

//build search form
$form_vars = [
	'id' => 'thewire_tools_search_form',
	'action' => 'thewire/search',
	'disable_security' => true,
	'method' => 'GET',
];
$body_vars = ['query' => $query];

$form = elgg_view_form('thewire/search', $form_vars , $body_vars);

// build page
$body = elgg_view_layout('one_sidebar', [
	'title' => $title_text,
	'content' => $form . $result,
]);

// Display page
echo elgg_view_page($title_text,$body);

<?php

$widget = elgg_extract('entity', $vars);

// get widget settings
$count = (int) $widget->wire_count;
$filter = $widget->filter;

if ($count < 1) {
	$count = 8;
}

$options = [
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => $count,
	'full_view' => false,
	'pagination' => false,
];

if (!empty($filter)) {
	$filters = string_to_tag_array($filter);
	$filters = array_map('sanitise_string', $filters);
	
	$options['joins'] = ['JOIN ' . elgg_get_config('dbprefix') . 'objects_entity oe ON oe.guid = e.guid'];
	$options['wheres'] = ["(oe.description LIKE '%" . implode("%' OR oe.description LIKE '%", $filters) . "%')"];
}

// show add form
if (elgg_is_logged_in() && (elgg_get_plugin_setting('extend_widgets', 'thewire_tools') !== 'no')) {
	echo elgg_view_form('thewire/add');
}

// list content
$content = elgg_list_entities($options);
if (empty($content)) {
	echo elgg_echo('thewire_tools:no_result');
	return;
}
	
echo $content;
$more_link = elgg_view('output/url', [
	'href' => 'thewire/all',
	'text' => elgg_echo('thewire:moreposts'),
	'is_trusted' => true,
]);
echo elgg_format_element('div', ['class' => 'elgg-widget-more'], $more_link);

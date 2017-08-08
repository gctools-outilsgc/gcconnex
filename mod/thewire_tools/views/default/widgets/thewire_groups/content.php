<?php

$widget = elgg_extract('entity', $vars);
$group = $widget->getOwnerEntity();

$count = (int) $widget->wire_count;
$filter = $widget->filter;

if ($count < 1) {
	$count = 5;
}

if ($group->isMember()) {
	echo elgg_view_form('thewire/add');
}

$options = [
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => $count,
	'container_guid' => $group->getGUID(),
	'pagination' => false,
	'full_view' => false,
];

if (!empty($filter)) {
	$filters = string_to_tag_array($filter);
	$filters = array_map('sanitise_string', $filters);

	$options['joins'] = ['JOIN ' . elgg_get_config('dbprefix') . 'objects_entity oe ON oe.guid = e.guid'];
	$options['wheres'] = ["(oe.description LIKE '%" . implode("%' OR oe.description LIKE '%", $filters) . "%')"];
}

$list = elgg_list_entities($options);
if (empty($list)) {
	echo elgg_echo("thewire_tools:no_result");
	return;
}

echo $list;

$more_link = elgg_view('output/url', [
	'href' => "thewire/group/{$widget->container_guid}",
	'text' => elgg_echo('thewire:moreposts'),
	'is_trusted' => true,
]);
echo elgg_format_element('div', ['class' => 'elgg-widget-more'], $more_link);

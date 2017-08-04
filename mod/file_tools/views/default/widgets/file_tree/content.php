<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

$folder_guids = $widget->folder_guids;
if (empty($folder_guids)) {
	echo elgg_echo('widgets:file_tree:no_folders');
	return;
}

$show_content = (bool) $widget->show_content;
$toggle_contents = (bool) $widget->toggle_contents;

if (!is_array($folder_guids)) {
	$folder_guids = [$folder_guids];
}

$folder_guids = array_map('sanitise_int', $folder_guids);

$folder_options = [
	'type' => 'object',
	'subtype' => FILE_TOOLS_SUBTYPE,
	'guids' => $folder_guids,
	'container_guid' => $widget->getOwnerGUID(),
	'limit' => false,
	'full_view' => true,
	
	'show_toggle_content' => $toggle_contents,
];

if ($show_content) {
	$folder_options['item_view'] = 'object/folder/file_tree';
}

$folders = elgg_get_entities($folder_options);
if (empty($folders)) {
	echo elgg_echo('notfound');
	return;
}

if ($toggle_contents) {
	elgg_require_js('file_tools/file_tree');
}

$sorted_result = [];
/* @var $folder ElggObject */
foreach ($folders as $folder) {
	$index = array_search($folder->getGUID(), $folder_guids);
	if ($index === false) {
		// shouldn't happen
		continue;
	}
	
	$sorted_result[$index] = $folder;
}

// actualy sort the resultset
ksort($sorted_result);
// show the results
echo elgg_view_entity_list($sorted_result, $folder_options);

// more link
$more_url = '';
$owner = $widget->getOwnerEntity();
if ($owner instanceof ElggUser) {
	$more_url = "file/owner/{$owner->username}";
} elseif ($owner instanceof ElggGroup) {
	$more_url = "file/group/{$owner->getGUID()}/all";
}

if (empty($more_url)) {
	return;
}

echo elgg_format_element('div', ['class' => 'elgg-widget-more'], elgg_view('output/url', [
	'href' => $more_url,
	'text' => elgg_echo('widgets:file_tree:more'),
]));

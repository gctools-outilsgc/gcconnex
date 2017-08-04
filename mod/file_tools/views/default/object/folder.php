<?php

$folder = elgg_extract('entity', $vars);
$full_view = (bool) elgg_extract('full_view', $vars, false);
$show_toggle_content = (bool) elgg_extract('show_toggle_content', $vars, false);
if ($show_toggle_content && elgg_is_xhr()) {
	$full_view = elgg_extract('fullView', $vars, $full_view);
}

$time_preference = 'date';

if ($user_time_preference = elgg_get_plugin_user_setting('file_tools_time_display', null, 'file_tools')) {
	$time_preference = $user_time_preference;
} elseif ($site_time_preference = elgg_get_plugin_setting('file_tools_default_time_display', 'file_tools')) {
	$time_preference = $site_time_preference;
}

if ($time_preference == 'date') {
	$friendlytime = date(elgg_echo('friendlytime:date_format'), $folder->time_created);
} else {
	$friendlytime = elgg_view_friendly_time($folder->time_created);
}

$title = $folder->title;
if (empty($title)) {
	$title = elgg_echo('untitled');
}
$title = elgg_view('output/url', [
	'text' => elgg_get_excerpt($title, 100),
	'href' => $folder->getURL(),
	'is_trusted' => true,
]);

$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', [
		'entity' => $folder,
		'handler' => 'file_tools/folder',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if ($full_view) {
	
	if (elgg_in_context('widgets') && $show_toggle_content) {
		$entity_menu = elgg_view('output/url', [
			'text' => elgg_view_icon('caret-right') . elgg_view_icon('caret-down', ['class' => 'hidden']),
			'href' => 'javascript:void(0);',
			'data-guid' => $folder->getGUID(),
			'data-full-view' => 1,
			'class' => 'file-tools-file-tree-toggle-content float-alt',
		]);
	}
	
	// full view
	$icon = elgg_view_entity_icon($folder, 'small');
	
	$owner_link = elgg_view('output/url', [
		'text' => $folder->getOwnerEntity()->name,
		'href' => $folder->getOwnerEntity()->getURL(),
	]);
	$owner_text = elgg_echo('byline', [$owner_link]);
	
	$subtitle = "$owner_text $friendlytime";
	
	$params = [
		'entity' => $folder,
		'title' => $title,
		'metadata' => $entity_menu,
		'subtitle' => $subtitle,
	];
	
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	echo elgg_view('object/elements/full', [
		'entity' => $folder,
		'title' => false,
		'icon' => $icon,
		'summary' => $summary,
		'body' => elgg_view('output/longtext', ['value' => $folder->description]),
	]);
} else {
	// summary view
	$icon = elgg_view_entity_icon($folder, 'tiny');
	$icon_alt = '';
	if (!elgg_in_context('widgets')) {
		$icon_alt = elgg_view('input/checkbox', [
			'name' => 'folder_guids[]',
			'value' => $folder->getGUID(),
			'default' => false,
		]);
	} elseif ($show_toggle_content) {
		$right_class = '';
		$down_class = 'hidden';
		if (!isset($vars['items'])) {
			$right_class = 'hidden';
			$down_class = '';
		}
		$icon_alt = elgg_view('output/url', [
			'text' => elgg_view_icon('caret-right', ['class' => $right_class]) . elgg_view_icon('caret-down', ['class' => $down_class]),
			'href' => 'javascript:void(0);',
			'data-guid' => $folder->getGUID(),
			'class' => 'file-tools-file-tree-toggle-content',
		]);
	}
	
	$params = [
		'entity' => $folder,
		'title' => $title,
		'metadata' => $entity_menu,
	];
	
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $list_body, [
		'class' => 'file-tools-folder',
		'image_alt' => $icon_alt,
	]);
}

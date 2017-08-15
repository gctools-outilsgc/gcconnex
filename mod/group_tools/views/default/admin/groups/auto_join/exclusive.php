<?php

$content = elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:admin:auto_join:exclusive:description'),
]);

$output = '';
$configs = group_tools_get_auto_join_configurations();
foreach ($configs as $id => $config) {
	
	if (elgg_extract('type', $config) !== 'exclusive') {
		continue;
	}
	
	$output .= elgg_view('group_tools/elements/auto_join_configuration', [
		'config' => $config,
	]);
}

if (empty($output)) {
	$output = elgg_echo('group_tools:admin:auto_join:exclusive:none');
}

$content .= $output;

$title = elgg_view('output/url', [
	'text' => elgg_view_icon('plus-circle'),
	'href' => elgg_http_add_url_query_elements('ajax/form/group_tools/admin/auto_join/additional', [
		'type' => 'exclusive',
	]),
	'title' => elgg_echo('add'),
	'class' => [
		'float-alt',
		'elgg-lightbox',
	],
	'data-colorbox-opts' => json_encode([
		'maxWidth' => '650px',
	]),
]);
$title .= elgg_echo('group_tools:admin:auto_join:exclusive');

echo elgg_view_module('inline', $title, $content);

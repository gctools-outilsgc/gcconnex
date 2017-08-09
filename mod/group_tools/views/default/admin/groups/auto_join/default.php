<?php

$content = elgg_view('output/longtext', [
	'value' => elgg_echo('group_tools:admin:auto_join:default:description'),
]);

$auto_joins = elgg_get_plugin_setting('auto_join', 'group_tools');
if (!empty($auto_joins)) {
	$auto_joins = string_to_tag_array($auto_joins);
	
	$rows = [];
	
	// header
	$row = [];
	$row[] = elgg_format_element('th', ['style' => 'width: 40px;', 'class' => 'center'], '&nbsp;');
	$row[] = elgg_format_element('th', [], elgg_echo('groups:name'));
	
	$rows[] = elgg_format_element('tr', [], implode('', $row));
	
	$options = [
		'type' => 'group',
		'limit' => false,
		'guids' => $auto_joins,
	];
	
	$groups = new ElggBatch('elgg_get_entities', $options);
	foreach ($groups as $group) {
		$row = [];
		
		$row[] =  elgg_format_element('td', ['style' => 'width: 40px;', 'class' => 'center'], elgg_view_entity_icon($group, 'tiny'));
		$row[] = elgg_format_element('td', [], elgg_view('output/url', [
			'href' => $group->getURL(),
			'text' => $group->name,
		]));
		
		$rows[] = elgg_format_element('tr', [], implode('', $row));
	}
	
	$content .= elgg_format_element('table', ['class' => 'elgg-table-alt mtm'], implode('', $rows));
} else {
	$content .= elgg_echo('group_tools:admin:auto_join:default:none');
}

$title = elgg_view('output/url', [
	'text' => elgg_view_icon('edit'),
	'href' => 'ajax/form/group_tools/admin/auto_join/default',
	'title' => elgg_echo('edit'),
	'class' => [
		'float-alt',
		'elgg-lightbox',
	],
	'data-colorbox-opts' => json_encode([
		'maxWidth' => '650px',
	]),
]);
$title .= elgg_echo('group_tools:admin:auto_join:default');

echo elgg_view_module('inline', $title, $content);

<?php

echo elgg_view('elgg_solr/admin_nav');

elgg_register_menu_item('elgg_solr_controls', array(
	'name' => 'solr_delete_index',
	'text' => elgg_echo('elgg_solr:delete_index'),
	'href' => 'action/elgg_solr/delete_index',
	'is_action' => true,
	'is_trusted' => true,
	'link_class' => 'elgg-button elgg-button-action elgg-requires-confirmation',
	'confirm' => elgg_echo('elgg_solr:delete_index:confirm')
));

elgg_register_menu_item('elgg_solr_controls', array(
	'name' => 'solr_reindex',
	'text' => elgg_echo('elgg_solr:reindex:full'),
	'href' => 'action/elgg_solr/reindex?type=full',
	'is_action' => true,
	'is_trusted' => true,
	'link_class' => 'elgg-button elgg-button-action elgg-requires-confirmation',
	'confirm' => elgg_echo('elgg_solr:reindex:confirm')
));

if (elgg_get_plugin_setting('reindex_running', 'elgg_solr')) {
	elgg_register_menu_item('elgg_solr_controls', array(
		'name' => 'solr_reindex_unlock',
		'text' => elgg_echo('elgg_solr:reindex:unlock'),
		'href' => 'action/elgg_solr/reindex_unlock',
		'is_action' => true,
		'is_trusted' => true,
		'link_class' => 'elgg-button elgg-button-action elgg-requires-confirmation',
		'confirm' => elgg_echo('elgg_solr:reindex_unlock:confirm')
	));
}

$time = elgg_get_plugin_setting('current_log', 'elgg_solr');

$title = elgg_echo('elgg_solr:index:controls');

$body = elgg_view_menu('elgg_solr_controls', array(
	'class' => 'elgg-menu-hz',
	'item_class' => 'mrm',
));

$body .= elgg_view('elgg_solr/ajax/progress', array('time' => $time));

echo elgg_view_module('main', $title, $body);
<?php

$url = current_page_url();
$url_split = explode('?', $url);
$pieces = explode('#', array_shift($url_split)); // quick separation of query/fragment elements
$current_url = $pieces[0];

$tabs = array(
	array(
		'name' => 'settings',
		'text' => elgg_echo('Notifications Settings'),
		'href' => 'admin/plugin_settings/elgg_solr',
		'selected' => (elgg_http_url_is_identical($current_url, elgg_normalize_url('admin/plugin_settings/elgg_solr')))
	),
	array(
		'name' => 'controls',
		'text' => elgg_echo('Notifications Scripts'),
		'href' => 'admin/administer_utilities/solr_index',
		'selected' => (elgg_http_url_is_identical($current_url, elgg_normalize_url('admin/administer_utilities/solr_index')))
	)
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));